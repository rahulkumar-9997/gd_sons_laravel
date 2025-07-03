<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\ProductReviewFile;

class ProductReviewController extends Controller
{
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            Log::debug('Raw request data:', $request->all());
            $validator = Validator::make($request->all(), [
                'product_id' => 'required|exists:products,id',
                'rating' => 'required|integer|between:1,5',
                'review_title' => 'nullable|string|max:255',
                'review_message' => 'required|string',
                'review_name' => 'required|string|max:255',
                'review_email' => 'required|email|max:255',
                'review_pic_or_video.*' => 'nullable|file|mimes:jpeg,jpg,png,gif,webp,mp4,mov|max:5120',
            ], [
                'review_pic_or_video.*.max' => 'Each file must not be larger than 5MB.',
                'review_pic_or_video.*.mimes' => 'Only JPEG, JPG, PNG, GIF, WEBP, MP4, and MOV files are allowed.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $product = Product::findOrFail($request->product_id);
            $review = ProductReview::create([
                'product_id' => $product->id,
                'customer_id' => auth('customer')->id() ?? null,
                'rating_star_value' => $request->rating,
                'review_title' => $request->review_title,
                'review_message' => $request->review_message,
                'review_name' => $request->review_name,
                'review_email' => $request->review_email,
                'status' => '0',
                'review_post_date' => now()->setTimezone('Asia/Kolkata'),
            ]);

            if ($request->hasFile('review_pic_or_video')) {
                $files = $request->file('review_pic_or_video');
                $uploadCount = 0;                
                foreach ($files as $file) {
                    if ($uploadCount >= 5) break;                    
                    try {
                        $fileType = $file->getMimeType();
                        $fileTypeGroup = explode('/', $fileType)[0];
                        $fileName = 'review-' . Str::slug($product->name) . '-' . uniqid();
                        if ($fileTypeGroup === 'image') {
                            $fileName .= '.webp';
                            $destinationPath = public_path('images/review/');
                            if (!file_exists($destinationPath)) {
                                mkdir($destinationPath, 0755, true);
                            }
                            $image = Image::make($file);
                            $image->encode('webp', 75);
                            $image->save($destinationPath . $fileName);
                            ProductReviewFile::create([
                                'product_id' => $product->id,
                                'product_review_id' => $review->id,
                                'review_file' => $fileName,
                                'file_type' =>'image'
                            ]);

                            $uploadCount++;
                        } elseif ($fileTypeGroup === 'video') {
                            $extension = $file->getClientOriginalExtension();
                            $fileName .= '.' . $extension;
                            $destinationPath = public_path('videos/review/');
                            if (!file_exists($destinationPath)) {
                                mkdir($destinationPath, 0755, true);
                            }
                            $file->move($destinationPath, $fileName);
                            ProductReviewFile::create([
                                'product_id' => $product->id,
                                'product_review_id' => $review->id,
                                'review_file' => $fileName,
                                'file_type' =>'video'
                            ]);
                            $uploadCount++;
                        }
                    } catch (\Exception $fileException) {
                        Log::error('File upload failed: ' . $fileException->getMessage());
                        continue;
                    }
                }
            }
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Thank you for your review! It will be visible after approval.',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Review submission failed: ' . $e->getMessage());            
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while submitting your review. Please try again later.',
            ], 500);
        }
    }
}
