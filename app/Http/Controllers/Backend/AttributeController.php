<?php
namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Attribute_values;
use App\Models\Category;
use App\Models\Product;
use App\Models\MapAttributesValueToCategory;
use App\Models\ProductAttributesValues;
use App\Models\UpdateHsnGstWithAttributes;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class AttributeController extends Controller
{
    public function index(){
        $data['attributes_list'] = Attribute::with('AttributesValues')->get();
        $data['attributes_list'] = Attribute::with(['AttributesValues' => function($query) {
            $query->withCount('productAttributesValues');
        }])->get();
        
        //return response()->json($data['attributes_list']);
        return view('backend.attributes.index', compact('data'));
    }

    public function create(Request $request){
        $token = $request->input('_token'); 
        $size = $request->input('size'); 
        $url = $request->input('url'); 
        $form ='
        <div class="modal-body">
            <form method="POST" action="'.route('attributes.store').'" accept-charset="UTF-8" enctype="multipart/form-data" id="uploadForm">
                '.csrf_field().'
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="name" class="form-label">Attributes Name</label>
                            <input type="text" id="name" name="name" class="form-control" required="">
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
            'message' => 'Attributes Form created successfully',
            'form' => $form,
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255|unique:attributes,title',
        ]);
        $input['title'] = $request->input('name');
        $existingAttribute = Attribute::where('title', $input['title'])->first();
        if ($existingAttribute) {
            return redirect()->back()->withInput()->with('error', 'Attribute already exists!');
        } else {
            $attributes_create = Attribute::create($input);
            if ($attributes_create) {
                return redirect()->back()->withInput()->with('success', 'Attributes created successfully');
            } else {
                return redirect()->back()->withInput()->with('error', 'Something went wrong, please try again!');
            }
        }
    }

    public function edit(Request $request){
        $token = $request->input('_token'); 
        $size = $request->input('size'); 
        $url = $request->input('url'); 
        $attributes_id = $request->input('attributes_id'); 
        $attributes_row = Attribute::find($attributes_id);
        
        $form = '
        <div class="modal-body">
            <form method="POST" action="'.route('attributes.update', $attributes_row->id) . '" accept-charset="UTF-8" enctype="multipart/form-data" id="uploadForm">
                ' . csrf_field() . '
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" value="' . $attributes_row->title . '" id="name" name="name" class="form-control" required="">
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
            'message' => 'Attributes Form created successfully',
            'form' => $form,
        ]);
    }

    public function updateAttributes(Request $request, $id){
        $request->validate([
            'name' => 'required|string|max:255|unique:attributes,title,' . $id,
        ]);
        $attributes_row = Attribute::find($id);
        if(!$attributes_row) {
            return redirect()->back()->with('error', 'Attribute not found.');
        }
        $input['title'] = $request->input('name');
        $attributes_row_update = $attributes_row->update($input);
        if($attributes_row_update){
            return redirect('attributes')->with('success','Attributes updated successfully');
        }else{
             return redirect()->back()->with('error','Somthings went wrong please try again !.');
        }
    }

    public function productCatalogWithAttributesValue(Request $request, $attributes_value_id){
        $attributes_value = Attribute_values::findOrFail($attributes_value_id);
        $data['product_list'] = Product::with('category') 
        ->whereHas('productAttributesValuesForBackend', function($query) use ($attributes_value_id) {
            $query->where('attributes_value_id', $attributes_value_id);
        })->with(['images'])->paginate(50);
        //return response()->json($data['product_list']);
        return view('backend.attributes-option.product-list-with-attributes-value', compact('data', 'attributes_value'));
    }

    public function attributesOption(Request $request, $id){    
        $category_list  = Category::orderBy('id','DESC')->get();
        //$attributes = Attribute::with('AttributesValues')->where('id', $id)->first();
        $attributes = Attribute::with(['AttributesValues' => function($query) {
            $query->with('map_attributes_value_to_categories'); 
        }])->where('id', $id)->first();
        //return response()->json($attributes);
        return view('backend.attributes-option.index', compact('attributes', 'category_list'));
    }

    public function attributesValueStore(Request $request){
        $request->validate([
            'name' => 'required|string|max:255|unique:attributes_value,name',
        ]);
        $attributes_id = $request->input('attributes_id');
        $attribute_value_name = $request->input('name');
        /*make unique slug*/
        $slug = Str::slug($attribute_value_name);
        $originalSlug = $slug;
        $counter = 1;
        while (Attribute_values::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$counter}";
            $counter++;
        }
        /*make unique slug*/
        $input['slug'] =  $slug;
        $attributes_value_create = Attribute_values::firstOrCreate(
            ['name' =>  $attribute_value_name, 'attributes_id' => $attributes_id],
            ['slug' => $slug]
        );
        if ($attributes_value_create) {
            foreach ($request->input('category') as $category_id) {
                MapAttributesValueToCategory::create([
                    'category_id' => $category_id,
                    'attributes_value_id' => $attributes_value_create->id,
                    'attributes_id' => $request->input('attributes_id'),
                ]);
            }
            return redirect()->back()->with('success', 'Attribute Value added and mapped to categories successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong, please try again!');
        }
    }

    public function attributesValueEdit(Request $request){
        $token = $request->input('_token'); 
        $size = $request->input('size'); 
        $url = $request->input('url'); 
        $category_list = Category::orderBy('id', 'DESC')->get();
        $attributes_value_id = $request->input('attributes_value_id'); 
        $attributes_id = $request->input('attributes_id'); 
        $attributes_value_row = Attribute_values::find($attributes_value_id);
        $mapped_attributes_value_category_ids = $attributes_value_row->map_attributes_value_to_categories->pluck('id')->toArray();
        $form = '
        <div class="modal-body">
            <form method="POST" action="' . route('attributes-value.update', $attributes_value_row->id) . '" accept-charset="UTF-8" enctype="multipart/form-data" id="uploadForm">
                ' . csrf_field() . '
                <input type="hidden" value="'.$attributes_id.'" name="attribute_id">
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" value="' . $attributes_value_row->name . '" id="name" name="name" class="form-control" required="">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-2">
                            <label for="name" class="form-label">Map Attributes Value to More Category</label>
                            <select class="js-example-basic-multiple" name="mapped_attributes_value_to_category[]" id="mapped_attributes_value_to_category" multiple="multiple">
                                <option value="" disabled>Select Category</option>';
                                    foreach ($category_list as $category) {
                                        $selected = in_array($category->id, $mapped_attributes_value_category_ids) ? 'selected' : '';
                                        $form .= '<option value="' . $category->id . '" ' . $selected . '>' . $category->title . '</option>';
                                    }
                                $form .= '
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer pb-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>';

        return response()->json([
            'message' => 'Attributes Value Form created successfully',
            'form' => $form,
        ]);
    }

    public function updateAttributesValue(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'attribute_id' => 'required|exists:attributes,id',
        ]);
        DB::beginTransaction();
        try {
            $attributes_value_row = Attribute_values::findOrFail($id);
            $attributes_value_row->update([
                'name' => $request->input('name')
            ]);
            $selectedCategories = $request->input('mapped_attributes_value_to_category', []);
                $attributes_value_row->map_attributes_value_to_categories()->syncWithPivotValues(
                $selectedCategories,
                ['attributes_id' => $request->input('attribute_id')]
            );
            DB::commit();
            return redirect()->back()->with('success', 'Attributes value updated successfully');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Attribute value not found.');

        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            Log::error('Attribute value update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Database error occurred.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Attribute value update error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function deletaAttributesValue(Request $request, $id){
        $attributes_value_row = Attribute_values::find($id);
        $attributes_value_row->delete();
        return redirect()->back()->with('success','Attributes Value deleted successfully');
    }

    public function attributesValueList(){
        //$data['attributesvalue_list'] = Attribute_values::orderBy('id', 'desc')->get();
        $data['attributesvalue_list'] = Attribute_values::with('mappedCategories', 'productAttributesValues')
            ->orderBy('id', 'desc')
            ->get();

        foreach ($data['attributesvalue_list'] as $attributeValue) {
            // Check if there are mapped entries for each attribute value in both tables
            $attributeValue->is_mapped_in_category = $attributeValue->mappedCategories->isNotEmpty();
            $attributeValue->is_mapped_in_product = ProductAttributesValues::where('attributes_value_id', $attributeValue->id)->exists();
        }
        //return response()->json($data['attributesvalue_list']); 
        return view('backend.attributes-option.attributes-value-list', compact('data')); 
    }

    public function mergeAttributesValue(Request $request){
        $token = $request->input('_token'); 
        $attributes_id = $request->input('attributes_id'); 
        $merge_from_attributes_value_id = $request->input('merge_from_attributes_value_id'); 
        Log::info('Attribute ID:', ['id' => $attributes_id]);
        $filtered_attributes_value_array = Attribute_values::where('attributes_id', $attributes_id)->get();
        $form ='
        <div class="modal-body">
            <form method="POST" action="'.route('merge-attributes-value.submit').'" accept-charset="UTF-8" enctype="multipart/form-data" id="uploadForm">
                '.csrf_field().'
                <input type="hidden" value="'.$merge_from_attributes_value_id.'" name="merge_from_attributes_value_id">
                <input type="hidden" value="'.$attributes_id.'" name="attributes_id">
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-1">';
                        foreach ($filtered_attributes_value_array as $filtered_attributes_value) {
                            if($filtered_attributes_value->id == $merge_from_attributes_value_id){
                                $disabled = 'disabled';
                                $colour = 'style="color: red;"';
                            }else{
                                $disabled = '';
                                $colour ='';
                            }
                            $form .= '
                            <div class="form-check form-check-inline mb-1" '.$colour.'>
                                <input class="form-check-input" type="radio" name="merge_to_attributes_value" value="'.$filtered_attributes_value->id .'" id="attributes_value_'. $filtered_attributes_value->id .'" '.$disabled.'>
                                <label class="form-check-label" for="attributes_value_'. $filtered_attributes_value->id .'">
                                   '.$filtered_attributes_value->name.'
                                </label>
                            </div>';
                        }
                        $form .= '
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
            'message' => 'Merge attributes value form created successfully',
            'form' => $form,
        ]);
    }

    public function mergeAttributesValueFormSubmit(Request $request){
        Log::info('Request Data:', $request->all());
        $merge_from_attributes_value_id = $request->input('merge_from_attributes_value_id'); 
        $merge_to_attributes_value_id = $request->input('merge_to_attributes_value'); 
        $attributes_id = $request->input('attributes_id'); 
        DB::beginTransaction();
        try {
            /* Update MapAttributesValueToCategory records*/
            $updatedMapAttributes = MapAttributesValueToCategory::where('attributes_value_id', $merge_from_attributes_value_id)->update(['attributes_value_id' => $merge_to_attributes_value_id]);
            Log::info("MapAttributesValueToCategory records updated: $updatedMapAttributes");

            /*Update ProductAttributesValues records*/
            $updatedProductAttributes = ProductAttributesValues::where('attributes_value_id', $merge_from_attributes_value_id)->update(['attributes_value_id' => $merge_to_attributes_value_id]);
            Log::info("ProductAttributesValues records updated: $updatedProductAttributes");

            /* attributes_value table
                map_attributes_values_to_category table =>attributes_value_id
                product_attributes_values table =>attributes_value_id
            */
            /*delete attributes value */
            $deletedAttributeValue = Attribute_values::where('id', $merge_from_attributes_value_id)->delete();
            Log::info("Attribute_values record deleted: $deletedAttributeValue");
            /*delete attributes value */
            
            if ($updatedMapAttributes > 0 || $updatedProductAttributes > 0) {
                DB::commit();
                Log::info("Update Successful: Attribute value have been successfully updated.");
                return redirect()->back()->with('success', 'Attribute value has been successfully updated.');
            } else {
                DB::rollBack();
                Log::info("No records were updated.");
                return redirect()->back()->with('error', 'No records were updated.');
            }
        } 
        catch (\Exception $e) 
        {
            
            DB::rollBack();
            Log::error('Error during attribute value merge: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating the attribute value. Please try again.');
        }
    }

    public function sort(Request $request){
        $sortedIDs = $request->input('sortedIDs');
        foreach ($sortedIDs as $index => $id) {
            Attribute_values::where('id', $id)->update(['sort_order' => $index + 1]);
        }
        return response()->json(['success' => true, 'message'=>'Sort order updated successfully!']);
    }

    public function updateHsnGstWithAttributesValue($attributes_id, $category_id){
        $category = Category::find($category_id);
        $attribute = Attribute::find($attributes_id);
        // $attributesValues = Attribute_values::whereHas('map_attributes_value_to_categories', function ($query) use ($category_id) {
        //     $query->where('category_id', $category_id);
        // })->where('attributes_id', $attributes_id)->get();
        $attributesValues = Attribute_values::whereHas('map_attributes_value_to_categories', function ($query) use ($category_id) {
            $query->where('category_id', $category_id);
        })->where('attributes_id', $attributes_id)
          ->with(['hsnGst' => function ($query) use ($category_id, $attributes_id) {
              $query->where('category_id', $category_id)->where('attributes_id', $attributes_id);
        }])->get();
        //return response()->json($attributesValues);
        return view('backend.category.update-hsn-gst-with-attributes-value',  compact('category', 'attribute', 'attributesValues'));
    }

    public function updateHsnGstAttributesValueFormSubmit(Request $request){
        $validated = $request->validate([
            'attributes_value_id' => 'required|exists:attributes_value,id',
            'hsn_code' => 'required|regex:/^\d{4}(\d{2}){0,1}(\d{2}){0,1}$/',
            'gst_percentage' => 'required|numeric|min:0|max:100',
            'category_id' => 'required|exists:category,id',
            'attributes_id' => 'required|exists:attributes,id',
        ], [
            'hsn_code.regex' => 'HSN Code must be 4, 6, or 8 digits only.',
            'gst_percentage.required' => 'GST Percentage is required.',
            'gst_percentage.numeric' => 'GST Percentage must be a valid number.',
            'gst_percentage.min' => 'GST Percentage must be at least 0.',
            'gst_percentage.max' => 'GST Percentage cannot be more than 100.',
            'category_id.exists' => 'The selected category is invalid.',
            'attributes_id.exists' => 'The selected attribute is invalid.',
        ]);
        DB::beginTransaction();
        try {
            $existingRecord = UpdateHsnGstWithAttributes::where('category_id', $validated['category_id'])
                ->where('attributes_id', $validated['attributes_id'])
                ->where('attributes_value_id', $validated['attributes_value_id'])
                ->first();
            if ($existingRecord) {
                $existingRecord->update([
                    'hsn_code' => $validated['hsn_code'],
                    'gst_in_per' => $validated['gst_percentage'],
                ]);
            } else {
                UpdateHsnGstWithAttributes::create([
                    'category_id' => $validated['category_id'],
                    'attributes_id' => $validated['attributes_id'],
                    'attributes_value_id' => $validated['attributes_value_id'],
                    'hsn_code' => $validated['hsn_code'],
                    'gst_in_per' => $validated['gst_percentage'],
                ]);
            }
            /**find product list */
            $products = Product::where('category_id', $validated['category_id'])
            ->where('product_status', 1)
            ->whereHas('attributes.values', function ($query) use ($validated) {
                $query->where('attributes_value_id', $validated['attributes_value_id']);
            })->get();
            foreach ($products as $product) {
                $product->update([
                    'hsn_code' => $validated['hsn_code'],
                    'gst_in_per' => $validated['gst_percentage'],
                ]);
            }
            /**find product list */
            DB::commit();
            return response()->json([
                'message' => 'HSN Code and GST updated successfully!',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Something went wrong, please try again.',
                'error' => $e->getMessage(),
            ], 500);
        }
        
    }

    public function getHsnAndGst(Request $request){
        $categoryId = $request->input('category_id');
        $attributeIds = $request->input('attribute_ids');
        $attribute_value_ids = $request->input('attribute_value_ids');
        Log::info('Request Data:', $request->all());
        $hsnGstData = UpdateHsnGstWithAttributes::where('category_id', $categoryId)
            ->whereIn('attributes_id', $attributeIds)
            ->whereIn('attributes_value_id', $attribute_value_ids)
            ->first();

        if ($hsnGstData) {
            return response()->json([
                'hsn_code' => $hsnGstData->hsn_code,
                'gst_rate' => $hsnGstData->gst_in_per,
            ]);
        } else {
            return response()->json(['error' => 'No data found'], 404);
        }
    }

    public function showForm(Request $request){
        $attributes_value_id = $request->input('attributes_value_id');
        $attrValue = Attribute_values::find($attributes_value_id);
        $image_pathe ='';
        if($attrValue->images){
            $imagePath = asset('images/attribute-values/' . $attrValue->images);
            $image_pathe = '<img src="' . $imagePath . '" class="img-thumbnail" style="height: 120px;" alt="' . $attrValue->name . '">';
        } 
        $form ='
        <div class="modal-body">
            <form method="POST" action="'.route('attributes-value-upload-img.submit').'" accept-charset="UTF-8" enctype="multipart/form-data" id="attributesValueImageUpdate">
                '.csrf_field().'
                <input type="hidden" name="attributes_value_id" id="attributes_value_id" value="'.$attributes_value_id.'">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mb-3">
                            '.$image_pathe.'
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="image" class="form-label">Image File *</label>
                            <input type="file" id="image" name="image" class="form-control">
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
            'message' => 'Form created successfully',
            'form' => $form,
        ]);
    }

    public function showFormSubmit(Request $request){
        $request->validate([
            'attributes_value_id' => 'required|exists:attributes_value,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);
        DB::beginTransaction();    
        try {
            $attrValue = Attribute_values::find($request->attributes_value_id);
            if ($attrValue->images) {
                $oldImagePath = public_path('images/attribute-values/' . $attrValue->images);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $image = $request->file('image');
            $webpImageName = 'gd-sons-img-' . $attrValue->slug . '-' . uniqid() . '.webp';
            $destinationPath = public_path('images/attribute-values/');
            $img_original = Image::make($image->getRealPath());
            $img_original->encode('webp', 75)->save($destinationPath . '/' . $webpImageName);
            $attrValue->images = $webpImageName;
            $attrValue->save();
            DB::commit();
            Cache::forget('attribute_value_' . $attrValue->id);
            return response()->json([
                'status' => 'success',
                'message' => 'Image uploaded successfully.',
            ]);
    
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error uploading images: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong. Please try again later.',
                'error_details' => $e->getMessage() 
            ]);
        }
    }


}
