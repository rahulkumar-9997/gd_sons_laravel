<?php
namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use Intervention\Image\Facades\Image;
class BrandController extends Controller
{
    public function index(){
        $data['brand_list'] = Brand::orderBy('id','DESC')->get(); 
        return view('backend.brand.index', compact('data'));
    }

    public function create(Request $request){
        $token = $request->input('_token'); 
        $size = $request->input('size'); 
        $url = $request->input('url'); 
        $add_brand_form ='
        <div class="modal-body">
            <form method="POST" action="'.route('brand.store').'" accept-charset="UTF-8" enctype="multipart/form-data" id="uploadForm">
                '.csrf_field().'
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" name="name" class="form-control" required="">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" id="image" name="image" class="form-control">
                        </div>
                    </div>
                    
                    <div class="mb-3 col-md-6">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="status" name="status">
                            <label class="form-check-label" for="status">Status</label>
                        </div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="is_popular" name="is_popular">
                            <label class="form-check-label" for="is_popular">Is Popular ?</label>
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
            'message' => 'Brand Form created successfully',
            'form' => $add_brand_form,
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $input['title'] = $request->input('name');
        if(!empty($request->input('status'))){
            $input['status'] = $request->input('status');
        }else{
            $input['status'] = 'on';
        }
        if(!empty($request->input('is_popular'))){
            $input['is_popular'] = $request->input('is_popular');
        }else{
            $input['is_popular'] = 'off';
        }
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
        
            // Set timezone to Asia/Kolkata
            date_default_timezone_set('Asia/Kolkata');
        
            // Get image filename and extension
            $filenameWithExt = $image->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $image_name = str_replace('-', ' ', $filename);
            $extension = $image->getClientOriginalExtension();
            
            // Get the current timestamp and microtime
            $time = time();
            $microtime = microtime(true);
            $milliseconds = sprintf("%03d", ($microtime - floor($microtime)) * 1000);
            $date_his = date("h-i-s", $microtime);
            $timeWithMilliseconds = $date_his . '-' . $milliseconds;
            $date_time = $image_name.'-'.$timeWithMilliseconds;
            
            // Set image file name
            $image_file_name = 'brand-image-' . $date_time . '.webp'; // Save as WebP
        
            // ------------------------------
            // LARGE IMAGE (1920x1080)
            $destination_path_large = public_path('images/brand/large/');
            $img_large = Image::make($image->getRealPath());
            $img_large->resize(1920, 1080, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('webp', 90)->save($destination_path_large . '/' . $image_file_name); // Convert to WebP and save
        
            // ------------------------------
            // SMALL IMAGE (800x600)
            $destination_path_small = public_path('images/brand/small/');
            $img_small = Image::make($image->getRealPath());
            $img_small->resize(800, 600, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('webp', 90)->save($destination_path_small . '/' . $image_file_name); // Convert to WebP and save
        
            // ------------------------------
            // THUMB IMAGE (150x150)
            $destination_path_thumb = public_path('images/brand/thumb/');
            $img_thumb = Image::make($image->getRealPath());
            $img_thumb->resize(150, 150, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('webp', 90)->save($destination_path_thumb . '/' . $image_file_name); // Convert to WebP and save
        
            // ------------------------------
            // ICON IMAGE (150x150)
            $destination_path_icon = public_path('images/brand/icon/');
            $img_icon = Image::make($image->getRealPath());
            $img_icon->resize(150, 150, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('webp', 90)->save($destination_path_icon . '/' . $image_file_name); // Convert to WebP and save
        
            // ------------------------------
            // ORIGINAL IMAGE (save as WebP)
            $destinationPath = public_path('images/brand/original/');
            $img_original = Image::make($image->getRealPath());
            $img_original->encode('webp', 90)->save($destinationPath . '/' . $image_file_name); // Convert to WebP and save       
            // ------------------------------
            // Save image data into database (WebP image path)
            $input['image'] = $image_file_name;
        }
        $brand_create = Brand::create($input);
        if($brand_create){
            return redirect('brand')->with('success','Brand created successfully');
        }else{
             return redirect()->back()->with('error','Somthings went wrong please try again !.');
        }
    }

    public function updateStatus(Request $request){
        $brandId = $request->input('brand_id');
        if ($request->has('popular_action')) {
            $is_popular_status = $request->input('is_popular');
            $brand = Brand::find($brandId);
            if ($brand) {
                $brand->is_popular = $is_popular_status;
                $brand->save();
                return response()->json(['message' => 'Is popular status updated successfully', 'status' =>true]);
            }
            return response()->json(['message' =>'Somthings went wrong please try again !.' , 'message' =>false]);
        }else{
            $status = $request->input('status');
            $brand = Brand::find($brandId);
            if ($brand) {
                $brand->status = $status;
                $brand->save();
                return response()->json(['message' => 'Brand status updated successfully', 'status' =>true]);
            }
            return response()->json(['message' =>'Somthings went wrong please try again !.' , 'message' =>false]);
        }
    }

    public function edit(Request $request){
        $token = $request->input('_token'); 
        $size = $request->input('size'); 
        $url = $request->input('url'); 
        $brand_id = $request->input('brand_id'); 
        $brand_row = Brand::find($brand_id);
        $brand_status ='';
        $is_popular_status ='';
        $brand_image ='';
        if($brand_row->status=='on'){
            $brand_status ='checked';
        }
        if($brand_row->is_popular=='on'){
            $is_popular_status ='checked';
        }

        if (!empty($brand_row->image)) {
            $brand_image = '
            <div class="col-md-6">
                <div class="mb-3">
                    <img src="'. asset('images/brand/thumb/' . $brand_row->image) . '" style="width: 100px;">
                </div>
            </div>
            ';
        }
        //dd($brand);
        $add_brand_form = '
        <div class="modal-body">
            <form method="POST" action="' . route('brand.update', $brand_row->id) . '" accept-charset="UTF-8" enctype="multipart/form-data" id="uploadForm">
                ' . csrf_field() . '
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" value="' . $brand_row->title . '" id="name" name="name" class="form-control" required="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" id="image" name="image" class="form-control">
                        </div>
                    </div>
                    ' . $brand_image . '
                    <div class="mb-3 col-md-6">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" ' . $brand_status . '>
                            <label class="form-check-label" for="status">Status</label>
                        </div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="is_popular" name="is_popular" ' . $is_popular_status . '>
                            <label class="form-check-label" for="is_popular">Is Popular ?</label>
                        </div>
                    </div>
                    <div class="modal-footer pb-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
        </div>';
        return response()->json([
            'message' => 'Brand Form created successfully',
            'form' => $add_brand_form,
            'form2' => $brand_row,
        ]);
    }

    public function updateBrand(Request $request, $id){
        $brand_row = Brand::find($id);
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $input['title'] = $request->input('name');
        if(!empty($request->input('status'))){
            $input['status'] = $request->input('status');
        }else{
            $input['status'] = 'on';
        }
        if(!empty($request->input('is_popular'))){
            $input['is_popular'] = $request->input('is_popular');
        }else{
            $input['is_popular'] = 'off';
        }
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
        
            // Set timezone to Asia/Kolkata
            date_default_timezone_set('Asia/Kolkata');
        
            // Get image filename and extension
            $filenameWithExt = $image->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $image_name = str_replace('-', ' ', $filename);
            $extension = $image->getClientOriginalExtension();
            
            // Get the current timestamp and microtime
            $time = time();
            $microtime = microtime(true);
            $milliseconds = sprintf("%03d", ($microtime - floor($microtime)) * 1000);
            $date_his = date("h-i-s", $microtime);
            $timeWithMilliseconds = $date_his . '-' . $milliseconds;
            $date_time = $image_name.'-'.$timeWithMilliseconds;
            /**unlink image file */
            $old_large_image = public_path('images/brand/large/'.$brand_row->image);
            $old_small_image = public_path('images/brand/small/'.$brand_row->image);
            $old_thumb_image = public_path('images/brand/thumb/'.$brand_row->image);
            $old_icon_image = public_path('images/brand/icon/'.$brand_row->image);
            $old_original_image = public_path('images/brand/original/'.$brand_row->image);
            
            
            if (file_exists($old_large_image) && !is_dir($old_large_image)) {
                unlink($old_large_image);
            } 
            if (file_exists($old_small_image) && !is_dir($old_small_image)) {
                unlink($old_small_image);
            } 
            if (file_exists($old_thumb_image) && !is_dir($old_thumb_image)) {
                unlink($old_thumb_image);
            }
            if (file_exists($old_icon_image) && !is_dir($old_icon_image)) {
                unlink($old_icon_image);
            }
            if (file_exists($old_original_image) && !is_dir($old_original_image)) {
                unlink($old_original_image);
            }
            /**unlink image file */
            // Set image file name
            $image_file_name = 'brand-image-' . $date_time . '.webp'; // Save as WebP
        
            // LARGE IMAGE (1920x1080)
            $destination_path_large = public_path('images/brand/large/');
            $img_large = Image::make($image->getRealPath());
            $img_large->resize(1920, 1080, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('webp', 90)->save($destination_path_large . '/' . $image_file_name);

            // SMALL IMAGE (800x600)
            $destination_path_small = public_path('images/brand/small/');
            $img_small = Image::make($image->getRealPath());
            $img_small->resize(800, 600, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('webp', 90)->save($destination_path_small . '/' . $image_file_name); 

            // THUMB IMAGE (150x150)
            $destination_path_thumb = public_path('images/brand/thumb/');
            $img_thumb = Image::make($image->getRealPath());
            $img_thumb->resize(150, 150, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('webp', 90)->save($destination_path_thumb . '/' . $image_file_name); 

            // ICON IMAGE (150x150)
            $destination_path_icon = public_path('images/brand/icon/');
            $img_icon = Image::make($image->getRealPath());
            $img_icon->resize(150, 150, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('webp', 90)->save($destination_path_icon . '/' . $image_file_name); 

            // ORIGINAL IMAGE (save as WebP)
            $destinationPath = public_path('images/brand/original/');
            $img_original = Image::make($image->getRealPath());
            $img_original->encode('webp', 90)->save($destinationPath . '/' . $image_file_name); 
            // Save image data into database (WebP image path)
            $input['image'] = $image_file_name;
        }
        $brand_row_update = $brand_row->update($input);
        if($brand_row_update){
            return redirect('brand')->with('success','Brand updated successfully');
        }else{
             return redirect()->back()->with('error','Somthings went wrong please try again !.');
        }
    }

    public function deleteBrand(Request $request, $id){
        $brand_row = Brand::find($id);
        /*Unlink image*/
         /**unlink image file */
         $old_large_image = public_path('images/brand/large/'.$brand_row->image);
         $old_small_image = public_path('images/brand/small/'.$brand_row->image);
         $old_thumb_image = public_path('images/brand/thumb/'.$brand_row->image);
         $old_icon_image = public_path('images/brand/icon/'.$brand_row->image);
         $old_original_image = public_path('images/brand/original/'.$brand_row->image);
         
         
         if (file_exists($old_large_image) && !is_dir($old_large_image)) {
             unlink($old_large_image);
         } 
         if (file_exists($old_small_image) && !is_dir($old_small_image)) {
             unlink($old_small_image);
         } 
         if (file_exists($old_thumb_image) && !is_dir($old_thumb_image)) {
             unlink($old_thumb_image);
         }
         if (file_exists($old_icon_image) && !is_dir($old_icon_image)) {
             unlink($old_icon_image);
         }
         if (file_exists($old_original_image) && !is_dir($old_original_image)) {
             unlink($old_original_image);
         }
         /**unlink image file */
        $brand_row->delete();
        return redirect('brand')->with('success','Brand deleted successfully');
    }
}
