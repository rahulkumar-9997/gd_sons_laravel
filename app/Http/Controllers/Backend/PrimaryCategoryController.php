<?php
namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use App\Models\PrimaryCategory;


class PrimaryCategoryController extends Controller
{
    public function index(){
        $primaryCategory = PrimaryCategory::orderBy('id', 'desc')->get();
        return view('backend.primary-category.index', compact('primaryCategory'));
    }

    public function create(Request $request){
        $form ='
        <div class="modal-body">
            <form method="POST" action="'.route('manage-primary-category.store').'" accept-charset="UTF-8" enctype="multipart/form-data" id="addPrimaryCategory">
                '.csrf_field().'
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label for="title" class="form-label">Title *</label>
                            <input type="text" id="title" name="title" class="form-control">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label for="path" class="form-label">Path (Url) *</label>
                            <input type="text" id="path" name="path" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-2">
                            <label for="image_path" class="form-label">Images</label>
                            <input type="file" id="image_path" name="image_path" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-2">
                            <label for="description" class="form-label">Description</label>
                            <div class="snow-editor" style="height: 200px; width: 100%;"></div>
                            <textarea name="description" class="hidden-textarea" style="display:none;"></textarea>
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
            'message' => 'Banner Form created successfully',
            'form' => $form,
        ]);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'path' => 'required|url|max:255',
            'description' => 'nullable|string',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }
        $validated = $validator->validated();
        $data = [
            'title' => $validated['title'],
            'link' => $validated['path'],
            'primary_category_description' => $validated['description'] ?? null,
        ];
        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            $imageName = Str::slug($validated['title']) . '-' . time() . '.webp';
            $destinationPath = public_path('images/primary-category');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $img = Image::make($image->getRealPath());
            $img->resize(400, 400, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->encode('webp', 75)->save($destinationPath . '/' . $imageName);
            $data['image_path'] = $imageName;
        }
        $primaryCategory = PrimaryCategory::create($data);
        return response()->json([
            'status' => 'success',
            'message' => 'Primary Category created successfully.',
        ]);
    }


    public function edit(Request $request, $id){
        $primary_category_row = PrimaryCategory::findOrFail($id);
        $imagePreview = '';
        if ($primary_category_row->image_path) {
            $imageUrl = asset('images/primary-category/'.$primary_category_row->image_path);
            $imagePreview = '
            <div class="mb-2">
                <label class="form-label">Current Image</label>
                <div>
                    <img src="'.$imageUrl.'" alt="Current Image" style="max-width: 200px; max-height: 200px;" class="img-thumbnail">
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" name="remove_image" id="removeImage" value="1">
                        <label class="form-check-label" for="removeImage">Remove current image</label>
                    </div>
                </div>
            </div>';
        }
        $form ='
        <div class="modal-body">
            <form method="POST" action="'.route('manage-primary-category.update', ['manage_primary_category' => $primary_category_row->id]).'" accept-charset="UTF-8" enctype="multipart/form-data" id="editPrimaryCategory">
                '.csrf_field().'
                <input type="hidden" name="_method" value="PUT">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label for="title" class="form-label">Title *</label>
                            <input type="text" id="title" name="title" class="form-control" value="'.$primary_category_row->title.'">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label for="path" class="form-label">Path (Url) *</label>
                            <input type="text" id="path" name="path" class="form-control"  value="'.$primary_category_row->link.'">
                        </div>
                    </div>
                    <div class="col-md-12">
                        '.$imagePreview.'
                        <div class="mb-2">
                            <label for="image_path" class="form-label">Images</label>
                            <input type="file" id="image_path" name="image_path" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-2">
                            <label for="description" class="form-label">Description</label>
                            <div class="snow-editor" style="height: 200px; width: 100%;">
                            '.$primary_category_row->primary_category_description .'
                            </div>
                            <textarea name="description" class="hidden-textarea" style="display:none;">
                            '.$primary_category_row->primary_category_description .'
                            </textarea>
                        </div>
                    </div>
                    
                    <div class="modal-footer pb-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
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

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'path' => 'required|url|max:255',
            'description' => 'nullable|string',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $primaryCategory = PrimaryCategory::findOrFail($id);
        $validated = $validator->validated();
        $data = [
            'title' => $validated['title'],
            'link' => $validated['path'],
            'primary_category_description' => $validated['description'] ?? null,
        ];
        
        if ($request->hasFile('image_path')) {
            if ($primaryCategory->image_path) {
                $oldImagePath = public_path('images/primary-category/'.$primaryCategory->image_path);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $image = $request->file('image_path');
            $imageName = Str::slug($validated['title']) . '-' . time() . '.webp';
            $destinationPath = public_path('images/primary-category');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $img = Image::make($image->getRealPath());
            $img->resize(400, 400, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->encode('webp', 75)->save($destinationPath . '/' . $imageName);
            
            $data['image_path'] = $imageName;
        }
        $primaryCategory->update($data);
        return response()->json([
            'status' => 'success',
            'message' => 'Primary Category updated successfully.',
        ]);
    }

    public function destroy($id){
        try {
            $primaryCategory = PrimaryCategory::findOrFail($id);
            if ($primaryCategory->image_path) {
                $imagePath = public_path('images/primary-category/'.$primaryCategory->image_path);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            $primaryCategory->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Primary category deleted successfully!',
            ]);

            } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete primary category.',
            ], 500);
        }       
    }

    public function updateStatus(Request $request, $id){
    try {
        $primaryCategory = PrimaryCategory::findOrFail($id);
        $primaryCategory->status = $request->status;
        $primaryCategory->save();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Status updated successfully'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'fail',
            'message' => 'Error updating status: ' . $e->getMessage()
        ], 500);
    }
}

}
