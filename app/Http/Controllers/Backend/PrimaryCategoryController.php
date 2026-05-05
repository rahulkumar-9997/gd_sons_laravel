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
        $primaryCategory = PrimaryCategory::with([
            'products:id,title',
            'products.firstSortedImage:id,product_id,image_path'
        ])
        ->orderBy('id', 'desc')
        ->paginate(30);
        //return response()->json($primaryCategory);
        return view('backend.primary-category.index', compact('primaryCategory'));
    }

    public function create(Request $request){
        return view('backend.primary-category.create');        
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'path' => 'nullable|url|max:255',
            'description' => 'nullable|string',
            'products' => 'nullable|array',
            'products.*' => 'exists:products,id',
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
            'link' => $validated['path'] ?? null,
            'primary_category_description' => $validated['description'] ?? null,
        ]);
        if (!empty($validated['products'])) {
            $primaryCategory->products()->sync($validated['products']);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Primary Category created successfully.',
            'redirect_url' => route('manage-primary-category.index')
        ]);
    }


    public function edit(Request $request, $id){
        $primary_category_row = PrimaryCategory::with('products')->findOrFail($id);
        $selectedProducts = $primary_category_row->products->pluck('id')->toArray();
        return view('backend.primary-category.edit', compact('primary_category_row', 'selectedProducts'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'path' => 'nullable|url|max:255',
            'description' => 'nullable|string',
            'products' => 'nullable|array',
            'products.*' => 'exists:products,id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();
        $primaryCategory = PrimaryCategory::findOrFail($id);

        $primaryCategory->update([
            'title' => $validated['title'],
            'link' => $validated['path'],
            'primary_category_description' => $validated['description'] ?? null,
        ]);
        $primaryCategory->products()->sync($validated['products'] ?? []);
        return response()->json([
            'status' => 'success',
            'message' => 'Primary Category updated successfully.',
            'redirect_url' => route('manage-primary-category.index')
        ]);
    }

    public function destroy($id)
    {
        try {
            $primaryCategory = PrimaryCategory::findOrFail($id);
            $primaryCategory->products()->detach();
            if ($primaryCategory->image_path) {
                $imagePath = public_path('images/primary-category/' . $primaryCategory->image_path);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            $primaryCategory->delete();
            return redirect()->route('manage-primary-category.index')->with('success', 'Primary category deleted successfully!');
        } catch (\Exception $e) {
             return redirect()->back()->with('manage-primary-category.index')->with('error', $e->getMessage());
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
