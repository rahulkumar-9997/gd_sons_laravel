<?php
namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use App\Models\WhatsappConversation;
class WhatsAppController extends Controller
{
    public function index(Request $request){
        return view('backend.manage-whatsapp.index');
    }

    public function create(Request $request){
        return view('backend.manage-whatsapp.create');
    }

    public function autocompleteProductsWhatsapp(Request $request){
        $query = $request->input('query');
        $selectedProductIds = $request->input('selected_ids', []);
        $startTime = microtime(true);
        $searchTerms = explode(' ', $query);
        $booleanQuery = '+' . implode(' +', $searchTerms);
        $products = Product::where(function($query) use ($searchTerms, $booleanQuery) {
            $query->whereRaw("MATCH(title) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery])
                ->orWhere(function ($query) use ($searchTerms) {
                    foreach ($searchTerms as $term) {
                        $query->where('title', 'like', '%' . $term . '%');
                    }
                });
        })
        ->whereNotIn('products.id', $selectedProductIds)
        ->leftJoin('inventories', function ($join) {
            $join->on('products.id', '=', 'inventories.product_id')
                ->whereRaw('inventories.mrp = (SELECT MIN(mrp) FROM inventories WHERE product_id = products.id)');
        })
        ->select(
            'products.id',
            'products.title',
            'products.hsn_code',
            'products.gst_in_per',
            'inventories.mrp',
            'inventories.offer_rate',
            'inventories.purchase_rate',
            'inventories.sku'
        )
        ->limit(15)
        ->orderBy('products.title')
        ->get();

        $endTime = microtime(true);
        $queryTime = $endTime - $startTime;

        Log::info('Autocomplete Products Query:', [
            'query' => $query,
            //'data' => $products,
            'selected_ids' => $selectedProductIds,
            'execution_time' => $queryTime . ' seconds',
        ]);

        return response()->json($products);

    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'mobile_no' => 'required|numeric|digits:10',
            'product_name' => 'required|array|min:1',
            'product_id' => 'required|array|min:1',
            'product_name.*' => 'required|string|max:255',
            'mrp' => 'required|array|min:1',
            'mrp.*' => 'required|numeric',
            'purchase_rate' => 'required|array|min:1',
            'purchase_rate.*' => 'required|numeric',
            'offer_rate' => 'required|array|min:1',
            'offer_rate.*' => 'required|numeric',
        ]);
        // if ($errors = $request->errors()) {
        //     return response()->json(['errors' => $errors], 422);
        // }
        
        $customer_name = $validatedData['name'];
        $customer_mobile_no = $validatedData['mobile_no'];
        $products = $validatedData['product_name'];
        $productsIdArray = $validatedData['product_id'];
        $mrp = $validatedData['mrp'];
        $purchase_rate = $validatedData['purchase_rate'];
        $offer_rate = $validatedData['offer_rate'];    
        $api_endpoint ='';
        $api_endpoint = "https://backend.aisensy.com/campaign/t1/api/v2";
        $apiKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY1NmYwNjVjNmE5ZjJlN2YyMTBlMjg1YSIsIm5hbWUiOiJHaXJkaGFyIERhcyBhbmQgU29ucyIsImFwcE5hbWUiOiJBaVNlbnN5IiwiY2xpZW50SWQiOiI2NDJiZmFhZWViMTg3NTA3MzhlN2ZkZjgiLCJhY3RpdmVQbGFuIjoiTk9ORSIsImlhdCI6MTcwMTc3NDk0MH0.x19Hzut7u4K9SkoJA1k1XIUq209JP6IUlv_1iwYuKMY"; 
        $data = [
            'apiKey' => $apiKey,
            'campaignName' => "Admin_Prod_Head_New",
            'destination' => $customer_mobile_no,
            'userName' => $customer_name,
            'source' => "Website Product Quotation",
            'templateParams' => [$customer_name],
            'paramsFallbackValue' => array("FirstName"=>"Customer")
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer $apiKey"
        ])->post($api_endpoint, $data);

        if (!$response->successful()) {
            return response()->json([
                'message' => 'API request for customer failed.',
                'error' => $response->body()
            ], 500);
        }
        $productPaths = [];
        $imagePathsWebp = [];
        $imagePathsJPG = [];
        foreach ($productsIdArray as $index => $product_id) {
            $product = Product::with([
                'images' => function ($query) {
                    $query->select('id', 'product_id', 'image_path')->orderBy('id');
                },
                'ProductAttributesValues' => function ($query) {
                    $query->select('id', 'product_id', 'product_attribute_id', 'attributes_value_id')
                        ->with([
                            'attributeValue:id,slug'
                        ])
                        ->orderBy('id');
                }
            ])->where('id', $product_id)->firstOrFail();
            $attributes_value = $product->ProductAttributesValues->isNotEmpty()
                ? $product->ProductAttributesValues->first()->attributeValue->slug
                : 'futura-1';
            $firstImage = $product->images->first();
            if ($firstImage && !empty($firstImage->image_path)) {
                $imageFileName = str_replace('.webp', '.jpg', $firstImage->image_path);
            
                $imagePathWebP = asset('images/product/thumb/' . $firstImage->image_path);
                $imagePathJpg = asset('images/product/jpg-image/thumb/' . $imageFileName);
                if (!file_exists(public_path('images/product/jpg-image/thumb/' . $imageFileName))) {
                    $imagePathJpg = "https://www.gdsons.co.in/public/frontend/assets/gd-img/product/no-image.png";
                }
                $imageName = basename($firstImage->image_path);
            } else {
                $imagePathWebP = null;
                $imagePathJpg = "https://www.gdsons.co.in/public/frontend/assets/gd-img/product/no-image.png";
                $imageName = 'Girdhar Das & Sons';
            }
            // $queryParams = ['color' => 'red', 'size' => 'large'];
            // $encryptedParams = Crypt::encryptString(json_encode($queryParams));
            //$product_path = url('/products/' . $product->slug . '/' . urlencode($encryptedParams));

            $product_path = url('/products/' . $product->slug .'/'. $attributes_value);
            $productPaths[] = $product_path;
            $imagePathsWebp[] = $imagePathWebP;
            $imagePathsJPG[] = $imagePathJpg;

            $product_data = [
                'apiKey' => $apiKey,
                'campaignName' => "Admin_Products_Images",
                'destination' => $customer_mobile_no,
                'userName' => $customer_name,
                'source' => "New Landing page form facebook",
                'media' => [
                    'url' => $imagePathJpg,
                    'filename' => $imageName
                ],
                'templateParams' => [
                    $product->title,
                    $mrp[$index],
                    $offer_rate[$index],
                    $product_path
                ]
            ];
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer $apiKey"
            ])->post($api_endpoint, $product_data);

            if (!$response->successful()) {
                continue;
            }
        }

        return response()->json([
            'message' => 'Message send successfully!',
            'status' => 'success',
            'product_paths' => $productPaths,
            'image_path_webp' => $imagePathsWebp,
            'image_path_jpg' => $imagePathsJPG,
        ], 200, [], JSON_UNESCAPED_SLASHES);
        
        
    }
    
    public function imageFileRename(){
        $i = 1;
        $perPage = 50;
        $page = request()->input('page', 1);
        //$products = Product::with(['images'])->paginate($perPage, ['*'], 'page', $page);
        $products = Product::with(['images'])->get();
          
        foreach ($products as $product) {
            if ($product->images->isNotEmpty()) {
                foreach ($product->images as $image) {
                    
                    if (!empty($image->image_path)) {
                        $originalImagePath = public_path('images/product/large/' . $image->image_path);
    
                        if (File::exists($originalImagePath)) {
                            $newImageName = pathinfo($image->image_path, PATHINFO_FILENAME) . '.jpg';
                            $this->saveProductImagesToJpg($originalImagePath, $newImageName);
                            echo "<table border='1'>";
                            echo "<tr><td>$i - " . htmlspecialchars($newImageName, ENT_QUOTES, 'UTF-8') . "</td></tr>";
                            echo "</table>";
    
                            $i++;
                        }
                    }
                }
            }
        }
    }

    private function saveProductImagesToJpg($imagePath, $imageFileName){
        $image = Image::make($imagePath);
        /*THUMB IMAGE (250x250)*/
        $destinationPathThumb = public_path('images/product/jpg-image/thumb/');
        File::ensureDirectoryExists($destinationPathThumb);
        $image->resize(250, 250, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->encode('jpg', 90)->save($destinationPathThumb . $imageFileName);
    }

    public function autocomplete(Request $request){
        $searchTerm = $request->input('query');
        $results = WhatsappConversation::autocomplete($searchTerm);
        return response()->json($results);
    }
       

}
