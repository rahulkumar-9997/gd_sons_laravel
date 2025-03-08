<?php
namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\MapCategoryAttributes;
use App\Models\UpdateHsnGstWithAttributes;
use Intervention\Image\Facades\Image;
use App\Models\MappedCategoryToAttributesForFront;
use Illuminate\Support\Facades\DB;
use Exception;
class CategoryController extends Controller
{
    public function index(){
        //$data['category_list'] = Category::with('attributes')->orderBy('id', 'desc')->get(); 
        $data['category_list'] = Category::with('attributes')->orderBy('id', 'desc')->get();
        $existingMappings = UpdateHsnGstWithAttributes::select('category_id', 'attributes_id')
            ->get()
            ->map(function ($item) {
                return [
                    'category_id' => $item->category_id,
                    'attributes_id' => $item->attributes_id
                ];
            })
            ->toArray();

        $data['existing_mappings'] = $existingMappings;
        //return response()->json($data['category_list']);
        return view('backend.category.index', compact('data'));
    }

    public function create(Request $request){
        $token = $request->input('_token'); 
        $size = $request->input('size'); 
        $url = $request->input('url'); 
        $attributes = Attribute::all();
        $form ='
        <div class="modal-body">
            <form method="POST" action="'.route('category.store').'" accept-charset="UTF-8" enctype="multipart/form-data" id="uploadForm">
                '.csrf_field().'
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="name" class="form-label">Category Name *</label>
                            <input type="text" id="name" name="name" class="form-control" required="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">HSN Code</label>
                            <input type="text" id="hsn_code" name="hsn_code" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-2">
                            <label for="name" class="form-label">Map Category Of More Attributes *</label>
                            <select class="js-example-basic-multiple" name="map_category_attributes[]" id="select-attributes" multiple="multiple" required="">
                                <option value="" disabled>Select Attributes</option>';
                                    foreach ($attributes as $attribute) {
                                        $form .= '<option value="' . $attribute->id . '">' . $attribute->title . '</option>';
                                    }
                                    $form .= '
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="category_heading" class="form-label">Category Heading</label>
                             <input class="form-control" type="text"  id="category_heading" name="category_heading">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="category_description" class="form-label">Category Description</label>
                            <textarea class="form-control" id="category_description" rows="2" name="description"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="image" class="form-label">Category Image *</label>
                            <input type="file" id="image" name="image" class="form-control" required="">
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
                            <input class="form-check-input" type="checkbox" role="switch" id="trending" name="trending">
                            <label class="form-check-label" for="trending">Trending</label>
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
            'message' => 'Category Form created successfully',
            'form' => $form,
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255|unique:category,title',
        ]);
        $input['title'] = $request->input('name');
        $input['hsn_code'] = $request->input('hsn_code');
        $input['description'] = $request->input('description');
        $input['category_heading'] = $request->input('category_heading');
        if(!empty($request->input('status'))){
            $input['status'] = $request->input('status');
        }else{
            $input['status'] = 'on';
        }
        if(!empty($request->input('trending'))){
            $input['trending'] = $request->input('trending');
        }else{
            $input['trending'] = 'off';
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

            $name_input = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->input('name')));
            $timestamp = round(microtime(true) * 1000); 
            $image_file_name = 'GD-sons-kitchen-Varanasi-' . $name_input . '-' . $timestamp . '.webp'; 
            // ------------------------------
            // LARGE IMAGE (1920x1080)
            $destination_path_large = public_path('images/category/large/');
            $img_large = Image::make($image->getRealPath());
            $img_large->resize(1920, 1080, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('webp', 90)->save($destination_path_large . '/' . $image_file_name); // Convert to WebP and save
        
            // ------------------------------
            // SMALL IMAGE (800x600)
            $destination_path_small = public_path('images/category/small/');
            $img_small = Image::make($image->getRealPath());
            $img_small->resize(800, 600, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('webp', 90)->save($destination_path_small . '/' . $image_file_name); // Convert to WebP and save
        
            // ------------------------------
            // THUMB IMAGE (150x150)
            $destination_path_thumb = public_path('images/category/thumb/');
            $img_thumb = Image::make($image->getRealPath());
            $img_thumb->resize(150, 150, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('webp', 90)->save($destination_path_thumb . '/' . $image_file_name); // Convert to WebP and save
        
            // ------------------------------
            // ICON IMAGE (150x150)
            $destination_path_icon = public_path('images/category/icon/');
            $img_icon = Image::make($image->getRealPath());
            $img_icon->resize(150, 150, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('webp', 90)->save($destination_path_icon . '/' . $image_file_name); // Convert to WebP and save
        
            // ------------------------------
            // ORIGINAL IMAGE (save as WebP)
            $destinationPath = public_path('images/category/original/');
            $img_original = Image::make($image->getRealPath());
            $img_original->encode('webp', 90)->save($destinationPath . '/' . $image_file_name); // Convert to WebP and save       
            // ------------------------------
            // Save image data into database (WebP image path)
            $input['image'] = $image_file_name;
        }
        $category_create = Category::create($input);
        if ($request->has('map_category_attributes')) {
            foreach ($request->map_category_attributes as $attributeId) {
                MapCategoryAttributes::create([
                    'category_id' => $category_create->id,
                    'attribute_id' => $attributeId,
                ]);
            }
        }
        if($category_create){
            return redirect('category')->with('success','Category created successfully');
        }else{
             return redirect()->back()->with('error','Somthings went wrong please try again !.');
        }
    }

    public function edit(Request $request, $id){
        $attributes = Attribute::all();
        $token = $request->input('_token'); 
        $size = $request->input('size'); 
        $url = $request->input('url'); 
        $brand_image = '';
        $category_status = '';
        $is_tr_status = '';
        $category_row = Category::with('attributes')->findOrFail($id);
        $category_status = ($category_row->status === 'on') ? 'checked' : '';
        $is_tr_status = ($category_row->trending === 'on') ? 'checked' : '';
        if (!empty($category_row->image)) {
            $brand_image = '
            <div class="col-md-6">
                <div class="mb-3">
                    <img src="'. asset('images/category/thumb/' . $category_row->image) . '" style="width: 100px;">
                </div>
            </div>
            ';
        }
        $form = '
        <div class="modal-body">
            <form method="POST" action="'.route('category.update', $category_row->id).'" accept-charset="UTF-8" enctype="multipart/form-data">
                '.csrf_field().'
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="name" class="form-label">Category Name *</label>
                            <input type="text" id="name" value="'.$category_row->title.'" name="name" class="form-control" required="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="hsn_code" class="form-label">HSN Code</label>
                            <input type="text" id="hsn_code" name="hsn_code" value="'.$category_row->hsn_code.'" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-2">
                            <label for="name" class="form-label">Map Category Of More Attributes</label>
                            <select class="js-example-basic-multiple" name="map_category_attributes[]" id="select-attributes" multiple="multiple" required="">
                                <option value="" disabled>Select Attributes</option>';
                                    foreach ($attributes as $attribute) {
                                        $selected = $category_row->attributes->contains($attribute->id) ? 'selected' : '';
                                        $form .= '<option value="' . $attribute->id . '" ' . $selected . '>' . $attribute->title . '</option>';
                                    }
                                    $form .= '
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="category_heading" class="form-label">Category Heading</label>
                            <input class="form-control" type="text"  id="category_heading" name="category_heading" value="'.$category_row->category_heading.'">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="category_description" class="form-label">Category Description</label>
                            <textarea class="form-control" id="category_description" rows="4" name="description">'.$category_row->description.'</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="image" class="form-label">Category Image</label>
                            <input type="file" id="image" name="image" class="form-control">
                        </div>
                    </div>
                    '.$brand_image.'
                    <div class="mb-3 col-md-6">
                        <div class="form-check form-switch">
                            <input class="form-check-input" '.$category_status.' type="checkbox" role="switch" id="status" name="status">
                            <label class="form-check-label" for="status">Status</label>
                        </div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <div class="form-check form-switch">
                            <input class="form-check-input" '.$is_tr_status.' type="checkbox" role="switch" id="trending" name="trending">
                            <label class="form-check-label" for="trending">Trending</label>
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
            'message' => 'Category Form created successfully',
            'form' => $form,
        ]);

    }

    public function updateCategory(Request $request, $id){
        $request->validate([
            'name' => 'required|string|max:255|unique:category,title,' . $id,
            //'map_category_attributes' => 'array',
            //'map_category_attributes.*' => 'integer|exists:attributes,id',
        ]);
        $category_row = Category::find($id);
        $input['title'] = $request->input('name');
        $input['category_heading'] = $request->input('category_heading');
        $input['hsn_code'] = $request->input('hsn_code');
        if(!empty($request->input('status'))){
            $input['status'] = $request->input('status');
           
        }else{
            $input['status'] = 'off';
        }

        if(!empty($request->input('trending'))){
            $input['trending'] = $request->input('trending');
        }else{
            $input['trending'] = 'off';
        }
        $input['description'] = $request->input('description');
        /** First delete all map_category_attributes from this category id*/
        MapCategoryAttributes::where('category_id', $id)->delete();
        /*Then, insert the new attribute IDs into the map_category_attributes table*/
        if ($request->has('map_category_attributes')) {
            foreach ($request->map_category_attributes as $attributeId) {
                MapCategoryAttributes::create([
                    'category_id' => $id,
                    'attribute_id' => $attributeId,
                ]);
            }
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
            $old_large_image = public_path('images/category/large/'.$category_row->image);
            $old_small_image = public_path('images/category/small/'.$category_row->image);
            $old_thumb_image = public_path('images/category/thumb/'.$category_row->image);
            $old_icon_image = public_path('images/category/icon/'.$category_row->image);
            $old_original_image = public_path('images/category/original/'.$category_row->image);
            
            
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
            $image_file_name = 'GD-sons-kitchen-Varanasi-' . $date_time . '.webp'; // Save as WebP
        
            // LARGE IMAGE (1920x1080)
            $destination_path_large = public_path('images/category/large/');
            $img_large = Image::make($image->getRealPath());
            $img_large->resize(1920, 1080, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('webp', 90)->save($destination_path_large . '/' . $image_file_name);

            // SMALL IMAGE (800x600)
            $destination_path_small = public_path('images/category/small/');
            $img_small = Image::make($image->getRealPath());
            $img_small->resize(800, 600, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('webp', 90)->save($destination_path_small . '/' . $image_file_name); 

            // THUMB IMAGE (150x150)
            $destination_path_thumb = public_path('images/category/thumb/');
            $img_thumb = Image::make($image->getRealPath());
            $img_thumb->resize(150, 150, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('webp', 90)->save($destination_path_thumb . '/' . $image_file_name); 

            // ICON IMAGE (150x150)
            $destination_path_icon = public_path('images/category/icon/');
            $img_icon = Image::make($image->getRealPath());
            $img_icon->resize(150, 150, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('webp', 90)->save($destination_path_icon . '/' . $image_file_name); 

            // ORIGINAL IMAGE (save as WebP)
            $destinationPath = public_path('images/category/original/');
            $img_original = Image::make($image->getRealPath());
            $img_original->encode('webp', 90)->save($destinationPath . '/' . $image_file_name); 
            // Save image data into database (WebP image path)
            $input['image'] = $image_file_name;
        }
        $category_row_update = $category_row->update($input);
        if($category_row_update){
            return redirect('category')->with('success','Category updated successfully');
        }else{
             return redirect()->back()->with('error','Somthings went wrong please try again !.');
        }
    }

    public function show($id){
        // $data['category_show'] = Category::with(['attributesWithMappedValues' => function ($query) {
        //     $query->with('AttributesValues');
        // }])->where('id', $id)->first();
        $data['category_show'] = Category::where('id', $id)
        ->with([
            'attributes' => function ($query) use ($id) {
                $query->whereHas('mappedValuesForCategory', function ($mappedQuery) use ($id) {
                    $mappedQuery->where('category_id', $id);
                })->with([
                    'AttributesValues' => function ($valueQuery) use ($id) {
                        $valueQuery->whereHas('map_attributes_value_to_categories', function ($mapQuery) use ($id) {
                            $mapQuery->where('category_id', $id);
                        });
                    }
                ]);
            }
        ])->first();
        $data['mapped_attributes'] = MappedCategoryToAttributesForFront::where('category_id', $data['category_show']->id)->pluck('attributes_id')->toArray();
        //return response()->json($data['category_show']);
        return view('backend.category.show', compact('data'));
    }

    public function saveMappedCategoryAttributes(Request $request){
        $request->validate([
            'category_id' => 'required|exists:category,id',
            'attributes' => 'nullable|array',
            'attributes.*' => 'exists:attributes,id'
        ]);
        DB::beginTransaction();

        try {
            $categoryId = $request->input('category_id');
            $selectedAttributes = $request->input('attributes', []); 
            MappedCategoryToAttributesForFront::where('category_id', $categoryId)
            ->whereNotIn('attributes_id', $selectedAttributes)
            ->delete();
            if ($request->has('attributes') && !empty($request->input('attributes'))) {
                foreach ($request->input('attributes') as $attributeId) {
                    $exists = MappedCategoryToAttributesForFront::where('category_id', $request->input('category_id'))
                        ->where('attributes_id', $attributeId)
                        ->exists();
                    if (!$exists) {
                        MappedCategoryToAttributesForFront::create([
                            'category_id' => $request->input('category_id'),
                            'attributes_id' => $attributeId,
                            'sort_order' => 1,
                            'status' => 1,
                        ]);
                    }
                }
                DB::commit();
                return redirect()->back()->with('success', 'Mapped attributes to category for front saved successfully !');
            } else {
                DB::commit(); 
                return redirect()->back()->with('error', 'No attributes selected.');
            }
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }
}
