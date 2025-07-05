<?php
namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\ProductReview;
use App\Models\ProductReviewFile;

class ProductReviewBackendController extends Controller
{
    public function index()
    {
        $reviews = ProductReview::with(['product' => function($query) {
            $query->withCount('reviews');
        }, 'reviewFiles'])
        ->orderBy('review_post_date', 'desc')
        ->paginate(50);

        if(request()->ajax()) {
            return view('backend.manage-review.partials.ajax-review-list', compact('reviews'))->render();
        }

        return view('backend.manage-review.index', [
            'reviews' => $reviews
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $productReviewStatus = ProductReview::findOrFail($id);        
            $productReviewStatus->status = $request->status;
            $productReviewStatus->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Status updated successfully',
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Error updating status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show(Request $request, $id)
    {
        $review = ProductReview::with(['product','reviewFiles'])
        ->findOrFail($id);
        //return response()->json($review);
        return view('backend.manage-review.show', compact('review'));
    }

    public function edit(Request $request, $id)
    {
        $review = ProductReview::with(['product','reviewFiles'])
        ->findOrFail($id);
        //return response()->json($review);
        return view('backend.manage-review.edit', compact('review'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'review_title' => 'nullable|string|max:255',
            'review_message' => 'required|string',
            'review_name' => 'required|string|max:255',
            'review_email' => 'required|email|max:255',
        ]);
        $review = ProductReview::findOrFail($id);
        try {
            DB::beginTransaction();

            $review->update([
                'review_title' => $request->review_title,
                'review_message' => $request->review_message,
                'review_name' => $request->review_name,
                'review_email' => $request->review_email,
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Review updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Review update failed: " . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update review. Please try again.');
        }
    }
    
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $review = ProductReview::findOrFail($id);
            $files = ProductReviewFile::where('product_review_id', $review->id)->get();
            $review->delete();
            foreach ($files as $file) {
                try {
                    if ($file->file_type === 'image') {
                        $filePath = public_path('images/review/' . $file->review_file);
                    } elseif ($file->file_type === 'video') {
                        $filePath = public_path('videos/review/' . $file->review_file);
                    }
                    
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                    $file->delete();
                } catch (\Exception $fileException) {
                    Log::error('Failed to delete review file: ' . $fileException->getMessage());
                    continue;
                }
            }            
            DB::commit();            
            return redirect()->back()->with('success', 'Review and all associated files deleted successfully.');            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Review deletion failed: ' . $e->getMessage());            
            return redirect()->back()->with('error', 'An error occurred while deleting the review. Please try again later.');
        }
    }

    public function destroyFile($id)
    {
        DB::beginTransaction();        
        try {
            $file = ProductReviewFile::findOrFail($id);
            if ($file->file_type === 'image') {
                $filePath = public_path('images/review/' . $file->review_file);
            } elseif ($file->file_type === 'video') {
                $filePath = public_path('videos/review/' . $file->review_file);
            }
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $file->delete();            
            DB::commit();            
            return redirect()->back()->with('success', 'File deleted successfully.');
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            Log::error("File not found: " . $e->getMessage());
            return redirect()->back()->with('error', 'File not found.');            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("File deletion failed - ID: {$id}, Error: " . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete file. Please try again.');
        }
    }
}
