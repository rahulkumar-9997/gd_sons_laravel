<?php
namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\LandingPage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class LandingPageController extends Controller
{
    public function index(){
        $data['landing_page_list'] = LandingPage::orderBy('id', 'desc')->get();
        return view('backend.manage-landingpage.index', compact('data'));
    }

    public function create(Request $request){
        return view('backend.manage-landingpage.create');
    }

    public function store(Request $request){
        $request->validate([
            'post_title' => 'required|string|max:255',
            'post_url' => 'required|url|max:255',
            'post_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        if ($request->hasFile('post_image')) {
            $image = $request->file('post_image');
            $imageName = Str::slug($request->post_title) . '-' . time() . '.webp';
            $originalPath = public_path('landing-page/images/');
            if (!File::exists($originalPath)) {
                File::makeDirectory($originalPath, 0755, true, true);
            }
            $img_small = Image::make($image->getRealPath());
            $img_small->resize(800, 600, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('webp', 90)->save($originalPath . $imageName);
        }
        LandingPage::create([
            'title' => $request->post_title,
            'page_url' => $request->post_url,
            'image_path' => $imageName,
            'status' => 1,
        ]);
    
        return redirect()->route('manage-landing-page.index')->with('success', 'Landing page post created successfully!');
    }

    public function edit($id){
        $landingPage = LandingPage::findOrFail($id);
        return view('backend.manage-landingpage.edit', compact('landingPage'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'post_title' => 'required|string|max:255',
            'post_url' => 'required|url|max:255',
            'post_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $landingPage = LandingPage::findOrFail($id);
        if ($request->hasFile('post_image')) {
            $image = $request->file('post_image');
            $imageName = Str::slug($request->post_title) . '-' . time() . '.webp';
            $originalPath = public_path('landing-page/images/');
            if (!File::exists($originalPath)) {
                File::makeDirectory($originalPath, 0755, true, true);
            }
            $oldImageRemovePath = public_path('landing-page/images/'.$landingPage->image_path);
            $img_small = Image::make($image->getRealPath());
            $img_small->resize(800, 600, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('webp', 90)->save($originalPath . $imageName);

            $imagePath = $imageName;
            if (file_exists($oldImageRemovePath)) {
                unlink($oldImageRemovePath);
            }
            $landingPage->image_path = $imagePath;
        }
        $landingPage->title = $request->post_title;
        $landingPage->page_url = $request->post_url;
        $landingPage->status = 1;
        $landingPage->save();
        return redirect()->route('manage-landing-page.index')->with('success', 'Landing page post updated successfully!');
    }

    public function destroy($id){
        $landingPage = LandingPage::findOrFail($id);
        $oldImageRemovePath = public_path('landing-page/images/'.$landingPage->image_path);
        if (file_exists($oldImageRemovePath)) {
            unlink($oldImageRemovePath);
        }
        $landingPage->delete();
        return redirect()->route('manage-landing-page.index')->with('success', 'Landing page deleted successfully!');
    }



}
