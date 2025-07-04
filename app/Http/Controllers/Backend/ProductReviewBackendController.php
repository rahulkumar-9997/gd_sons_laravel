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
}
