<?php
namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class BannerController extends Controller
{
    public function index(){
        $banner = Banner::orderBy('id', 'desc')->get();
        return view('backend.manage-banner.index', compact('banner'));
    }

    public function create(Request $request){
        $form ='
        <div class="modal-body">
            <form method="POST" action="'.route('manage-banner.store').'" accept-charset="UTF-8" enctype="multipart/form-data" id="addNewBanner">
                '.csrf_field().'
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="banner_title" class="form-label">Banner Title *</label>
                            <input type="text" id="banner_title" name="banner_title" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="banner_image" class="form-label">Banner Image *</label>
                            <input type="file" id="banner_image" name="banner_image" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="banner_path" class="form-label">Banner Path</label>
                            <input type="text" id="banner_path" name="banner_path" class="form-control">
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
            'message' => 'Banner Form created successfully',
            'form' => $form,
        ]);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'banner_title' => 'required|string|max:255',
            'banner_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:6144',
            'banner_path' => 'required|url|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }
        $image = $request->file('banner_image');
        $bannerTitle = Str::slug($request->input('banner_title'), '-'); 
        $timestamp = round(microtime(true) * 1000);
        $uniqueName = $bannerTitle . '-' . $timestamp . '.webp';
        $imagePath = public_path('images/banners');

        if (!file_exists($imagePath)) {
            mkdir($imagePath, 0755, true);
        }
        $compressedImage = Image::make($image->getRealPath());
        $compressedImage->resize(1200, 600, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $compressedImage->encode('webp', 80); 
        $compressedImage->save($imagePath . '/' . $uniqueName);
        $banner = Banner::create([
            'title' => $request->input('banner_title'),
            'image_path_desktop' => 'images/banners/' . $uniqueName,
            'link_desktop' => $request->input('banner_path'),
            'status' => true,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Banner created successfully!',
            'data' => $banner,
        ]);
    }

    public function edit(Request $request, $id){
        $blogCategoryId = $request->input('blogCategoryId'); 
        $banner_row = Banner::findOrFail($id);
        $form ='
        <div class="modal-body">
            <form method="POST" action="'.route('manage-banner.update', ['manage_banner' => $banner_row->id]).'" accept-charset="UTF-8" enctype="multipart/form-data" id="editBanner">
                '.csrf_field().'
                <input type="hidden" name="_method" value="PUT">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="banner_title" class="form-label">Banner Title *</label>
                            <input type="text" id="banner_title" name="banner_title" class="form-control" value="'.$banner_row->title.'">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="banner_image" class="form-label">Banner Image *</label>
                            <input type="file" id="banner_image" name="banner_image" class="form-control">
                            <img src="'.asset($banner_row->image_path_desktop).'" class="img-thumbnail" style="width: 70px; height: 70px;" alt="'.$banner_row->title.'">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="banner_path" class="form-label">Banner Path</label>
                            <input type="text" id="banner_path" name="banner_path" class="form-control" value="'.$banner_row->link_desktop.'">
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
            'message' => 'Banner Form created successfully',
            'form' => $form,
        ]);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'banner_title' => 'required|string|max:255',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:6144',
            'banner_path' => 'required|url|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $banner = Banner::findOrFail($id);
        $bannerTitle = Str::slug($request->input('banner_title'), '-');
        $timestamp = round(microtime(true) * 1000);

        if ($request->hasFile('banner_image')) {
            if ($banner->image_path_desktop && file_exists(public_path($banner->image_path_desktop))) {
                unlink(public_path($banner->image_path_desktop));
            }

            $image = $request->file('banner_image');
            $uniqueName = $bannerTitle . '-' . $timestamp . '.webp';
            $imagePath = public_path('images/banners');

            if (!file_exists($imagePath)) {
                mkdir($imagePath, 0755, true);
            }

            $compressedImage = Image::make($image->getRealPath());
            $compressedImage->resize(1200, 600, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $compressedImage->encode('webp', 80);
            $compressedImage->save($imagePath . '/' . $uniqueName);

            $banner->image_path_desktop = 'images/banners/'.$uniqueName;
        }
        $banner->update([
            'title' => $request->input('banner_title'),
            'link_desktop' => $request->input('banner_path'),
            'status' => true,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Banner updated successfully!',
            'data' => $banner,
        ]);
    }

    public function destroy($id){
        $banner = Banner::findOrFail($id);
        if ($banner->image_path_desktop && file_exists(public_path($banner->image_path_desktop))) {
            unlink(public_path($banner->image_path_desktop)); 
        }
        $banner->delete();
        return redirect()->back()->with('success', 'Banner and its image deleted successfully!');           
    }

}
