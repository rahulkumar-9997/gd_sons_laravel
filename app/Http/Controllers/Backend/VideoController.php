<?php
namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Video;

class VideoController extends Controller
{
    public function index(){
        $video = Video::orderBy('id', 'desc')->get();
        return view('backend.manage-video.index', compact('video'));
    }

    public function create(Request $request){
        $form ='
        <div class="modal-body">
            <form method="POST" action="'.route('manage-video.store').'" accept-charset="UTF-8" enctype="multipart/form-data" id="addVideoShort">
                '.csrf_field().'
                <div class="row">
                    <!--<div class="col-md-6">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" id="title" name="title" class="form-control">
                        </div>
                    </div>-->
                    
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="path" class="form-label">Add Video Embed ID *</label>
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
            'message' => 'Form created successfully',
            'form' => $form,
        ]);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'path' => 'required|max:255',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }
    
        $validated = $validator->validated();
        Video::create([
            'video_url' => $validated['path'],
        ]);
    
        return response()->json([
            'status' => 'success',
            'message' => 'Video created successfully.',
        ]);
    }

    public function edit(Request $request, $id){
        $video_row = video::findOrFail($id);
        $form ='
        <div class="modal-body">
            <form method="POST" action="'.route('manage-video.update', ['manage_video' => $video_row->id]).'" accept-charset="UTF-8" enctype="multipart/form-data" id="editVideoForm">
                '.csrf_field().'
                <input type="hidden" name="_method" value="PUT">
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="path" class="form-label">Add Video Embed ID *</label>
                            <input type="text" id="path" name="path" class="form-control"  value="'.$video_row->video_url.'">
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
            'path' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $video = Video::find($id);
        if (!$video) {
            return response()->json([
                'status' => 'error',
                'message' => 'Video not found.',
            ], 404);
        }
        $validated = $validator->validated();
        $video->update([
            'video_url' => $validated['path'],
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Video updated successfully.',
        ]);
    }

    public function destroy($id){
        $primaryCategory = Video::findOrFail($id);
        $primaryCategory->delete();
        return redirect()->back()->with('success', 'Video path deleted successfully!');           
    }
}
