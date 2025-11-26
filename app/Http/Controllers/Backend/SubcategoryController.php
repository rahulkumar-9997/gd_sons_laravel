<?php
namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Intervention\Image\Facades\Image;
class SubcategoryController extends Controller
{
    public function index(){
        $data['subcategory_list'] = Subcategory::with('category')->get(); 
        // Fetch all categories with their sub-categories
        //$categories = Category::with('subCategories')->get();

        return view('backend.subcategory.index', compact('data'));
    }

    public function create(Request $request){
        $token = $request->input('_token'); 
        $size = $request->input('size'); 
        $url = $request->input('url'); 
        $category = Category::orderBy('id','DESC')->get(); 
        $form = '
        <div class="modal-body">
            <form method="POST" action="'.route('subcategory.store').'" accept-charset="UTF-8" enctype="multipart/form-data" id="uploadForm">
                '.csrf_field().'
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="name" class="form-label">Subcategory Name</label>
                            <input type="text" id="name" name="name" class="form-control" required="">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="category_description" class="form-label">Subcategory Description</label>
                            <textarea class="form-control" id="category_description" rows="3" name="description"></textarea>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label for="category" class="form-label">Select Category</label>
                            <select class="form-select" id="category" name="category">
                                <option value="">Select Category</option>';
                                foreach ($category as $cat) {
                                    $form .= '<option value="'.$cat->id.'">'.$cat->title.'</option>';
                                }
                            $form .= ' 
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="image" class="form-label">Category Image</label>
                            <input type="file" id="image" name="image" class="form-control" required="">
                        </div>
                    </div>
                    
                    <div class="mb-3 col-md-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="status" name="status">
                            <label class="form-check-label" for="status">Status</label>
                        </div>
                    </div>
                    
                    <div class="modal-footer pb-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
        ';

        return response()->json([
            'message' => 'Subcategory Form created successfully',
            'form' => $form,
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $input['title'] = $request->input('name');
        $input['description'] = $request->input('description');
        $input['category_id'] = $request->input('category');
        if(!empty($request->input('status'))){
            $input['status'] = $request->input('status');
        }else{
            $input['status'] = 'on';
        }
        
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            // Set timezone to Asia/Kolkata
            date_default_timezone_set('Asia/Kolkata');
            // Get image filename and extension
            $filenameWithExt = $image->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $image_name = str_replace('-', '', $filename);
            $extension = $image->getClientOriginalExtension();
            
            // Get the current timestamp and microtime
            $time = time();
            $microtime = microtime(true);
            $milliseconds = sprintf("%03d", ($microtime - floor($microtime)) * 1000);
            $date_his = date("h-i-s", $microtime);
            $timeWithMilliseconds = $date_his . '-' . $milliseconds;
            $date_time = $image_name.'-'.$timeWithMilliseconds;
            
            // Set image file name
            $image_file_name = 'subcategory-image-' . $date_time . '.webp'; // Save as WebP
        
            // ------------------------------
            // LARGE IMAGE (1920x1080)
            $destination_path_large = public_path('images/subcategory/large/');
            $img_large = Image::make($image->getRealPath());
            $img_large->resize(1920, 1080, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('webp', 90)->save($destination_path_large . '/' . $image_file_name); // Convert to WebP and save
        
            // ------------------------------
            // SMALL IMAGE (800x600)
            $destination_path_small = public_path('images/subcategory/small/');
            $img_small = Image::make($image->getRealPath());
            $img_small->resize(800, 600, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('webp', 90)->save($destination_path_small . '/' . $image_file_name); // Convert to WebP and save
        
            // ------------------------------
            // THUMB IMAGE (150x150)
            $destination_path_thumb = public_path('images/subcategory/thumb/');
            $img_thumb = Image::make($image->getRealPath());
            $img_thumb->resize(150, 150, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('webp', 90)->save($destination_path_thumb . '/' . $image_file_name); // Convert to WebP and save
        
            // ------------------------------
            // ICON IMAGE (150x150)
            $destination_path_icon = public_path('images/subcategory/icon/');
            $img_icon = Image::make($image->getRealPath());
            $img_icon->resize(150, 150, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('webp', 90)->save($destination_path_icon . '/' . $image_file_name); // Convert to WebP and save
        
            // ------------------------------
            // ORIGINAL IMAGE (save as WebP)
            $destinationPath = public_path('images/subcategory/original/');
            $img_original = Image::make($image->getRealPath());
            $img_original->encode('webp', 90)->save($destinationPath . '/' . $image_file_name); // Convert to WebP and save       
            // ------------------------------
            // Save image data into database (WebP image path)
            $input['image'] = $image_file_name;
        }
        $subcategory_create = Subcategory::create($input);
        if($subcategory_create){
            return redirect('subcategory')->with('success','Subcategory created successfully');
        }else{
             return redirect()->back()->with('error','Somthings went wrong please try again !.');
        }
    }
    
    public function edit(Request $request){
        $token = $request->input('_token'); 
        $size = $request->input('size'); 
        $url = $request->input('url'); 
        $subcategory_id = $request->input('subcategory_id'); 
        $subcategory_row = Subcategory::find($subcategory_id);
        $category = Category::orderBy('id','DESC')->get();
        $subcategory_status ='';
        $subcategory_image ='';
        if($subcategory_row->status=='on'){
            $subcategory_status ='checked';
        }
        if (!empty($subcategory_row->image)) {
            $subcategory_image = '
            <div class="col-md-4">
                <div class="mb-3">
                    <img src="'. asset('images/subcategory/thumb/' . $subcategory_row->image) . '" style="width: 100px;">
                </div>
            </div>
            ';
        }
        $form = '
        <div class="modal-body">
            <form method="POST" action="'.route('subcategory.update', $subcategory_row->id).'" accept-charset="UTF-8" enctype="multipart/form-data" id="uploadForm">
                '.csrf_field().'
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="name" class="form-label">Subcategory Name</label>
                            <input type="text" id="name" name="name" value="' . $subcategory_row->title . '" class="form-control" required="">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="category_description" class="form-label">Subcategory Description</label>
                            <textarea class="form-control" id="category_description" rows="3" name="description">'.$subcategory_row->description.'</textarea>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label for="category" class="form-label">Select Category</label>
                            <select class="form-select" id="category" name="category">
                                <option value="">Select Category</option>';
                                foreach ($category as $cat) {
                                    $selected = ($cat->id == $subcategory_row->category_id) ? 'selected' : '';
                                    $form .= '<option value="'.$cat->id.'" '.$selected.'>'.$cat->title.'</option>';
                                }
                            $form .= '
                            </select>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="image" class="form-label">Category Image</label>
                            <input type="file" id="image" name="image" class="form-control">
                        </div>
                    </div>
                    '.$subcategory_image.'
                    
                    <div class="mb-3 col-md-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" '.$subcategory_status.'>
                            <label class="form-check-label" for="status">Status</label>
                        </div>
                    </div>
                    
                    <div class="modal-footer pb-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
        ';
        return response()->json([
            'message' => 'Subcategory Form created successfully',
            'form' => $form,
        ]);
    }

    public function updateSubcategory(Request $request, $id){
        $subcategory_row = Subcategory::find($id);
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $input['title'] = $request->input('name');
        $input['description'] = $request->input('description');
        $input['category_id'] = $request->input('category');
        if(!empty($request->input('status'))){
            $input['status'] = $request->input('status');
        }else{
            $input['status'] = 'on';
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
            $old_large_image = public_path('images/subcategory/large/'.$subcategory_row->image);
            $old_small_image = public_path('images/subcategory/small/'.$subcategory_row->image);
            $old_thumb_image = public_path('images/subcategory/thumb/'.$subcategory_row->image);
            $old_icon_image = public_path('images/subcategory/icon/'.$subcategory_row->image);
            $old_original_image = public_path('images/subcategory/original/'.$subcategory_row->image);
            
            
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
            $image_file_name = 'subcategory-image-' . $date_time . '.webp'; // Save as WebP
        
            // LARGE IMAGE (1920x1080)
            $destination_path_large = public_path('images/subcategory/large/');
            $img_large = Image::make($image->getRealPath());
            $img_large->resize(1920, 1080, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('webp', 90)->save($destination_path_large . '/' . $image_file_name);

            // SMALL IMAGE (800x600)
            $destination_path_small = public_path('images/subcategory/small/');
            $img_small = Image::make($image->getRealPath());
            $img_small->resize(800, 600, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('webp', 90)->save($destination_path_small . '/' . $image_file_name); 

            // THUMB IMAGE (150x150)
            $destination_path_thumb = public_path('images/subcategory/thumb/');
            $img_thumb = Image::make($image->getRealPath());
            $img_thumb->resize(150, 150, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('webp', 90)->save($destination_path_thumb . '/' . $image_file_name); 

            // ICON IMAGE (150x150)
            $destination_path_icon = public_path('images/subcategory/icon/');
            $img_icon = Image::make($image->getRealPath());
            $img_icon->resize(150, 150, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('webp', 90)->save($destination_path_icon . '/' . $image_file_name); 

            // ORIGINAL IMAGE (save as WebP)
            $destinationPath = public_path('images/subcategory/original/');
            $img_original = Image::make($image->getRealPath());
            $img_original->encode('webp', 90)->save($destinationPath . '/' . $image_file_name); 
            // Save image data into database (WebP image path)
            $input['image'] = $image_file_name;
        }
        $subcategory_row_update = $subcategory_row->update($input);
        if($subcategory_row_update){
            return redirect('subcategory')->with('success','Subcategory updated successfully');
        }else{
             return redirect()->back()->with('error','Somthings went wrong please try again !.');
        }
    }

}
