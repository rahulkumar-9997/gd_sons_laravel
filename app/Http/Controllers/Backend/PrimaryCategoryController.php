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
                        <div class="mb-3">
                            <label for="title" class="form-label">Title *</label>
                            <input type="text" id="title" name="title" class="form-control">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="path" class="form-label">Path (Url) *</label>
                            <input type="text" id="path" name="path" class="form-control">
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
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }
        $validated = $validator->validated();
        $primaryCategory = PrimaryCategory::create([
            'title' => $validated['title'],
            'link' => $validated['path'],
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Primary Category created successfully.',
        ]);
    }

    public function edit(Request $request, $id){
        $primary_category_row = PrimaryCategory::findOrFail($id);
        $form ='
        <div class="modal-body">
            <form method="POST" action="'.route('manage-primary-category.update', ['manage_primary_category' => $primary_category_row->id]).'" accept-charset="UTF-8" enctype="multipart/form-data" id="editPrimaryCategory">
                '.csrf_field().'
                <input type="hidden" name="_method" value="PUT">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title *</label>
                            <input type="text" id="title" name="title" class="form-control" value="'.$primary_category_row->title.'">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="path" class="form-label">Path (Url) *</label>
                            <input type="text" id="path" name="path" class="form-control"  value="'.$primary_category_row->link.'">
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
            'message' => 'Banner Form created successfully',
            'form' => $form,
        ]);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'path' => 'required|url|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $primaryCategory = PrimaryCategory::find($id);
        if (!$primaryCategory) {
            return response()->json([
                'status' => 'error',
                'message' => 'Primary Category not found.',
            ], 404);
        }
        $validated = $validator->validated();
        $primaryCategory->update([
            'title' => $validated['title'],
            'link' => $validated['path'],
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Primary Category updated successfully.',
        ]);
    }

    public function destroy($id){
        $primaryCategory = PrimaryCategory::findOrFail($id);
        $primaryCategory->delete();
        return redirect()->back()->with('success', 'Primary category deleted successfully!');           
    }

}
