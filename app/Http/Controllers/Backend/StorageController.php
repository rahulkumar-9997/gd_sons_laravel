<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Models\ImageStorage;
use Illuminate\Support\Facades\Log;

class StorageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $data['image_storage'] = ImageStorage::all(); 
        return view('backend.manage-storage.index', compact('data'));
    }

    public function create(Request $request){
        $token = $request->input('_token'); 
        $size = $request->input('size'); 
        $url = $request->input('url'); 
        $form ='
            <div class="modal-body">
                <div id="error-container"></div>
                <form method="POST" action="'.route('manage-storage.submit').'" accept-charset="UTF-8" enctype="multipart/form-data" id="imageStorage">
                    '.csrf_field().'
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="product_image" class="form-label"> Select Images Multiple *</label>
                                <input type="file" id="storage_images" name="storage_images[]" class="form-control"  accept="image/*" multiple>
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductImageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'storage_images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ]);

        if ($request->hasFile('storage_images')) {
            DB::beginTransaction();
            try {
                $files = $request->file('storage_images');
                foreach ($files as $key => $file) {
                    $timestamp = round(microtime(true) * 1000);
                    $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $image_file_name_webp = 'GD-sons-kitchen-Varanasi-' . $timestamp . '.webp';
                    $this->saveImageAsWebp($file, $image_file_name_webp);
                    ImageStorage::create([
                        'image_storage_path' => $image_file_name_webp,
                    ]);
                }
                
                DB::commit();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Images uploaded successfully'
                ]);
                
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Image Storage Error: ' . $e->getMessage());
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to upload images. Please try again.'
                ], 500);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Please select at least one image file.'
            ], 400);
        }
    }

    private function saveImageAsWebp($image, $filename)
    {
        $storagePath = 'images/storage/';
        $fullPath = public_path($storagePath);
        if (!file_exists($fullPath)) {
            mkdir($fullPath, 0755, true);
        }
        
        $img = Image::make($image);
        $img->resize(1200, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $img->encode('webp', 90)->save($fullPath . $filename);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductImage  $productImage
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductImageRequest  $request
     * @param  \App\Models\ProductImage  $productImage
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductImage  $productImage
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
    }
}
