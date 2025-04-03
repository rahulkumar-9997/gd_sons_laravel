<?php
namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Log;
use App\Imports\ProductsImport;
use App\Models\Attribute;
use App\Models\Attribute_values;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Label;
use App\Models\Product;
use App\Models\ProductImages;
use App\Models\ProductAttributes;
use App\Models\ProductAttributesValues;
use App\Models\MapCategoryAttributes;
use App\Models\MapAttributesValueToCategory;
use App\Models\AdditionalFeature;
use App\Models\ProductsAdditionalFeature;
use App\Models\UpdateHsnGstWithAttributes;
use Illuminate\Support\Facades\DB;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;

class ProductsController extends Controller
{
    public function index(Request $request){
        // $data['product_list'] = Product::with(['images', 'category', 'brand', 'attributes.attribute', 'attributes.values.attributeValue'])->orderBy('id', 'desc')->get();
        // //return response()->json($data['product_list']);
        // return view('backend.product.index', compact('data'));
        $data['categories'] = Category::all(); 
        //Log::info('Request Data:', $request->all());
        $query = Product::with(
            ['images' => function ($query) {
                    $query->select('id', 'product_id', 'image_path')->orderBy('sort_order');
            }, 'category', 'brand', 'attributes.attribute', 'attributes.values.attributeValue']
        );
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        // if ($request->has('search') && $request->search) {
        //     $query->where('title', 'like', '%' . $request->search . '%'); 
        // }
        // if ($request->has('search') && $request->search) {
        //     $searchTerm = $request->search . '*'; // Add wildcard
        //     $query->whereRaw("MATCH(title) AGAINST(? IN BOOLEAN MODE)", [$searchTerm]);
        // }
        
        if ($request->has('search') && $request->search) {
            $searchTerms = explode(' ', $request->search); 
            $booleanQuery = '+' . implode(' +', $searchTerms);
        
            $query->whereRaw("MATCH(title) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery]);
            $query->orWhere(function ($query) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $query->where('title', 'like', '%' . $term . '%');
                }
            });
        }

        if ($request->has('date_range') && $request->date_range) {
            $dates = explode(' - ', $request->date_range);
            if (count($dates) === 2) {
                $query->whereBetween('created_at', [Carbon::parse($dates[0])->startOfDay(), Carbon::parse($dates[1])->endOfDay()]);
            }
        }

        if ($request->has('product_status') && is_numeric($request->product_status)) {
            $query->where('product_status', $request->product_status);
        }

        $data['product_list'] = $query->orderBy('id', 'desc')->paginate(100);
        
        if ($request->ajax()) {
            return view('backend.product.partials.product_table', compact('data'))->render();
        }
        return view('backend.product.index', compact('data'));
               
    }

    public function create(){ 
        $categoryId = request()->get('category');
        // $attributesWithValues = UpdateHsnGstWithAttributes::where('category_id', $categoryId)
        // ->with(['attribute', 'attribute.AttributesValues', 'attribute.AttributesValues.hsnGst'])
        // ->get();
        $attributesWithValues = UpdateHsnGstWithAttributes::where('category_id', $categoryId)
            ->with(['attribute', 'attribute.AttributesValues', 'attribute.AttributesValues.hsnGst'])
            ->get()
            ->groupBy(function ($item) {
                return $item->attribute->title ?? 'N/A';
            });
        $excludedTitles = $attributesWithValues->keys()->toArray();
        $data['product_attributes_list'] = Attribute::whereNotIn('title', $excludedTitles)
            ->orderBy('title', 'asc')->get();
        $data['product_category_list'] = Category::where('status', '=', 'on')->orderBy('title', 'asc')->get();
        $data['brand_list'] = Brand::where('status', '=', 'on')->orderBy('title', 'asc')->get();
        $data['label_list'] = Label::where('status', '=', 'on')->orderBy('title', 'asc')->get();
        return view('backend.product.create', compact('data', 'attributesWithValues'));
    } 

    public function getFilteredAttributes(Request $request){
        try {
            $attributeId = $request->input('attribute_id');
            Log::info('Attribute ID:', ['id' => $attributeId]);
            if (!$attributeId) {
                return response()->json(['error' => 'Attribute ID is required'], 400);
            }
            $filteredAttributes = Attribute_values::where('attributes_id', $attributeId)->get();
            return response()->json(['data' => $filteredAttributes]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function addMoreAttributesRow(){
        $response['html'] = view('backend.product.include.add-more-attributes-html')->render();
        //return response()->json(json_encode($response));
    }

    public function storeoldRemoveIt(Request $request){
        DB::enableQueryLog();
        $this->validate($request, [
            'product_name' => 'required|string|max:255',
            'product_categories' => 'required|exists:categories,id',
        ]);
        Log::info('Request Data:', $request->all());
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // DB::table('products')->truncate();
        // DB::table('product_images')->truncate();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        // Check if the product already exists by title
        $existingProduct = Product::where('title', $request->input('product_name'))->first();
        if ($existingProduct) {
            return redirect()->back()->with('error', 'Product already exists.');
        }
        $input['title'] = $request->input('product_name');
        $input['category_id'] = $request->input('product_categories');
        //$input['subcategory_id'] = $request->input('product_subcategories');
        $input['brand_id'] = $request->input('brand');
        $input['label_id'] = $request->input('label');
        $input['product_weight'] = $request->input('product_weight');
        $input['product_stock_status'] = $request->input('product_stock_status');
        $input['product_tags'] = $request->input('product_tags');
        $input['product_price'] = $request->input('product_price');
        $input['product_sale_price'] = $request->input('product_sale_price');
        if (!empty($request->input('product_status')) && $request->input('product_status') == 'on') {
            $input['product_status'] = 1;
        }else{
            $input['product_status'] = 0;
        }
        if (!empty($request->input('warranty_status')) && $request->input('warranty_status') == 'on') {
            $input['warranty_status'] = 1;
        }else{
            $input['warranty_status'] = 0;
        }
        if (!empty($request->input('attributes_show_status')) && $request->input('attributes_show_status') == 'on') {
            $input['attributes_show_status'] = 1;
        }else{
            $input['attributes_show_status'] = 1;
        }
        $input['meta_title'] = $request->input('meta_title');
        $input['meta_description'] = $request->input('meta_description');
        $input['product_description'] = $request->input('product_description');
        $input['product_specification'] = $request->input('product_specification');
        $add_product = Product::create($input);
        if($add_product){
            if ($request->hasFile('product_images')){
                $files = $request->file('product_images');
                foreach ($files as $key =>$file) {
                    $image = $file;
                    // Set timezone to Asia/Kolkata
                    date_default_timezone_set('Asia/Kolkata');
                    // Get image filename and extension
                    $filenameWithExt = $image->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = $image->getClientOriginalExtension();
                    
                    $image_name = str_replace('-', ' ', $request->input('product_name'));
                    $timestamp = now()->format('h-i-s-u');
                    $image_file_name = 'product-image-' . $image_name . '-' . $timestamp . '.webp';
                    // LARGE IMAGE (1920x1080)
                    $destination_path_large = public_path('images/product/large/');
                    $img_large = Image::make($image->getRealPath());
                    $img_large->resize(1920, 1080, function ($constraint) {
                        $constraint->aspectRatio();
                    })->encode('webp', 90)->save($destination_path_large . '/' . $image_file_name);
                    // ------------------------------
                    // SMALL IMAGE (800x600)
                    $destination_path_small = public_path('images/product/small/');
                    $img_small = Image::make($image->getRealPath());
                    $img_small->resize(800, 600, function ($constraint) {
                        $constraint->aspectRatio();
                    })->encode('webp', 90)->save($destination_path_small . '/' . $image_file_name);
                    // ------------------------------
                    // THUMB IMAGE (250x250)
                    $destination_path_thumb = public_path('images/product/thumb/');
                    $img_thumb = Image::make($image->getRealPath());
                    $img_thumb->resize(150, 150, function ($constraint) {
                        $constraint->aspectRatio();
                    })->encode('webp', 90)->save($destination_path_thumb . '/' . $image_file_name); 
                    // ------------------------------
                    // ICON IMAGE (150x150)
                    $destination_path_icon = public_path('images/product/icon/');
                    $img_icon = Image::make($image->getRealPath());
                    $img_icon->resize(150, 150, function ($constraint) {
                        $constraint->aspectRatio();
                    })->encode('webp', 90)->save($destination_path_icon . '/' . $image_file_name); 
                    // ------------------------------
                    // ORIGINAL IMAGE (save as WebP)
                    $destinationPath = public_path('images/product/original/');
                    $img_original = Image::make($image->getRealPath());
                    $img_original->encode('webp', 90)->save($destinationPath . '/' . $image_file_name); 
                    // ------------------------------
                    // Save image data into database (WebP image path)
                    $product_image_input['product_id'] = $add_product->id;
                    $product_image_input['image_path'] = $image_file_name;
                    $product_image_input['sort_order'] = $key;
                    $product_image_create = ProductImages::create($product_image_input);
                }
            }
            
            if (!empty($request->input('product_attributes'))) {
                $product_attributes_array = $request->input('product_attributes');
                $product_attributes_values = $request->input('product_attributes_value');
            
                foreach ($product_attributes_array as $key => $attributes_id) {
                    if ($attributes_id) {
                        $create_product_attribute = ProductAttributes::create([
                            'product_id' => $add_product->id,
                            'attributes_id' => $attributes_id,
                            'sort_order' => $key,
                        ]);
            
                        if (!empty($product_attributes_values[$key]) && is_array($product_attributes_values[$key])) {
                            $sr_no = 0;
                            foreach (explode(',', $product_attributes_values[$key][0]) as $attribute_value_name) {
                                $attribute_value_name = trim($attribute_value_name);
                                $attribute_value = Attribute_values::firstOrCreate(
                                    ['name' =>  $attribute_value_name, 'attributes_id' => $attributes_id],
                                    ['slug' => Str::slug($attribute_value_name)]
                                );
                                
                                /**mapped attributes value to category */
                                $mapExists = MapAttributesValueToCategory::where([
                                    'category_id' => $request->input('product_categories'),
                                    'attributes_value_id' => $attribute_value->id,
                                ])->exists();
        
                                if (!$mapExists){
                                    MapAttributesValueToCategory::create([
                                        'category_id' => $request->input('product_categories'),
                                        'attributes_value_id' => $attribute_value->id,
                                    ]);
                                }
                                /**mapped attributes value to category */
                                ProductAttributesValues::create([
                                    'product_id' => $add_product->id,
                                    'product_attribute_id' => $create_product_attribute->id,
                                    'attributes_value_id' => $attribute_value->id,
                                    'sort_order' => $sr_no,
                                ]);
                                $sr_no++;
                            }
                        }
                    }
                }
            }
            /**additional feature add start code*/
            if ($request->has('additional_feature_key')) {
                $additional_feature_key_array = $request->input('additional_feature_key');
                $additional_feature_key_value_array = $request->input('additional_feature_key_value');
                if (is_array($additional_feature_key_array) && is_array($additional_feature_key_value_array) &&
                    count($additional_feature_key_array) === count($additional_feature_key_value_array)) {
                    
                    foreach ($additional_feature_key_array as $key => $additional_feature_key) {
                        if (!empty($additional_feature_key)) {
                            $additional_feature = AdditionalFeature::firstOrCreate(
                                [
                                    'title' => $additional_feature_key,
                                ],
                                [
                                    'slug' => Str::slug($additional_feature_key)
                                ]
                            );
                            Log::info('Additional Feature First or Create:', ['additional_feature_id' => $additional_feature->id]);
                            if (!empty($additional_feature_key_value_array[$key])) {
                                $product_additional_feature = ProductsAdditionalFeature::create(
                                    [
                                        'product_id' => $add_product->id,
                                        'additional_feature_id' => $additional_feature->id,
                                        'product_additional_featur_value' => $additional_feature_key_value_array[$key],
                                        'sort_order' => $key
                                    ]
                                );
                                Log::info('Product Additional Feature:', ['product_additional_feature_id' => $product_additional_feature->id]);
                            }
                        } else {
                            Log::warning("Skipped empty additional feature key at index: $key");
                        }
                    }
                } else {
                    Log::error('Additional feature keys or values are either not arrays or their counts do not match.');
                }
            } else {
                Log::error('No additional feature keys provided in the request.');
            }
            /**additional feature add end code*/
            
            return redirect('product')->with('success','Product created successfully');
        }
        return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        
    }

    public function store(Request $request){
        DB::enableQueryLog();
        try {
            DB::beginTransaction();
            $this->validate($request, [
                'product_name' => 'required|string|max:255',
                'product_categories' => 'required|exists:category,id',
                'hsn_code' => 'nullable|regex:/^\d{4}(\d{2}){0,1}(\d{2}){0,1}$/',
                'gst_in_percentage' => 'nullable|numeric|min:0|max:100',
            ]);
            //dd( $request->all());
            Log::info('Request Data:', $request->all());
            $existingProduct = Product::where('title', $request->input('product_name'))->first();
            if ($existingProduct) {
                return redirect()->back()->with('error', 'Product already exists.');
            }
            $input = [
                'title' => $request->input('product_name'),
                'category_id' => $request->input('product_categories'),
                //'brand_id' => $request->input('brand'),
                'hsn_code' => $request->input('hsn_code'),
                'gst_in_per' => $request->input('gst_in_percentage'),
                'label_id' => $request->input('label'),
                //'product_weight' => $request->input('product_weight'),
                'product_stock_status' => $request->input('product_stock_status'),
                'product_tags' => $request->input('product_tags'),
                'product_price' => $request->input('product_price'),
                'product_sale_price' => $request->input('product_sale_price'),
                'product_status' => $request->input('product_status') == 'on' ? 1 : 0,
                'warranty_status' => $request->input('warranty_status') == 'on' ? 1 : 0,
                'attributes_show_status' => $request->input('attributes_show_status') == 'on' ? 1 : 1, 
                'meta_title' => $request->input('meta_title'),
                'meta_description' => $request->input('meta_description'),
                'product_description' => $request->input('product_description'),
                'product_specification' => $request->input('product_specification'),

            ];
            $add_product = Product::create($input);

            if ($add_product) {
                if ($request->hasFile('product_images')) {
                    $files = $request->file('product_images');
                    foreach ($files as $key => $file) {
                        $image = $file;
                        date_default_timezone_set('Asia/Kolkata');
                        $filenameWithExt = $image->getClientOriginalName();
                        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                        $extension = $image->getClientOriginalExtension();
                        $sanitized_title = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->input('product_name')));
                        $uniqueTimestamp = round(microtime(true) * 1000);
                        $image_file_name_webp = 'GD-sons-kitchen-Varanasi-' . $sanitized_title . '-' . $uniqueTimestamp . '.webp';
                        $image_file_name_jpg = 'GD-sons-kitchen-Varanasi-' . $sanitized_title . '-' . $uniqueTimestamp . '.jpg';
                        $this->saveProductImages($image, $image_file_name_webp);
                        $this->saveProductImagesToJpg($image, $image_file_name_jpg);
                        ProductImages::create([
                            'product_id' => $add_product->id,
                            'image_path' => $image_file_name_webp,
                            'sort_order' => $key,
                        ]);
                    }
                }
                /**Primary product attributes and his value */
                if (!empty($request->input('primary-product-attributes')) && !empty($request->input('primary-product-attributes-value'))) {
                    $primaryAttributes = $request->input('primary-product-attributes');
                    $primaryValues = $request->input('primary-product-attributes-value');
                    foreach ($primaryAttributes as $key => $attribute_id) {
                        if ($attribute_id) {
                            $create_primary_product_attribute = ProductAttributes::create([
                                'product_id' => $add_product->id,
                                'attributes_id' => $attribute_id,
                                'sort_order' => $key,
                            ]);
                            if (!empty($primaryValues[$key])) {
                                $values = is_array($primaryValues[$key]) ? $primaryValues[$key] : [$primaryValues[$key]]; 
                                
                                $sr_no = 0;
                                foreach ($values as $attribute_value_id) {
                                    Log::info('Selected attributes value id:', ['attribute_value_id' => $attribute_value_id]);
                                    $mapExists = MapAttributesValueToCategory::where([
                                        'category_id' => $request->input('product_categories'),
                                        'attributes_value_id' => $attribute_value_id,
                                        'attributes_id' => $attribute_id,
                                    ])->exists();
                                    if (!$mapExists) {
                                        MapAttributesValueToCategory::create([
                                            'category_id' => $request->input('product_categories'),
                                            'attributes_value_id' => $attribute_value_id,
                                        ]);
                                    }
                                    ProductAttributesValues::create([
                                        'product_id' => $add_product->id,
                                        'product_attribute_id' => $create_primary_product_attribute->id,
                                        'attributes_value_id' => $attribute_value_id,
                                        'sort_order' => $sr_no,
                                    ]);
                
                                    $sr_no++;
                                }
                            }
                        }
                    }
                }
                
                /**Primary product attributes and his value */
                if (!empty($request->input('product_attributes'))) {
                    $product_attributes_array = $request->input('product_attributes');
                    $product_attributes_values = $request->input('product_attributes_value');

                    foreach ($product_attributes_array as $key => $attributes_id) {
                        if ($attributes_id) {
                            $create_product_attribute = ProductAttributes::create([
                                'product_id' => $add_product->id,
                                'attributes_id' => $attributes_id,
                                'sort_order' => $key,
                            ]);

                            if (!empty($product_attributes_values[$key]) && is_array($product_attributes_values[$key])) {
                                $sr_no = 0;
                                foreach (explode(',', $product_attributes_values[$key][0]) as $attribute_value_name) {
                                    $attribute_value_name = trim($attribute_value_name);
                                    /*make unique slug*/
                                    $slug = Str::slug($attribute_value_name);
                                    $originalSlug = $slug;
                                    $counter = 1;
                                    while (Attribute_values::where('slug', $slug)->exists()) {
                                        $slug = "{$originalSlug}-{$counter}";
                                        $counter++;
                                    }
                                    /*make unique slug*/
                                    $attribute_value = Attribute_values::firstOrCreate(
                                        ['name' =>  $attribute_value_name, 'attributes_id' => $attributes_id],
                                        ['slug' => $slug]
                                    );
                                    /* Map attributes value to category*/
                                    //$this->mapAttributeValueToCategory($attribute_value, $request->input('product_categories'));
                                    /*Check if the mapping exists; if not, create it*/
                                    $mapExists = MapAttributesValueToCategory::where([
                                        'category_id' => $request->input('product_categories'),
                                        'attributes_value_id' => $attribute_value->id,
                                    ])->exists();
            
                                    if (!$mapExists) {
                                        MapAttributesValueToCategory::create([
                                            'category_id' => $request->input('product_categories'),
                                            'attributes_value_id' => $attribute_value->id,
                                            'attributes_id' => $attributes_id,
                                        ]);
                                    }

                                    ProductAttributesValues::create([
                                        'product_id' => $add_product->id,
                                        'product_attribute_id' => $create_product_attribute->id,
                                        'attributes_value_id' => $attribute_value->id,
                                        'sort_order' => $sr_no,
                                    ]);
                                    $sr_no++;
                                }
                            }
                        }
                    }
                }
                /**additional feature add start code*/
                $additional_feature_key_array = $request->input('additional_feature_key');
                $additional_feature_key_value_array = $request->input('additional_feature_key_value');
                Log::info('Request input additional_feature_key:', ['additional_feature_key' => $additional_feature_key_array]);
                Log::info('Request input additional_feature_key_value:', ['additional_feature_key_value' => $additional_feature_key_value_array]);
                /*Check if the array is not empty and the keys are not null*/
                if (!empty($additional_feature_key_array) && $additional_feature_key_array[0] !== null) {
                    if (is_array($additional_feature_key_array) && is_array($additional_feature_key_value_array) &&
                        count($additional_feature_key_array) === count($additional_feature_key_value_array)) {
                        foreach ($additional_feature_key_array as $key => $additional_feature_key) {
                            if (!empty($additional_feature_key)) {
                                $additional_feature = AdditionalFeature::firstOrCreate(
                                    [
                                        'title' => $additional_feature_key,
                                    ],
                                    [
                                        'slug' => Str::slug($additional_feature_key)
                                    ]
                                );
                                Log::info('Additional Feature First or Create:', ['additional_feature_id' => $additional_feature->id]);
                                if (!empty($additional_feature_key_value_array[$key])) {
                                    $product_additional_feature = ProductsAdditionalFeature::create(
                                        [
                                            'product_id' => $add_product->id,
                                            'additional_feature_id' => $additional_feature->id,
                                            'product_additional_featur_value' => $additional_feature_key_value_array[$key],
                                            'sort_order' => $key
                                        ]
                                    );
                                    Log::info('Product Additional Feature:', ['product_additional_feature_id' => $product_additional_feature->id]);
                                } else {
                                    Log::warning("Empty additional feature value at index: $key");
                                }
                            } 
                            else 
                            {
                                Log::warning("Skipped empty additional feature key at index: $key");
                            }
                        }
                    } else {
                        Log::error('Additional feature keys or values are either not arrays or their counts do not match.');
                    }
                } else {
                    Log::error('No additional feature keys provided or first key is null.');
                }

                /**additional feature add end code*/ 
                DB::commit();
                if ($request->has('redirect_url') && filter_var($request->redirect_url, FILTER_VALIDATE_URL)) {
                    return redirect($request->redirect_url)->with('success', 'Product added successfully!');
                } else {
                    return redirect('product')->with('success', 'Product created successfully');
                }
            }
        }
        catch (\Exception $e) {
            DB::rollback();
            Log::error('Error creating product: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }
    
    private function saveProductImages($image, $image_file_name){
        $destination_path_large = public_path('images/product/large/');
        $img_large = Image::make($image->getRealPath());
        $img_large->resize(1920, 1080, function ($constraint) {
            $constraint->aspectRatio();
        })->encode('webp', 90)->save($destination_path_large . '/' . $image_file_name);
        // SMALL IMAGE (800x600)
        $destination_path_small = public_path('images/product/small/');
        $img_small = Image::make($image->getRealPath());
        $img_small->resize(800, 600, function ($constraint) {
            $constraint->aspectRatio();
        })->encode('webp', 90)->save($destination_path_small . '/' . $image_file_name);
        // THUMB IMAGE (250x250)
        $destination_path_thumb = public_path('images/product/thumb/');
        $img_thumb = Image::make($image->getRealPath());
        $img_thumb->resize(400, 300, function ($constraint) {
            $constraint->aspectRatio();
        })->encode('webp', 90)->save($destination_path_thumb . '/' . $image_file_name);
        // ICON IMAGE (150x150)
        $destination_path_icon = public_path('images/product/icon/');
        $img_icon = Image::make($image->getRealPath());
        $img_icon->resize(200, 150, function ($constraint) {
            $constraint->aspectRatio();
        })->encode('webp', 90)->save($destination_path_icon . '/' . $image_file_name);
        // ORIGINAL IMAGE (save as WebP)
        $destinationPath = public_path('images/product/original/');
        $img_original = Image::make($image->getRealPath());
        $img_original->encode('webp', 90)->save($destinationPath . '/' . $image_file_name);
    }

    private function mapAttributeValueToCategory($attribute_value, $category_id){
        $mapExists = MapAttributesValueToCategory::where([
            'category_id' => $category_id,
            'attributes_value_id' => $attribute_value->id,
        ])->exists();

        if (!$mapExists) {
            MapAttributesValueToCategory::create([
                'category_id' => $category_id,
                'attributes_value_id' => $attribute_value->id,
            ]);
        }
    }

    public function edit($id){
        $data['product'] = Product::with(['images', 'category', 'brand', 'attributes.attribute', 'attributes.values.attributeValue', 'additionalFeatures.feature'])->findOrFail($id);
        $data['product_attributes_list'] = Attribute::orderBy('title', 'asc')->get();
        $data['product_category_list'] = Category::where('status', '=', 'on')->orderBy('title', 'asc')->get();
        $data['brand_list'] = Brand::where('status', '=', 'on')->orderBy('title', 'asc')->get();
        $data['label_list'] = Label::where('status', '=', 'on')->orderBy('title', 'asc')->get();
        return view('backend.product.edit', compact('data'));
        //return response()->json($data['product']);
    }

    public function update(Request $request, $id) {
        /*
        additional feature table truncate code
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('additional_features')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        */
        Log::info('Request Data:', $request->all());
        try {
            DB::beginTransaction(); 
            $this->validate($request, [
                'product_name' => 'required',
                'product_categories' => 'required',
                'hsn_code' => 'nullable|regex:/^\d{4}(\d{2}){0,1}(\d{2}){0,1}$/',
                'gst_in_percentage' => 'nullable|numeric|min:0|max:100',
            ]);
            $update_product_row = Product::findOrFail($id);
            $input['title'] = $request->input('product_name');
            $input['category_id'] = $request->input('product_categories');
            //$input['subcategory_id'] = $request->input('product_subcategories');
            //$input['brand_id'] = $request->input('brand');
            $input['hsn_code'] = $request->input('hsn_code');
            $input['gst_in_per'] = $request->input('gst_in_percentage');
            $input['label_id'] = $request->input('label');
            //$input['product_weight'] = $request->input('product_weight');
            $input['product_stock_status'] = $request->input('product_stock_status');
            $input['product_tags'] = $request->input('product_tags');
            $input['product_price'] = $request->input('product_price');
            $input['product_sale_price'] = $request->input('product_sale_price');
            
            // Check checkbox values
            $input['product_status'] = $request->input('product_status') === 'on' ? 1 : 0;
            $input['warranty_status'] = $request->input('warranty_status') === 'on' ? 1 : 0;
            $input['attributes_show_status'] = $request->input('attributes_show_status') === 'on' ? 1 : 0;
        
            $input['meta_title'] = $request->input('meta_title');
            $input['meta_description'] = $request->input('meta_description');
            $input['product_description'] = $request->input('product_description');
            $input['product_specification'] = $request->input('product_specification');
            // Update the product
            $update_product_row->update($input);
        
            // Handle product images update
            if ($request->hasFile('product_images')) {
                $files = $request->file('product_images');
                foreach ($files as $key => $file) {
                    $image = $file;
                    date_default_timezone_set('Asia/Kolkata');
                    $filenameWithExt = $image->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = $image->getClientOriginalExtension();
                    
                    $sanitized_title = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->input('product_name')));
                    $timestamp = round(microtime(true) * 1000);
                    $image_file_name_webp = 'GD-sons-kitchen-Varanasi-' . $sanitized_title . '-' . $timestamp . '.webp';
                    $image_file_name_jpg = 'GD-sons-kitchen-Varanasi-' . $sanitized_title . '-' . $timestamp . '.jpg';
                    $this->processImage($image, $image_file_name_webp);
                    $this->saveProductImagesToJpg($image, $image_file_name_jpg);
                    ProductImages::create([
                        'product_id' => $update_product_row->id,
                        'image_path' => $image_file_name_webp,
                        'sort_order' => $key,
                    ]);

                }
            }
            
            if (!empty($request->input('product_attributes'))) {
                $product_attributes_array = $request->input('product_attributes');
                $product_attributes_values = $request->input('product_attributes_value');
                $product_attributes_value_ids = $request->input('product_attributes_value_id');
            
                /*Delete existing Product Attributes and Product Attribute Values for the product*/
                ProductAttributes::where('product_id', $update_product_row->id)->delete();
                ProductAttributesValues::where('product_id', $update_product_row->id)->delete();
            
                foreach ($product_attributes_array as $key => $attributes_id) {
                    if ($attributes_id) {
                        if (!empty($product_attributes_value_ids[$key])) {
                            // Ensure input is standardized as an array
                            $value_ids = is_array($product_attributes_value_ids[$key]) 
                                ? $product_attributes_value_ids[$key]
                                : explode(',', $product_attributes_value_ids[$key]);
            
                            // Delete MapAttributesValueToCategory entries based on these IDs
                            foreach ($value_ids as $value_id_item) {
                                $individual_ids = explode(',', $value_id_item); // Handle any nested comma-separated values
            
                                foreach ($individual_ids as $value_id) {
                                    $value_id = trim($value_id);
                                    if (!empty($value_id)) {
                                        // Delete the MapAttributesValueToCategory entries
                                        $delete_count = MapAttributesValueToCategory::where([
                                            'category_id' => $request->input('product_categories'),
                                            'attributes_value_id' => $value_id,
                                            'attributes_id' => $attributes_id,
                                        ])->delete();
                                        Log::info("Deleted {$delete_count} MapAttributesValueToCategory entries for value_id: " . $value_id);
                                    }
                                }
                            }
                        }
                        // Create Product Attribute
                        $create_product_attribute = ProductAttributes::create([
                            'product_id' => $update_product_row->id,
                            'attributes_id' => $attributes_id,
                            'sort_order' => $key,
                        ]);
                        
                        if (!empty($product_attributes_values[$key]) && is_array($product_attributes_values[$key])) {
                            $sr_no = 0;
                            foreach (explode(',', $product_attributes_values[$key][0]) as $attribute_value_name) {
                                $attribute_value_name = trim($attribute_value_name);
                                /*make unique slug*/
                                $slug = Str::slug($attribute_value_name);
                                $originalSlug = $slug;
                                $counter = 1;
                                while (Attribute_values::where('slug', $slug)->exists()) {
                                    $slug = "{$originalSlug}-{$counter}";
                                    $counter++;
                                }
                                /*make unique slug*/
                                $attribute_value = Attribute_values::firstOrCreate(
                                    ['name' =>  $attribute_value_name, 'attributes_id' => $attributes_id],
                                    ['slug' => $slug]
                                );
                                $category_id = $request->input('product_categories');
                                if (!MapAttributesValueToCategory::where([
                                    'category_id' => $category_id,
                                    'attributes_value_id' => $attribute_value->id,
                                    'attributes_id' => $attributes_id,
                                ])->exists()) {
                                    $creat = MapAttributesValueToCategory::create([
                                        'category_id' => $category_id,
                                        'attributes_value_id' => $attribute_value->id,
                                        'attributes_id' => $attributes_id,
                                    ]);
                                    Log::info('Create MapAttributesValueToCategory for value_id', $creat->toArray());
                                }
            
                                // Create Product Attribute Value
                                ProductAttributesValues::create([
                                    'product_id' => $update_product_row->id,
                                    'product_attribute_id' => $create_product_attribute->id,
                                    'attributes_value_id' => $attribute_value->id,
                                    'sort_order' => $sr_no,
                                ]);
            
                                $sr_no++;
                            }
                        }
                    }
                }
            }
            /**additional feature add start code*/
            if (!empty($request->input('additional_feature_key'))){
                $additional_feature_key_array = $request->input('additional_feature_key');
                $additional_feature_key_value_array = $request->input('additional_feature_key_value');
                ProductsAdditionalFeature::where('product_id', $update_product_row->id)->delete();
                if (is_array($additional_feature_key_array) && is_array($additional_feature_key_value_array) &&
                    count($additional_feature_key_array) === count($additional_feature_key_value_array)) {
                    foreach ($additional_feature_key_array as $key => $additional_feature_key) {
                        if (!empty($additional_feature_key)) {
                            $additional_feature = AdditionalFeature::firstOrCreate(
                                [
                                    'title' => $additional_feature_key,
                                ],
                                [
                                    'slug' => Str::slug($additional_feature_key)
                                ]
                            );
                            Log::info('Additional Feature First or Create:', ['additional_feature_id' => $additional_feature->id]);
                            if (!empty($additional_feature_key_value_array[$key])) {
                                $product_additional_feature = ProductsAdditionalFeature::create(
                                    [
                                        'product_id' => $update_product_row->id,
                                        'additional_feature_id' => $additional_feature->id,
                                        'product_additional_featur_value' => $additional_feature_key_value_array[$key],
                                        'sort_order' => $key
                                    ]
                                );
                                Log::info('Product Additional Feature:', ['product_additional_feature_id' => $product_additional_feature->id]);
                            }
                        } else {
                            Log::warning("Skipped empty additional feature key at index: $key");
                        }
                    }
                } else {
                    Log::error('Additional feature keys or values are either not arrays or their counts do not match.');
                }
            } else {
                Log::error('No additional feature keys provided in the request.');
            }
            DB::commit();
            return redirect('product')->with('success', 'Product updated successfully');
        }
        catch (\Exception $e) {
            DB::rollback();
            Log::error('Error updating product: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error updating product: ' . $e->getMessage());
        }
    }

    private function processImage($image, $image_file_name) {
        $sizes = [
            'large' => [1920, 1080],
            'small' => [800, 600],
            'thumb' => [250, 250],
            'icon' => [150, 150],
            'original' => [null, null],
        ];

        foreach ($sizes as $sizeName => [$width, $height]) {
            $destinationPath = public_path("images/product/{$sizeName}/");
            $img = Image::make($image->getRealPath());
            if ($width && $height) {
                $img->resize($width, $height, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }

            $img->encode('webp', 90)->save($destinationPath . '/' . $image_file_name);
        }
    }

    public function deleteImage($id){
        $product_image_row = ProductImages::find($id);
        if (!$product_image_row) {
            return back()->with('error', 'Product image not found.');
        }
        $destination_path_large = public_path('images/product/large/');
        $destination_path_small = public_path('images/product/small/');
        $destination_path_thumb = public_path('images/product/thumb/');
        $destination_path_icon = public_path('images/product/icon/');
        $destination_path_original = public_path('images/product/original/');
        $imageFileName = $product_image_row->image_path;
        $imageFileRenameJpg = str_replace('.webp', '.jpg', $imageFileName);
        $jpgImageFile = public_path('images/product/jpg-image/thumb/' . $imageFileRenameJpg);
        if (file_exists($jpgImageFile)) {
            unlink($jpgImageFile);
        }
        $large_old_file = $destination_path_large.$product_image_row->image_path;
        if (file_exists($large_old_file)) {
            unlink($large_old_file);
        }
        $small_old_file = $destination_path_small.$product_image_row->image_path;
        if (file_exists($small_old_file)) {
            unlink($small_old_file);
        }
        $thumb_old_file = $destination_path_thumb.$product_image_row->image_path;
        if (file_exists($thumb_old_file)) {
            unlink($thumb_old_file);
        }
        $icon_old_file = $destination_path_icon.$product_image_row->image_path;
        if (file_exists($icon_old_file)) {
            unlink($icon_old_file);
        }
        $original_old_file = $destination_path_original.$product_image_row->image_path;
        if (file_exists($original_old_file)) {
            unlink($original_old_file);
        }
        $product_image_row->delete(); 
        return back()->with('success', 'Product images deleted successfully');
    }

    public function destroy($id){
        $product = Product::findOrFail($id);
        $category_id = $product->category_id;
        $productAttributes = ProductAttributes::where('product_id', $id)->get();
        /*
        foreach ($productAttributes as $productAttribute) {
            ProductAttributesValues::where('product_attribute_id', $productAttribute->id)->delete();
            $productAttribute->delete();
        }
        */
        /*Delete Product Additional Feature */
        $product_additional_feature = ProductsAdditionalFeature::where('product_id', $id)->get();
        if ($product_additional_feature->isNotEmpty()) {
            ProductsAdditionalFeature::where('product_id', $id)->delete();
        }
        /*Delete Product Additional Feature */
        foreach ($productAttributes as $productAttribute) {
            $productAttributesValues = ProductAttributesValues::where('product_attribute_id', $productAttribute->id)->get();
            foreach ($productAttributesValues as $product_attributes_value) {
                // $mapExists = MapAttributesValueToCategory::where([
                //     'category_id' => $category_id,
                //     'attributes_value_id' => $product_attributes_value->attributes_value_id,
                // ])->first();

                // if ($mapExists) {
                //     $mapExists->delete();
                // }
            }
            // Delete ProductAttributesValues and ProductAttribute
            $productAttributesValues->each->delete(); // Delete all associated values
            $productAttribute->delete();
        }
        $productImages = ProductImages::where('product_id', $id)->get();
        foreach ($productImages as $image) {
            $filePaths = [
                public_path("images/product/large/{$image->image_path}"),
                public_path("images/product/small/{$image->image_path}"),
                public_path("images/product/thumb/{$image->image_path}"),
                public_path("images/product/icon/{$image->image_path}"),
                public_path("images/product/original/{$image->image_path}")
            ];
            foreach ($filePaths as $filePath) {
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            $image->delete();
        }
        $product->delete();
        return back()->with('success', 'Product and all associated records deleted successfully.');
    }

    public function bulkDelete(Request $request){
        $productIds = $request->input('product_ids');
        if ($productIds) {
            DB::beginTransaction();
            try 
            {
                foreach ($productIds as $id) {
                    $product = Product::findOrFail($id);
                    $category_id = $product->category_id;
                    /*Delete Product Additional Feature */
                    $product_additional_feature = ProductsAdditionalFeature::where('product_id', $id)->get();
                    if ($product_additional_feature->isNotEmpty()) {
                        ProductsAdditionalFeature::where('product_id', $id)->delete();
                    }
                    /*Delete Product Additional Feature */
                    /* Delete all related ProductAttributes and ProductAttributesValues*/
                    $productAttributes = ProductAttributes::where('product_id', $id)->get();
                    foreach ($productAttributes as $productAttribute) {
                        $productAttributesValues = ProductAttributesValues::where('product_attribute_id', $productAttribute->id)->get();
                        foreach ($productAttributesValues as $product_attributes_value) {
                            /** Find mapped attributes_value_to_category */
                            $mapExists = MapAttributesValueToCategory::where([
                                'category_id' => $category_id,
                                'attributes_value_id' => $product_attributes_value->attributes_value_id,
                            ])->first();

                            if ($mapExists) {
                                $mapExists->delete();
                            }
                        }
                        /*Delete ProductAttributesValues and ProductAttribute*/
                        $productAttributesValues->each->delete(); 
                        $productAttribute->delete();
                    }
                    /*Delete all related ProductImages and remove image files*/
                    $productImages = ProductImages::where('product_id', $id)->get();
                    foreach ($productImages as $image) {
                        $filePaths = [
                            public_path("images/product/large/{$image->image_path}"),
                            public_path("images/product/small/{$image->image_path}"),
                            public_path("images/product/thumb/{$image->image_path}"),
                            public_path("images/product/icon/{$image->image_path}"),
                            public_path("images/product/original/{$image->image_path}")
                        ];
                        foreach ($filePaths as $filePath) {
                            if (file_exists($filePath)) {
                                unlink($filePath);
                            }
                        }
                        $image->delete();
                    }
                    $product->delete();
                }
                DB::commit();
                return response()->json(['success' => true, 'message' => 'Selected products and associated records deleted successfully.']);
            }
            catch (\Exception $e) 
            {
                DB::rollBack(); 
                Log::error('Error during bulk deleted products: ' . $e->getMessage(), [
                    'product_ids' => $productIds,
                    'exception' => $e
                ]);
                return response()->json(['success' => false, 'message' => 'An error occurred while deleting products. Please try again.']);
            }

        }
        return response()->json(['success' => false, 'message' => 'No products selected.']);
    }

    public function show($id){
        $data['product_details'] = Product::with(['images' => function($query) {$query->orderBy('sort_order');}, 'category', 'brand', 'attributes.attribute', 'attributes.values.attributeValue', 'additionalFeatures.feature', 'inventories'])->findOrFail($id);
        //return response()->json($data['product_details']);
        return view('backend.product.show', compact('data'));
    }

    public function sort(Request $request){
        $sortedIDs = $request->input('order');
        foreach ($sortedIDs as $index => $id) {
            ProductImages::where('id', $id)->update(['sort_order' => $index + 1]);
        }

        return response()->json(['success' => true, 'message'=>'Sort order updated successfully!']);
    }
    
    public function exportProduct(Request $request){
        $products = Product::with(['images', 'category', 'brand'])->get(['id', 'title', 'product_price', 'product_sale_price', 'category_id', 'created_at']);
        $data = $products->map(function ($product) {
            $imageUrl = $product->images->isNotEmpty()? asset('storage/images/product/thumb/' . $product->images->first()->image_path) 
            : 'N/A';
            return [
                $product->id,
                $product->title,
                $product->product_price,
                $product->product_sale_price,
                $product->category->title ?? 'N/A',
                $product->created_at->toDateString(),
                $imageUrl,
            ];
        })->toArray();

        $headings = ['ID', 'Product Name', 'Price', 'Sale Price', 'Category', 'Created At', 'Image'];
        $finalData = array_merge([$headings], $data);
        return Excel::download(new ProductsExport($finalData), 'products.xlsx');
    }

    public function importExcelProduct(Request $request){
        $categoryId = $request->query('category_id');
        $product_category_with_attributes ='';
        $data['product_category_list'] = Category::where('status', 'on')
        ->orderBy('title', 'asc')
        ->get();
        if ($categoryId) {
            $product_category_with_attributes = Category::with('attributes')
            ->where('id', $categoryId)
            ->first();
            
        } 
        //return response()->json($product_category_with_attributes);
        return view('backend.product.excel.import-product', compact('data','product_category_with_attributes'));
    }
     /**remove it */
    public function ExcelStore_re(Request $request){
        
        $request->validate([
            'import_file' => 'required|file|mimes:xlsx,xls,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel',
            'product_categories' => 'required',
        ]);
    
        $category_id = $request->input('product_categories');
        try {
            Excel::import(new ProductsImport($category_id), $request->file('import_file'));
            return redirect('product')->with('success', 'Products uploaded and inserted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['import_file' => 'There was an error processing the file: ' . $e->getMessage()]);
        }
        
    }
    
    /**If attributes_value comma separated */
    public function ExcelStore(Request $request){
        $request->validate([
            'import_file' => 'required|file|mimes:xlsx,xls',
            'product_categories' => 'required',
        ]);

        $file = $request->file('import_file');
        Log::info('Uploaded File:', [
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'extension' => $file->getClientOriginalExtension(),
            'size' => $file->getSize(),
        ]);

        if ($file->getClientOriginalExtension() == 'xls' &&
            $file->getMimeType() !== 'application/vnd.ms-excel' &&
            $file->getMimeType() !== 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
            return redirect()->back()->with('error', 'Invalid file type for .xls file. Please upload a valid Excel file.');
        }

        $category_id = $request->input('product_categories');
        $data = Excel::toArray([], $request->file('import_file'));

        if (!isset($data[0]) || empty($data[0])) {
            return redirect()->back()->with('error', 'The uploaded file is empty or improperly formatted.');
        }

        //$header = $data[0][0] ?? null;
        $header = array_map(fn($h) => trim($h), $data[0][0] ?? []);
        Log::info('header map:', $header);
        if (!$header) {
            return redirect()->back()->with('error', 'The file must contain headers.');
        }
        Log::info('Processed Headers:', $header);
        //$headerMapping = array_flip($header);
        $headerMapping = array_flip($header);
        //Log::info('Processed Headers:', $headerMapping);
        
        DB::beginTransaction();
        try {
            $mappedAttributes = MapCategoryAttributes::where('category_id', $category_id)->pluck('attribute_id')->toArray();

            foreach ($mappedAttributes as $attribute_id) {
                $attribute = Attribute::find($attribute_id);
                if ($attribute) {
                    $headerIndex = $headerMapping[$attribute->title] ?? null;
                    if (!$headerIndex) {
                        continue;
                    }

                    $attributeHeader = $data[0][0][$headerIndex];
                    Attribute::firstOrCreate(
                        ['title' => $attributeHeader],
                        ['slug' => Str::slug($attributeHeader)]
                    );
                }
            }

            foreach ($data[0] as $key => $row) {
                if ($key == 0) continue;

                if (empty($row[$headerMapping['Product Name']])) {
                    continue;
                }

                $product_name = $row[$headerMapping['Product Name']];

                $existingProduct = Product::where('title', $product_name)->first();
                if ($existingProduct) {
                    continue;
                }

                $product = Product::create([
                    'title' => $product_name,
                    'category_id' => $category_id,
                ]);

                foreach ($mappedAttributes as $attribute_id) {
                    $attribute = Attribute::find($attribute_id);
                    if ($attribute) {
                        $attributeHeader = $row[$headerMapping[$attribute->title]] ?? null;
                        if ($attributeHeader) {
                            $attributeValues = explode(',', $attributeHeader);
                            foreach ($attributeValues as $value) {
                                $value = trim($value);
                                $slug = Str::slug($value);
                                $originalSlug = $slug;
                                $counter = 1;

                                while (Attribute_values::where('slug', $slug)->exists()) {
                                    $slug = "{$originalSlug}-{$counter}";
                                    $counter++;
                                }

                                $attributeValue = Attribute_values::firstOrCreate(
                                    ['name' => $value, 'attributes_id' => $attribute->id],
                                    ['slug' => $slug]
                                );

                                $mapExists = MapAttributesValueToCategory::where([
                                    'category_id' => $category_id,
                                    'attributes_value_id' => $attributeValue->id,
                                    'attributes_id' => $attribute->id,
                                ])->exists();

                                if (!$mapExists) {
                                    MapAttributesValueToCategory::create([
                                        'category_id' => $category_id,
                                        'attributes_value_id' => $attributeValue->id,
                                        'attributes_id' => $attribute->id,
                                    ]);
                                }

                                $productAttributes = ProductAttributes::firstOrCreate([
                                    'product_id' => $product->id,
                                    'attributes_id' => $attribute->id,
                                    'sort_order' => 0,
                                ]);

                                ProductAttributesValues::firstOrCreate([
                                    'product_id' => $product->id,
                                    'product_attribute_id' => $productAttributes->id,
                                    'attributes_value_id' => $attributeValue->id,
                                    'sort_order' => 0,
                                ]);
                            }
                        }
                    }
                }
            }

            DB::commit();
            return redirect('product')->with('success', 'Products uploaded and inserted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in ExcelStore:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            return redirect()->back()->with('error', 'An error occurred while processing the file. Please try again.');
        }
    }
    /**If attributes_value comma separated */
    /**If attributes_value single value */
    public function ExcelStore_without_comma_separated(Request $request){
        
        $request->validate([
            'import_file' => 'required|file|mimes:xlsx,xls',
            'product_categories' => 'required',
        ]);
        $file = $request->file('import_file');
        Log::info('Uploaded File:', [
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'extension' => $file->getClientOriginalExtension(),
            'size' => $file->getSize(),
        ]);
        if ($file->getClientOriginalExtension() == 'xls' && 
            $file->getMimeType() !== 'application/vnd.ms-excel' &&
            $file->getMimeType() !== 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
            return redirect()->back()->with('error', 'Invalid file type for .xls file. Please upload a valid Excel file.');
        }
        $category_id = $request->input('product_categories');
        $data = Excel::toArray([], $request->file('import_file'));
        if (!isset($data[0]) || empty($data[0])) {
            return redirect()->back()->with('The uploaded file is empty or improperly formatted.');
        }
        $header = $data[0][0] ?? null;
        if (!$header) {
            return redirect()->back()->with('The file must contain headers.');
        }
        
        Log::info('Excelstore:', ['excel_file' => $request->file('import_file')]);
        
        $headerMapping = array_flip($header);
        $mappedAttributes = MapCategoryAttributes::where('category_id', $category_id)->pluck('attribute_id')->toArray();
        
        foreach ($mappedAttributes as $attribute_id) {
            $attribute = Attribute::find($attribute_id);
            if ($attribute) {
                $headerIndex = $headerMapping[$attribute->title] ?? null;
                if (!$headerIndex) {
                    continue;
                }
        
                $attributeHeader = $data[0][0][$headerIndex];
                $attributeModel = Attribute::firstOrCreate(
                    ['title' => $attributeHeader],
                    ['slug' => Str::slug($attributeHeader)]
                );
        
                Log::info('Excelstore:', ['attribute_id' => $attributeModel->id]);
            }
        }
        
        foreach ($data[0] as $key => $row) {
            if ($key == 0) {
                continue;
            }
        
            if (empty($row[$headerMapping['Product Name']]) || empty($row[$headerMapping['MRP']]) || empty($row[$headerMapping['Sale Price']])) {
                continue; 
            }
        
            $product_name = $row[$headerMapping['Product Name']];
            //$category_name = $row[$headerMapping['Category']];
            $mrp = $row[$headerMapping['MRP']];
            $sale_price = $row[$headerMapping['Sale Price']];
            //$brand_name = $row[$headerMapping['Brand']];
        
            $existingProduct = Product::where('title', $product_name)->first();
            if ($existingProduct) {
                continue;
            }
        
            //$brand = Brand::firstOrCreate(['title' => $brand_name]);
        
            $product = Product::create([
                'title' => $product_name,
                'category_id' => $category_id,
                'product_price' => $mrp,
                'product_sale_price' => $sale_price,
                //'brand_id' => $brand->id,
            ]);
        
            foreach ($mappedAttributes as $attribute_id) {
                $attribute = Attribute::find($attribute_id);
                if ($attribute) {
                    $attributeHeader = $row[$headerMapping[$attribute->title]] ?? null;
                    if ($attributeHeader) {
                        $attributeValue = Attribute_values::firstOrCreate(
                            ['name' => trim($attributeHeader), 'attributes_id' => $attribute->id],
                            ['slug' => Str::slug(trim($attributeHeader))]
                        );

                        // Check if the mapping exists; if not, create it
                        $mapExists = MapAttributesValueToCategory::where([
                            'category_id' => $category_id,
                            'attributes_value_id' => $attributeValue->id,
                        ])->exists();

                        if (!$mapExists){
                            MapAttributesValueToCategory::create([
                                'category_id' => $category_id,
                                'attributes_value_id' => $attributeValue->id,
                            ]);
                        }
        
                        $productAttributes = ProductAttributes::firstOrCreate([
                            'product_id' => $product->id,
                            'attributes_id' => $attribute->id,
                            'sort_order' => 0,
                        ]);
        
                        ProductAttributesValues::firstOrCreate([
                            'product_id' => $product->id,
                            'product_attribute_id' => $productAttributes->id,
                            'attributes_value_id' => $attributeValue->id,
                            'sort_order' => 0,
                        ]);
                    }
                }
            }
        }
        return redirect('product')->with('success', 'Products uploaded and inserted successfully!');
    }
    /**If attributes_value single value */
    public function autocompleteProducts_old(Request $request){
        $query = $request->input('query');
        $selectedProductIds = $request->input('selected_ids', []);
        $products = Product::where('title', 'like', '%' . $query . '%')->whereNotIn('id',$selectedProductIds)->paginate(20, ['id', 'title']);
        Log::info('Autocomplete Products Query:', ['query' => $query, 'selected_ids' => $selectedProductIds]);
        return response()->json($products->items());
    }

    public function autocompleteProducts(Request $request){
        $query = $request->input('query');
        $selectedProductIds = $request->input('selected_ids', []);
        $startTime = microtime(true);
        //$cacheKey = 'autocomplete_products_' . md5($query . implode(',', $selectedProductIds));
        $cacheKey = 'autocomplete_products_' . hash('sha256', $query . json_encode($selectedProductIds));
        $products = Cache::remember($cacheKey, 60, function () use ($query, $selectedProductIds) {
            return Product::where('title', 'like', '%' . $query . '%')
                ->whereNotIn('id', $selectedProductIds)
                ->limit(15)
                ->orderBy('title')
                ->get(['id', 'title', 'hsn_code', 'gst_in_per']);
        });
        $endTime = microtime(true);
        $queryTime = $endTime - $startTime;
        Log::info('Autocomplete Products Query:', [
            'query' => $query,
            'selected_ids' => $selectedProductIds,
            'execution_time' => $queryTime . ' seconds',
        ]);

        return response()->json($products);
    }

    public function updateProductListWithGST(){
        $data['categories'] = Category::all(); 
        $data['product_list'] = Product::with(['images', 'category', 'attributes.attribute', 'attributes.values.attributeValue'])->orderBy('id', 'desc')->paginate(100);
        //return response()->json($data['product_list']);
        return view('backend.product.update-gst.index', compact('data'));
    }

    public function filterProductListWithHsnGst(Request $request){
        $query = Product::with('category');
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        // if ($request->filled('search_term')) {
        //     $query->where('title', 'like', '%' . $request->search_term . '%');
        // }
        
        if ($request->has('search_term') && $request->search_term) {
            $searchTerms = explode(' ', $request->search_term); 
            $booleanQuery = '+' . implode(' +', $searchTerms);
        
            $query->whereRaw("MATCH(title) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery]);
            $query->orWhere(function ($query) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $query->where('title', 'like', '%' . $term . '%');
                }
            });
        }
        $product_list = $query->orderBy('id', 'desc')->paginate(100);
        return response()->json([
            'html' => view('backend.product.update-gst.partials.product-table-with-hsn-gst', [
                'data' => ['product_list' => $product_list]
            ])->render(),
        ]);
    }

    public function updateHSNCodeGstFormSubmit(Request $request){
        $validated = $request->validate([
            'products' => 'required|array',
            'products.*.gst_in_per' => 'nullable|numeric|min:0|max:100',
            'products.*.hsn_code' => 'nullable|regex:/^\d{4}(\d{2}){0,1}(\d{2}){0,1}$/',
        ], [
            'products.*.hsn_code.regex' => 'HSN Code must be 4, 6, or 8 digits only.',
            'products.*.gst_in_per.numeric' => 'GST Percentage must be a valid number.',
            'products.*.gst_in_per.min' => 'GST Percentage must be at least 0.',
            'products.*.gst_in_per.max' => 'GST Percentage cannot be more than 100.',
        ]);

        try {
            foreach ($validated['products'] as $product_id => $data) {
                $product = Product::find($product_id);
                if ($product) {
                    $product->update([
                        'hsn_code' => $data['hsn_code'] ?? null,
                        'gst_in_per' => $data['gst_in_per'] ?? null,
                    ]);
                }
            }

            return response()->json([
                'message' => 'All HSN Codes and GST values updated successfully!',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong, please try again.',
            ], 500);
        }
    }

    public function addNewAttributesValueForm(Request $request){
        $token = $request->input('_token'); 
        $size = $request->input('size'); 
        $url = $request->input('url'); 
        $category_id = $request->input('category_id');
        $category_list  = Category::orderBy('id','DESC')->get();
        $attributes_list  = Attribute::orderBy('id','DESC')->get();
        $attributes_id = $request->input('attributes_id');
        $form ='
        <div class="modal-body">
            <div id="error-list"></div>
            <form method="POST" action="'.route('products.add-new-att-value.submit').'" accept-charset="UTF-8" enctype="multipart/form-data" id="addNewAttributesValueForm">
                '.csrf_field().'
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" name="name" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-2">
                            <label for="name" class="form-label">Map Attributes Value to More Category</label>
                            <select class="js-example-basic-multiple select2multiple" name="category_id_modal[]"  id="category_id_modal" multiple="multiple">
                                <option value="" disabled>Select Category</option>';
                                    foreach ($category_list as $category) {
                                        $selected ='';
                                        if($category->id == $category_id){
                                            $selected = 'selected';
                                        }
                                        $form .= '<option value="' . $category->id . '" ' . $selected . '>' . $category->title . '</option>';
                                    }
                                $form .= '
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="category" class="form-label">Select Attributes</label>
                            <select class="form-select" id="attributes" name="attributes">
                                <option value="">Select Attributes</option>';
                                foreach ($attributes_list as $attributes_list_row) {
                                    $selected_attributes ='';
                                    if($attributes_list_row->id == $attributes_id){
                                        $selected_attributes = 'selected';
                                    }
                                    $form .= '<option value="'.$attributes_list_row->id.'" '.$selected_attributes.'>'.$attributes_list_row->title.'</option>';
                                }
                            $form .= ' 
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer pb-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
        ';
        return response()->json([
            'message' => 'Add new attributes value created successfully',
            'form' => $form,
        ]);
    }

    public function addNewAttributesValueFormSubmit(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id_modal' => 'required|array',
            'category_id_modal.*' => 'exists:category,id',
            'attributes' => 'required|exists:attributes,id',
        ]);

        try {
            $attributes_id = $request->input('attributes');
            $attribute_value_name = $request->input('name');
            $value = trim($attribute_value_name);
            $slug = Str::slug($value);
            $originalSlug = $slug;
            $counter = 1;
            while (Attribute_values::where('slug', $slug)->exists()) {
                $slug = "{$originalSlug}-{$counter}";
                $counter++;
            }
            /*make unique slug*/
            /*Check attribute value*/
            $attributeValue = Attribute_values::firstOrCreate(
                ['name' => $value, 'attributes_id' => $attributes_id],
                ['slug' => $slug]
            );
            /*Check if the mapping exists; if not, create it*/
            if ($attributeValue) {
                foreach ($request->input('category_id_modal') as $category_id) {
                    $mapExists = MapAttributesValueToCategory::where([
                        'category_id' => $category_id,
                        'attributes_value_id' => $attributeValue->id,
                        //'attributes_id' => $attributes_id,
                    ])->exists();

                    if (!$mapExists) {
                        MapAttributesValueToCategory::create([
                            'category_id' => $category_id,
                            'attributes_value_id' => $attributeValue->id,
                            'attributes_id' => $attributes_id,
                        ]);
                    }
                }
            }
            return response()->json(['success' => true, 'message' => 'Attribute value added successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Something went wrong!'], 500);
        }
    }

    public function imageUploadModalForm(Request $request){
        $token = $request->input('_token'); 
        $size = $request->input('size'); 
        $url = $request->input('url'); 
        $product_id = $request->input('product_id');
        $product_img = ProductImages::where('product_id', $product_id)->orderBy('sort_order')->get();
        $form ='
        <div class="modal-body">';
            if($product_img->isNotEmpty()){
                $form .='
                <div class="product-images-container">
                    <ul class="list-unstyled list-group sortable stage ui-sortable" id="sortable_product_image_popup">';
                            foreach($product_img as $image){
                                $image_path = asset('images/product/thumb/' . $image->image_path);
                                $form .='
                                <li class="d-flex align-items-center justify-content-between list-group-item ui-sortable-handle" data-id="'.$image->id.'">
                                    <h6 class="mb-0">
                                        <img src="'.$image_path.'" class="img-thumbnail me-3" style="width: 50px; height: 50px;" alt="img">
                                        <span>'.$image->image_path.'</span>
                                    </h6>
                                    
                                </li>';
                            }
                    $form .='
                    </ul>
                </div>';
            }
            $form .='
            <form method="POST" action="'.route('products.modal-image-form.submit').'" accept-charset="UTF-8" enctype="multipart/form-data" id="productimageForm">
                '.csrf_field().'
                <input type="hidden" name="product_id" value="'.$product_id.'">
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="product_image" class="form-label">Product Image *</label>
                            <input type="file" id="product_image" name="product_image[]" class="form-control"  accept="image/*" multiple>
                        </div>
                        <div id="image-preview"></div>
                    </div>
                    <div class="modal-footer pb-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
        ';
        return response()->json([
            'message' => 'Category Form created successfully',
            'form' => $form,
        ]);
    }

    public function imageUploadModalFormSubmit(Request $request){
        $request->validate([
            'product_image.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'product_id' => 'required|exists:products,id',
        ]);
        $productId = $request->input('product_id');
        $product_row = Product::where('id', $productId)->firstOrFail();
        if ($request->hasFile('product_image')) {
            DB::beginTransaction();
            try {
                $files = $request->file('product_image');
                foreach ($files as $key => $file) {
                    $image = $file;
                    $timestamp = round(microtime(true) * 1000); 
                    $filenameWithExt = $image->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $sanitized_title = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $product_row->title));
                    $image_file_name_webp = 'GD-sons-kitchen-Varanasi-' . $sanitized_title . '-' . $timestamp . '.webp';
                    $image_file_name_jpg = 'GD-sons-kitchen-Varanasi-' . $sanitized_title . '-' . $timestamp . '.jpg';
                    $this->saveProductImages($image, $image_file_name_webp);
                    $this->saveProductImagesToJpg($image, $image_file_name_jpg);
                    ProductImages::create([
                        'product_id' => $request->input('product_id'),
                        'image_path' => $image_file_name_webp,
                        'sort_order' => $key,
                    ]);

                }
                DB::commit();
                return response()->json(['success' => true, 'message' => 'Images uploaded successfully.']);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error uploading images: ' . $e->getMessage());
                return response()->json(['success' => false, 'message' => 'Failed to upload images. Please try again.'], 500);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Please select image file.'], 400);
        }
    }

    public function productMultipleUpdatePage(Request $request){
        $criteria = $request->query('criteria');
        if ($criteria == 'product-name') {
            $products = Product::with(['images'])->paginate(20);
            return view('backend.product.product-multiple-update.index', compact('criteria', 'products'));
        } elseif ($criteria == 'meta-title-description') {
            $products = Product::with(['images'])->paginate(20);
            return view('backend.product.product-multiple-update.index', compact('criteria', 'products'));
        } elseif ($criteria == 'product-description') {
            $products = Product::with(['images'])->paginate(20);
            return view('backend.product.product-multiple-update.index', compact('criteria', 'products'));
        } elseif ($criteria == 'product-specification') {
            $products = Product::with(['images'])->paginate(20);
            return view('backend.product.product-multiple-update.index', compact('criteria', 'products'));
        } elseif ($criteria == 'product-image') {
            $products = Product::with(['images'])->whereDoesntHave('images')->paginate(20);
            //$products = Product::with(['images'])->paginate(20);
            return view('backend.product.product-multiple-update.index', compact('criteria', 'products'));
        } elseif ($criteria == 'video-id') {
            $products = Product::with(['images'])->paginate(20);
            return view('backend.product.product-multiple-update.index', compact('criteria', 'products'));
        }
        return view('backend.product.product-multiple-update.index', compact('criteria'));

    }

    public function productMultipleUpdatePageSubmit(Request $request) {
        $criteria = $request->input('criteria');
        Log::info("Request Data: ", $request->all());
        $rules = [
            'criteria' => 'required|string',
            'product_id' => 'required|array',
        ];
    
        $products = $request->input('product_id', []);
        $fileProducts = $request->file('productsImage', []);
        //Log::info("product id top:", $products);
        //Log::info("Image Files: " . count($fileProducts) . " files uploaded.");
        $noUpdate = true;
        foreach ($products as $key => $productId) {
            Log::info("Product ID in foreach loop:", ['product_id' => $productId]);
            switch ($criteria) {
                case 'product-name':
                    if (isset($request->products_name[$key])) {
                        $rules["products_name.{$key}"] = [
                            'required',
                            'string',
                            'max:255',
                            Rule::unique('products', 'title')->ignore($productId)
                        ];
                    }
                    break;
                case 'meta-title-description':
                    if (isset($request->products_meta_title[$key])) {
                        $rules["products_meta_title.{$key}"] = 'nullable|string|max:255';
                    }
                    if (isset($request->products_meta_description[$key])) {
                        $rules["products_meta_description.{$key}"] = 'nullable|string|max:255';
                    }
                    break;
                case 'product-description':
                    if (isset($request->products_description[$key])) {
                        $rules["products_description.{$key}"] = 'nullable|string';
                    }
                    break;
                case 'product-specification':
                    if (isset($request->products_specification[$key])) {
                        $rules["products_specification.{$key}"] = 'nullable|string';
                    }
                    break;
                case 'product-image':
                    if (isset($fileProducts[$key])) {
                       // Log::info("Image {$key}: " . $fileProducts[$key]);
                        $rules["productsImage.{$key}.*"] = 'image|mimes:jpg,jpeg,png,gif,webp|max:2048';
                    }
                case 'video-id':
                    if (isset($request->products_video_id[$key])) {
                        $rules["products_video_id.{$key}"] = 'nullable|string|max:255';
                    }
                    break;
            }
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }
    
        DB::beginTransaction();
        try {
            foreach ($products as $key => $productId) {
                $product = Product::findOrFail($productId);
                //Log::info("Updating product ID: {$product->id}");
                $updated = false;
    
                if ($criteria === 'product-name' && isset($request->products_name[$key])) {
                    if ($product->title !== $request->products_name[$key]) {
                        Log::info("Updating product name for product ID: {$productId} to {$request->products_name[$key]}");
                        $product->title = $request->products_name[$key];
                        $updated = true;
                    }
                    $msg ="Product name updated successfully.";
                }
    
                if ($criteria === 'meta-title-description') {
                    if (isset($request->products_meta_title[$key])) {
                        Log::info("Updating meta title for product ID: {$productId} to {$request->products_meta_title[$key]}");
                        $product->meta_title = $request->products_meta_title[$key];
                        $updated = true;
                    }
                    if (isset($request->products_meta_description[$key])) {
                        Log::info("Updating meta description for product ID: {$productId} to {$request->products_meta_description[$key]}");
                        $product->meta_description = $request->products_meta_description[$key];
                        $updated = true;
                        
                    }
                    $msg ="Product meta title, meta description updated successfully.";
                }
    
                if ($criteria === 'product-description' && isset($request->products_description[$key])) {
                    Log::info("Updating product description for product ID: {$productId}.");
                    $product->product_description = $request->products_description[$key];
                    $updated = true;
                    $msg ="Product description updated successfully.";
                }
    
                if ($criteria === 'product-specification' && isset($request->products_specification[$key])) {
                    Log::info("Updating product specification for product ID: {$productId}.");
                    $product->product_specification = $request->products_specification[$key];
                    $updated = true;
                    $msg ="Product specification updated successfully.";
                }
    
                if ($criteria === 'product-image' && isset($fileProducts[$key])) {
                    $images = is_array($fileProducts[$key]) ? $fileProducts[$key] : [$fileProducts[$key]];
                    Log::info("Image File Count: " . count($images) . " images to be processed. Product id {$product->id}");
                    $product_row = Product::where('id', $product->id)->firstOrFail();
                    foreach ($images as $image_single) {
                        $image = $image_single;
                        $timestamp = round(microtime(true) * 1000); 
                        $filenameWithExt = $image->getClientOriginalName();
                        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                        $sanitized_title = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $product_row->title));
                        $image_file_name_webp = 'GD-sons-kitchen-Varanasi-' . $sanitized_title . '-' . $timestamp . '.webp';
                        $image_file_name_jpg = 'GD-sons-kitchen-Varanasi-' . $sanitized_title . '-' . $timestamp . '.jpg';
                        //Log::info("Processing image: Original Name - {$filenameWithExt}, New Name - {$image_file_name}");
                        $this->saveProductImages($image, $image_file_name_webp);
                        $this->saveProductImagesToJpg($image, $image_file_name_jpg);
                        Log::info("Image saved:  {$image_file_name_webp}  Product id {$product->id}");
                        ProductImages::create([
                            'product_id' => $product->id,
                            'image_path' => $image_file_name_webp,
                            'sort_order' => 0,
                        ]);
                        $updated = true;
                    }
                    $msg ="Product images updated successfully.";
                }
                if ($criteria === 'video-id' && isset($request->products_video_id[$key])) {
                    $product->video_id = $request->products_video_id[$key];
                    $updated = true;
                    $msg ="Product Video id updated successfully.";
                }
    
                if ($updated) {
                    $product->save();
                    $noUpdate = false;
                    Log::info("Product ID: {$productId} updated successfully.");
                }
            }
    
            if ($noUpdate) {
                Log::warning("No product values were updated.");
                return response()->json([
                    'status' => 'error',
                    'message' => 'No product values were updated.',
                ], 400);
            }
    
            DB::commit();
            Log::info("All products updated successfully.");
            return response()->json([
                'status' => 'success',
                'message' => $msg,
            ], 200);
    
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error updating products: {$e->getMessage()}");
            return response()->json([
                'status' => 'error',
                'message' => 'Error updating products: ' . $e->getMessage(),
            ], 500);
        }
    }

    private function saveProductImagesToJpg($image, $image_file_name){
        // Thumbnail Image (250x250)
        $destination_path_thumb = public_path('images/product/jpg-image/thumb/');
        File::ensureDirectoryExists($destination_path_thumb);
        $img_thumb = Image::make($image->getRealPath());
        $img_thumb->resize(250, 250, function ($constraint) {
            $constraint->aspectRatio();
        })->encode('jpg', 90)->save($destination_path_thumb . '/' . $image_file_name);        
    }

    
}    