<?php
namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blog_category = BlogCategory::orderBy('id', 'desc')->get();
        return view('backend.manage-blog.blog-category.index', compact('blog_category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request){
       
        $form ='
        <div class="modal-body">
            <form method="POST" action="'.route('manage-blog-category.store').'" accept-charset="UTF-8" enctype="multipart/form-data" id="blogCategoryAdd">
                '.csrf_field().'
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="name" class="form-label">Blog Category Name *</label>
                            <input type="text" id="name" name="name" class="form-control">
                        </div>
                    </div>
                    
                    <!--<div class="mb-3 col-md-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="status" name="status">
                            <label class="form-check-label" for="status">Status</label>
                        </div>
                    </div>-->
                    
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:blog_categories,title',
        ]);

        try {
            // Create a new blog category
            $blogCategory = BlogCategory::create([
                'title' => $validated['name'],
                'slug' => Str::slug($validated['name']),
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Blog category added successfully.',
                'data' => $blogCategory,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add blog category.',
                'error' => $e->getMessage(),
            ], 500);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id){
        $blogCategoryId = $request->input('blogCategoryId'); 
        $blog_category_row = BlogCategory::findOrFail($id);
        $form ='
        <div class="modal-body">
            <form method="POST" action="'.route('manage-blog-category.update', ['manage_blog_category' => $blog_category_row->id]).'" accept-charset="UTF-8" enctype="multipart/form-data" id="blogCategoryEdit">
                '.csrf_field().'
                <input type="hidden" name="_method" value="PUT">
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="name" class="form-label">Blog Category Name *</label>
                            <input type="text" id="name" name="name" class="form-control" value="'.$blog_category_row->title.'">
                        </div>
                    </div>
                    
                    <!--<div class="mb-3 col-md-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="status" name="status">
                            <label class="form-check-label" for="status">Status</label>
                        </div>
                    </div>-->
                    
                    <div class="modal-footer pb-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
        ';
        return response()->json([
            'message' => 'Blog Category Form created successfully',
            'form' => $form,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:blog_categories,title,' . $id,
        ]);
    
        try {
            $category = BlogCategory::findOrFail($id);
            $category->update([
                'title' => $validated['name'],
            ]);
            return response()->json(['status' => 'success', 'message' => 'Blog Category updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Failed to update Blog Category.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $blogCategory = BlogCategory::findOrFail($id);
        $blogCategory->delete();
        return redirect()->back()->with('success', 'Blog category deleted successfully !.');
    }
}
