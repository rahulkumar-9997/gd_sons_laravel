<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Product;
use App\Models\ProductReview;
use Carbon\Carbon;
use Exception;

class ProductReviewAutoAiGenerateController extends Controller
{
    public function generateAIReview($id)
    {
        try {
            $product = Product::with('category')->findOrFail($id);
            
            $client = new Client();
            $customPrompt = session('ai_review_prompt', '');
            
            $systemPrompt = "You are a helpful assistant that generates realistic ecommerce product reviews. 
            You ONLY generate POSITIVE reviews (4-5 stars only). 
            You write in TWO formats:
            1. Proper Hindi in Devanagari script (like: मैंने यह प्रोडक्ट खरीदा और बहुत अच्छा लगा)
            2. Proper US English (like: I purchased this product and it exceeded my expectations)
            
            IMPORTANT RULES FOR NAMES:
            - ALL 5 customer names MUST BE COMPLETELY DIFFERENT from each other
            - For Hindi reviews, use Indian names in English script (like: Rajesh Sharma, Priya Patel, Amit Kumar)
            - For English reviews, use Indian names in English script (like: Babita Mukherjee, Jismi Verma, Pooja Singh)
            - DO NOT use Western names like John, Sarah, Michael, etc.
            - Names must be in English script only
            - Be creative with names - use variety of Indian first names and surnames
            
            Never generate negative or average reviews (only 4 or 5 stars).
            Never generate Hinglish or mixed language.";
            
            $userPrompt = $customPrompt ?: "Generate 5 positive customer reviews for: {$product->title}, {$product->category->title}

            REQUIREMENTS:
            - Generate ONLY 4 or 5 star ratings (no 1,2,3 stars)
            - Write 1 review in proper Hindi (Devanagari script only, no English words)
            - Write 4 reviews in proper US English (formal, natural American English)
            - All reviews must be POSITIVE and ENTHUSIASTIC
            - Include specific product details (quality, features, performance, value for money)
            
            CRITICAL - NAME REQUIREMENTS (MUST FOLLOW EXACTLY):
            1. ALL 5 customer names MUST BE UNIQUE - no duplicates allowed
            2. Use ONLY Indian names (like: Rajesh Kumar, Priya Singh, Amit Patel, Babita Mukherjee, Jismi Verma)
            3. DO NOT use Western names (like John, Sarah, Michael, Jennifer, David)
            4. Names must be in English script only
            5. Each name should be different - check carefully that no two names are the same
            
            Return ONLY valid JSON array in this exact format:
            [
            {
                \"title\": \"Review title in same language as review\",
                \"rating\": 5,
                \"review\": \"Detailed positive review in proper Hindi or proper English\",
                \"name\": \"Unique Indian customer name in English script\",
                \"language\": \"hindi\" or \"english\"
            }]";
            
            $response = $client->post('https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    "model" => "gpt-4o-mini",
                    "messages" => [
                        ["role" => "system", "content" => $systemPrompt],
                        ["role" => "user", "content" => $userPrompt]
                    ],
                    "temperature" => 0.8,
                    "max_tokens" => 2500
                ]
            ]);
            
            $result = json_decode($response->getBody(), true);
            $tokensUsed = $result['usage']['total_tokens'] ?? 0;            
            
            if (!isset($result['choices'][0]['message']['content'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'AI response failed. Please try again.',
                    'form' => $this->getErrorForm('AI response failed. Please try again.', $product->id)
                ]);
            }            
            
            $aiText = $result['choices'][0]['message']['content'];
            $aiText = preg_replace('/```json\s*|\s*```/', '', $aiText);
            $aiText = trim($aiText);            
            $reviews = json_decode($aiText, true);            
            
            if (!is_array($reviews) || empty($reviews)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid response format from AI',
                    'form' => $this->getErrorForm('AI returned invalid data format. Please try again with a different prompt.', $product->id)
                ]);
            }
            $reviews = array_filter($reviews, function($review) {
                return isset($review['rating']) && $review['rating'] >= 2;
            });
            
            if (empty($reviews)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No positive reviews generated',
                    'form' => $this->getErrorForm('AI generated only negative reviews. Please try again.', $product->id)
                ]);
            }
            $reviews = array_slice(array_values($reviews), 0, 5);
            $reviews = $this->checkAndFixDuplicates($reviews);
            foreach ($reviews as &$review) {
                $isHindiReview = preg_match('/[ऀ-ॿ]/', $review['review'] ?? '');
                $hasHindiScriptName = preg_match('/[ऀ-ॿ]/', $review['name'] ?? '');
                if ($isHindiReview && $hasHindiScriptName) {
                    $review['name'] = $this->convertToEnglishName($review['name']);
                }
            }
            
            $form = $this->buildReviewsForm($product, $reviews, $tokensUsed);            
            
            return response()->json([
                'success' => true,
                'form' => $form
            ]);
            
        } catch (Exception $e) {
            \Log::error('AI Review Generation Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'form' => $this->getErrorForm('Error: ' . $e->getMessage(), $id)
            ]);
        }
    }
    
    
    private function checkAndFixDuplicates($reviews)
    {
        $usedNames = [];
        $fixedReviews = [];
        
        foreach ($reviews as $index => $review) {
            $originalName = $review['name'] ?? 'Customer_' . ($index + 1);
            if (in_array($originalName, $usedNames)) {
                $newName = $this->createNameVariation($originalName, $usedNames);
                $review['name'] = $newName;
                $usedNames[] = $newName;
            } else {
                $usedNames[] = $originalName;
            }
            
            $fixedReviews[] = $review;
        }
        
        return $fixedReviews;
    }
    
    
    private function createNameVariation($originalName, $usedNames)
    {
        $parts = explode(' ', $originalName);
        $firstName = $parts[0];
        $lastName = isset($parts[1]) ? $parts[1] : '';
        
        $variations = [];
        if (!empty($lastName)) {
            $variation = $firstName . ' ' . chr(rand(65, 90)) . '. ' . $lastName;
            $variations[] = $variation;
        }
        $variations[] = $originalName . ' ' . rand(1, 99);
        $indianSurnames = ['Sharma', 'Patel', 'Singh', 'Kumar', 'Verma', 'Gupta', 'Reddy', 'Nair', 'Iyer', 'Joshi'];
        $newSurname = $indianSurnames[array_rand($indianSurnames)];
        $variations[] = $firstName . ' ' . $newSurname;
        $indianFirstNames = ['Rajesh', 'Priya', 'Amit', 'Sunita', 'Vikram', 'Anita', 'Rahul', 'Deepika', 'Suresh', 'Kavita'];
        $newFirstName = $indianFirstNames[array_rand($indianFirstNames)];
        $variations[] = $newFirstName . ' ' . $lastName;
        foreach ($variations as $variation) {
            if (!in_array($variation, $usedNames)) {
                return $variation;
            }
        }
        return 'Customer_' . rand(1000, 9999);
    }
    
    
    private function convertToEnglishName($hindiName)
    {
        $nameMappings = [
            'राजेश' => 'Rajesh',
            'कुमार' => 'Kumar',
            'प्रिया' => 'Priya',
            'सिंह' => 'Singh',
            'अमित' => 'Amit',
            'पटेल' => 'Patel',
            'सुनीता' => 'Sunita',
            'शर्मा' => 'Sharma',
            'विक्रम' => 'Vikram',
            'मेहता' => 'Mehta',
            'अनीता' => 'Anita',
            'देसाई' => 'Desai',
            'राहुल' => 'Rahul',
            'कपूर' => 'Kapoor',
            'दीपिका' => 'Deepika',
            'रेड्डी' => 'Reddy'
        ];
        foreach ($nameMappings as $hindi => $english) {
            if (strpos($hindiName, $hindi) !== false) {
                return $english . ' ' . ($nameMappings[array_rand($nameMappings)] ?? 'Kumar');
            }
        }
        $indianNames = ['Rajesh Kumar', 'Priya Singh', 'Amit Patel', 'Sunita Sharma', 'Vikram Mehta'];
        return $indianNames[array_rand($indianNames)];
    }
    
    public function regenerateAIReview(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id'
            ]);            
            $product = Product::findOrFail($request->product_id);            
            if ($request->has('custom_prompt') && !empty($request->custom_prompt)) {
                session(['ai_review_prompt' => $request->custom_prompt]);
            } else {
                session(['ai_review_prompt' => '']);
            }            
            return $this->generateAIReview($product->id);            
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'form' => $this->getErrorForm('Error: ' . $e->getMessage(), $request->product_id)
            ]);
        }
    }
    
    public function saveAIReview(Request $request)
    {
        try {
            $request->validate([
                'reviews' => 'required|array|min:1|max:5',
                'reviews.*.product_id' => 'required|exists:products,id',
                'reviews.*.rating' => 'required|integer|min:4|max:5',
                'reviews.*.review_title' => 'required|string|max:255',
                'reviews.*.review_message' => 'required|string',
                'reviews.*.review_name' => 'required|string|max:255',
                'reviews.*.review_email' => 'required|email|max:255',
            ]);   
            
            $savedCount = 0;
            $usedEmails = [];            
            
            foreach ($request->reviews as $reviewData) {
                $randomDays = rand(-30, 0);
                $reviewDate = Carbon::now()->addDays($randomDays);                
                $baseEmail = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $reviewData['review_name']));
                $email = $baseEmail . rand(100, 999) . '@example.com';
                $counter = 1;
                while (in_array($email, $usedEmails) || ProductReview::where('review_email', $email)->exists()) {
                    $email = $baseEmail . $counter . '@example.com';
                    $counter++;
                }
                $usedEmails[] = $email;

                ProductReview::create([
                    'product_id' => $reviewData['product_id'],
                    'rating_star_value' => $reviewData['rating'],
                    'review_title' => $reviewData['review_title'],
                    'review_message' => $reviewData['review_message'],
                    'review_name' => $reviewData['review_name'],
                    'review_email' => $email,
                    'status' => 1,
                    'review_post_date' => $reviewDate
                ]);
                $savedCount++;
            }
    
            return response()->json([
                'status' => 'success',
                'message' => $savedCount . ' Positive Review(s) Saved Successfully'
            ]);
            
        } catch (Exception $e) {
            \Log::error('Save AI Review Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error saving reviews: ' . $e->getMessage()
            ], 500);
        }
    }
    
    private function buildReviewsForm($product, $reviews, $tokensUsed)
    {
        $csrfField = csrf_field();
        $reviewsHtml = '';
        
        foreach ($reviews as $index => $data) {
            $isHindi = preg_match('/[ऀ-ॿ]/', $data['review'] ?? '');
            $languageBadge = $isHindi ? '<span class="badge bg-info ms-2">हिन्दी</span>' : '<span class="badge bg-primary ms-2">English</span>';
            
            $cleanName = preg_replace('/[^a-zA-Z0-9]/', '', $data['name'] ?? 'customer');
            $email = strtolower($cleanName) . rand(100, 999) . '@example.com';
            $rating = $data['rating'] ?? 5;            
            $ratingSelected = [
                5 => $rating == 5 ? 'selected' : '',
                4 => $rating == 4 ? 'selected' : '',
                3 => $rating == 3 ? 'selected' : '',
                2 => $rating == 2 ? 'selected' : '',
            ];
            
            $title = htmlspecialchars($data['title'] ?? '', ENT_QUOTES, 'UTF-8');
            $review = htmlspecialchars($data['review'] ?? '', ENT_QUOTES, 'UTF-8');
            $name = htmlspecialchars($data['name'] ?? '', ENT_QUOTES, 'UTF-8');
            
            $reviewsHtml .= '
            <div class="review-card mb-4 p-3 border rounded" style="border-left: 4px solid ' . ($isHindi ? '#17a2b8' : '#007bff') . ' !important;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">
                        <i class="ti ti-star text-warning"></i> 
                        Review #' . ($index + 1) . ' - ' . $rating . ' Star
                        ' . $languageBadge . '
                    </h5>
                    <span class="text-success"><i class="ti ti-thumb-up"></i> Positive Review</span>
                </div>
                
                <input type="hidden" name="reviews[' . $index . '][product_id]" value="' . $product->id . '">
                
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label fw-bold">Review Title</label>
                        <input type="text" class="form-control" name="reviews[' . $index . '][review_title]" value="' . $title . '" placeholder="Enter review title" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Rating</label>
                        <select class="form-control" name="reviews[' . $index . '][rating]" required>
                            <option value="5" ' . $ratingSelected[5] . '>5 Star </option>
                            <option value="4" ' . $ratingSelected[4] . '>4 Star </option>
                            <option value="3" ' . $ratingSelected[3] . '>3 Star </option>
                            <option value="2" ' . $ratingSelected[2] . '>2 Star </option>
                        </select>
                    </div>
                </div>
    
                <div class="mb-3">
                    <label class="form-label fw-bold">Review</label>
                    <textarea class="form-control" name="reviews[' . $index . '][review_message]" rows="4" placeholder="Write detailed review..." required>' . $review . '</textarea>
                </div>
    
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Customer Name</label>
                        <input type="text" class="form-control" name="reviews[' . $index . '][review_name]" value="' . $name . '" placeholder="Enter customer name" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <input type="email" class="form-control" name="reviews[' . $index . '][review_email]" value="' . $email . '" placeholder="customer@email.com" required>
                    </div>
                </div>
            </div>';
        }
    
        $promptValue = session('ai_review_prompt', '');
        $promptValue = htmlspecialchars($promptValue, ENT_QUOTES, 'UTF-8');
        
        return '
        <div class="modal-body">
            <div class="alert alert-success d-flex justify-content-between align-items-center mb-3">
                <div>
                    <strong><i class="ti ti-robot"></i> AI Generation Stats:</strong> 
                    <span class="badge bg-info">' . $tokensUsed . ' Tokens</span>
                    <span class="badge bg-success">' . count($reviews) . ' Positive Reviews</span>
                </div>
                <div>
                    <span class="badge bg-info">हिन्दी</span>
                    <span class="badge bg-primary">English</span>
                </div>
            </div>
            
            <div class="card mb-4 border-success">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <label class="form-label fw-bold">Custom Prompt (Optional)</label>
                            <textarea class="form-control" id="customPrompt" rows="2" 
                            placeholder="Example: Generate reviews focusing on product durability and customer service...">' . $promptValue . '</textarea>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="button" class="btn btn-warning w-100 regenerate-with-prompt" data-product-id="' . $product->id . '">
                                <i class="ti ti-refresh"></i> Regenerate
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <form method="POST" action="' . route('save.ai.review') . '" id="saveReviewData">
                ' . $csrfField . '
                <div class="reviews-container">
                    ' . $reviewsHtml . '
                </div>
                <div class="alert alert-danger d-none" id="formError"></div>
                
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="ti ti-x"></i> Close
                    </button>
                    <div>
                        <button type="button" class="btn btn-outline-primary regenerate-all-reviews me-2" data-product-id="' . $product->id . '">
                            <i class="ti ti-refresh"></i> Generate New Set
                        </button>
                        <button type="submit" class="btn btn-success save-all-reviews">
                            <i class="ti ti-device-floppy"></i> Save All Reviews
                        </button>
                    </div>
                </div>
            </form>
        </div>';
    }
    
    private function getErrorForm($errorMessage, $productId)
    {
        $errorMessage = htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8');        
        return '
        <div class="modal-body">
            <div class="alert alert-danger">
                <i class="ti ti-alert-circle"></i>
                <strong>Error:</strong> ' . $errorMessage . '
            </div>
            
            <div class="card border-warning mb-3">
                <div class="card-body">
                    <h6><i class="ti ti-message"></i> Try Again with Custom Prompt</h6>
                    <p class="text-muted small">Suggestions: "Generate 5 star reviews only", "Focus on product quality", "Write in pure Hindi"</p>
                    <div class="mb-3">
                        <textarea class="form-control" id="customPrompt" rows="3" 
                         placeholder="Enter custom instructions..."></textarea>
                    </div>
                    <button type="button" class="btn btn-warning regenerate-with-prompt w-100" data-product-id="' . $productId . '">
                        <i class="ti ti-refresh"></i> Retry with Custom Prompt
                    </button>
                </div>
            </div>
            
            <div class="text-center">
                <button type="button" class="btn btn-primary regenerate-all-reviews me-2" data-product-id="' . $productId . '">
                    <i class="ti ti-refresh"></i> Simple Retry
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="ti ti-x"></i> Close
                </button>
            </div>
        </div>';
    }
}