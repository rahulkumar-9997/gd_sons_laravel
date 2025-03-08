<?php
namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\Blog;
use App\Models\BlogParagraph;
use App\Models\BlogParagraphProductLinks;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $blogs = Blog::with(['category', 'paragraphs.productLinks'])->get();
        return view('backend.manage-blog.blog.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $blog_category = BlogCategory::orderBy('id', 'desc')->get();
        return view('backend.manage-blog.blog.create', compact('blog_category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        //dd(request()->all());
        try {
            $validatedData = $request->validate([
                'blog_category' => 'required|exists:blog_categories,id',
                'blog_name' => 'required|string|max:255',
                'blog_img' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
                'blog_description' => 'required|string',
                'paragraphs_title' => 'nullable|array',
                'paragraphs_title.*' => 'nullable|string|max:255',
                'paragraphs_description' => 'nullable|array',
                'paragraphs_description.*' => 'nullable|string',
                'paragraphs_img' => 'nullable|array',
                'paragraphs_img.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
                'product_name' => 'nullable|array',
                'product_name.*' => 'nullable|string|max:255',
                'product_id' => 'nullable|array',
                'product_id.*' => 'nullable|exists:products,id',
            ]);
            DB::beginTransaction();

            $blogImage = $request->file('blog_img');
            $blogImagePath = null;
            if ($blogImage) {
                $blogImagePath = $this->compressAndSaveImage($blogImage, 'blogs', $request->blog_name);
            }

            $blog = Blog::create([
                'title' => $validatedData['blog_name'],
                'slug' => Str::slug($validatedData['blog_name']),
                'status' => $request->has('status') ? 1 : 0,
                'blog_category_id' => $validatedData['blog_category'],
                'bog_description' => $validatedData['blog_description'],
                'blog_image' => $blogImagePath,
            ]);
            if (!empty($request->paragraphs_title[0])) {
                foreach ($validatedData['paragraphs_title'] as $index => $paragraphTitle) {
                    $paragraphImage = $request->file('paragraphs_img')[$index] ?? null;
                    $paragraphImagePath = null;

                    if ($paragraphImage) {
                        $paragraphImagePath = $this->compressAndSaveImage($paragraphImage, 'blog_paragraphs', $paragraphTitle);
                    }

                    $blogParagraph = BlogParagraph::create([
                        'blog_id' => $blog->id,
                        'paragraphs_title' => $paragraphTitle,
                        'bog_paragraph_description' => $validatedData['paragraphs_description'][$index] ?? '',
                        'bog_paragraph_image' => $paragraphImagePath,
                    ]);

                    if (!empty($validatedData['product_id'])) {
                        foreach ($validatedData['product_id'] as $productlink_index =>  $productId) {
                            if (!empty($productId) && is_numeric($productId)) {
                                BlogParagraphProductLinks::create([
                                    'blog_paragraphs_id' => $blogParagraph->id,
                                    'links' => $validatedData['product_name'][$productlink_index],
                                    'product_id' => $productId,
                                ]);
                            }
                        }
                    }
                }
            }

            DB::commit();
            return redirect()->route('manage-blog.index')->with('success', 'Blog created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating blog: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while creating the blog.');
        }
    }

    private function compressAndSaveImage($image, $folder, $blogTitle) {
        $destinationPath = public_path("images/{$folder}/");
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }
        $cleanBlogTitle = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $blogTitle));
        $fileName = 'GD-sons-kitchen-Varanasi-' . $cleanBlogTitle . '-' . round(microtime(true) * 1000);
        $imagePath = $destinationPath . $fileName . '.' . $image->getClientOriginalExtension();
        $imageWebPPath = $destinationPath . $fileName . '.webp';
        $img = Image::make($image->getRealPath());
        $img->resize(800, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save($imagePath, 80);
        $img->encode('webp', 80)->save($imageWebPPath);
        return "images/{$folder}/" . $fileName . '.webp';
    }
    
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $blog = Blog::with(['category', 'paragraphs.productLinks'])->findOrFail($id);
        $blog_category = BlogCategory::all();
        //return response()->json($blog);
        //$blogs = Blog::with(['category', 'paragraphs.productLinks'])->get();
        return view('backend.manage-blog.blog.edit', compact('blog', 'blog_category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        //dd(request()->all());
        try {
            $validatedData = $request->validate([
                'blog_category' => 'required|exists:blog_categories,id',
                'blog_name' => 'required|string|max:255',
                'blog_img' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
                'blog_description' => 'required|string',
                'paragraphs_title' => 'nullable|array',
                'paragraphs_title.*' => 'nullable|string|max:255',
                'paragraphs_description' => 'nullable|array',
                'paragraphs_description.*' => 'nullable|string',
                //'paragraphs_img' => 'nullable|array',
                //'paragraphs_img.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
                'product_name' => 'nullable|array',
                'product_name.*' => 'nullable|string|max:255',
                'product_id' => 'nullable|array',
                'product_id.*' => 'nullable|exists:products,id',
            ]);
    
            DB::beginTransaction();
            $blog = Blog::findOrFail($id);
            $blog->title = $validatedData['blog_name'];
            $blog->blog_category_id = $validatedData['blog_category'];
            $blog->bog_description = $validatedData['blog_description'];
            if ($request->hasFile('blog_img')) {
                if ($blog->blog_image) {
                    $imagePath = public_path($blog->blog_image);
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
                /*Compress and save the new image*/
                $blogImage = $request->file('blog_img');
                $blogImagePath = $this->compressAndSaveImage($blogImage, 'blogs', $request->blog_name);
                $blog->blog_image = $blogImagePath;
            }
    
            $blog->save();
            /*Delete existing paragraphs and links, then insert new ones*/
            foreach ($blog->paragraphs as $paragraph) {
                BlogParagraphProductLinks::where('blog_paragraphs_id', $paragraph->id)->delete();
                if ($paragraph->bog_paragraph_image) {
                    $imagePath = public_path($paragraph->bog_paragraph_image);
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
                $paragraph->delete();
            }
            if (!empty($request->paragraphs_title[0])) {
                /*Remove the blog paragraph and its links*/
                //BlogParagraphProductLinks::where('blog_paragraphs_id', $paragraph->id)->delete();
                //$paragraph->delete();
                foreach ($validatedData['paragraphs_title'] as $index => $paragraphTitle) {
                    $paragraphImage = $request->file('paragraphs_img')[$index] ?? null;
                    $paragraphImagePath = null;
    
                    if ($paragraphImage) {
                        $paragraphImagePath = $this->compressAndSaveImage($paragraphImage, 'blog_paragraphs', $paragraphTitle);
                    }
    
                    $blogParagraph = BlogParagraph::create([
                        'blog_id' => $blog->id,
                        'paragraphs_title' => $paragraphTitle,
                        'bog_paragraph_description' => $validatedData['paragraphs_description'][$index] ?? '',
                        'bog_paragraph_image' => $paragraphImagePath,
                    ]);
                    if (!empty($validatedData['product_id'])) {
                        foreach ($validatedData['product_id'] as $productlink_index =>  $productId) {
                            if (!empty($productId) && is_numeric($productId)) {
                                BlogParagraphProductLinks::create([
                                    'blog_paragraphs_id' => $blogParagraph->id,
                                    'links' => $validatedData['product_name'][$productlink_index] ?? '',
                                    'product_id' => $productId,
                                ]);
                            }
                        }
                    }
                }
            }
    
            DB::commit();
            return redirect()->route('manage-blog.index')->with('success', 'Blog updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating blog: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        try {
            DB::beginTransaction();
            $blog = Blog::findOrFail($id);
            if ($blog->blog_image) {
                $imagePath = public_path($blog->blog_image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            foreach ($blog->paragraphs as $paragraph) {
                if ($paragraph->bog_paragraph_image) {
                    $imagePath = public_path($paragraph->bog_paragraph_image);
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
                BlogParagraphProductLinks::where('blog_paragraphs_id', $paragraph->id)->delete();
                $paragraph->delete();
            }
            $blog->delete();
            DB::commit();
            return redirect()->route('manage-blog.index')->with('success', 'Blog deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting blog: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while deleting the blog.');
        }
    }

    public function removeBlogParagraphs($id){
        try {
            $paragraph = BlogParagraph::findOrFail($id);
            if ($paragraph->productLinks()->count() > 0) {
                $paragraph->productLinks()->delete();
            }
    
            if ($paragraph->blog_paragraph_image) {
                $imagePath = public_path($paragraph->blog_paragraph_image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                } else {
                    Log::warning('Image not found for paragraph ID: ' . $id);
                }
            }
            $paragraph->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error removing blog paragraph: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred']);
        }
    }
}
