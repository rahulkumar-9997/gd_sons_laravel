<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Product;
use App\Models\ProductReview;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

class ProductReviewAutoAiGenerateController extends Controller
{
    public function generateAIReview($id)
    {
        try {
            $product = Product::with('category')->findOrFail($id);            
            $client = new Client();
            $customPrompt = session('ai_review_prompt', '');            
            $systemPrompt = "You are an expert ecommerce review generator trained to write highly realistic, human-like customer reviews.
            Your job is to create reviews that feel 100% genuine, like they were written by real customers after actual usage.

            RATING LOGIC:
            - 5 Star → Extremely happy, exceeded expectations, strong recommendation
            - 4 Star → Good product, satisfied but minor issues
            - 3 Star → Average experience, mixed opinion
            - 2 Star → Not great, noticeable problems
            - 1 Star → Very bad experience, strong dissatisfaction
            
            WRITING STYLE RULES:
            - Write like real people, NOT like a brand or marketing copy
            - Use short, simple, natural sentences
            - Add casual tone (like 'nice', 'okay', 'not bad', 'didn't like', etc.)
            - Avoid over-polished or robotic language
            - Add small imperfections to make it human-like
            - Sometimes include personal experience (usage, delivery, quality, etc.)
            - Do NOT repeat the same sentence structure
            
            LANGUAGE MIX:
            - Write in TWO languages:
            1. Simple conversational Hindi (Devanagari)
            2. Natural casual English (US style)
            - You may occasionally include Hinglish (mix of Hindi + English)
            
            CUSTOMER NAME RULES (VERY IMPORTANT):
            - ALL names must be UNIQUE
            - Use ONLY real Indian names (in English script)
            - Examples: Ankit Mishra, Sneha Yadav, Rajesh Kumar, Pooja Sharma
            - NO western names like John, David, etc.
            - Do not repeat any name
            
            VARIETY & HUMAN BEHAVIOR:
            - Each review must feel like written by a DIFFERENT person
            - Mix writing styles:
            - Some very short (1 line)
            - Some medium (2-3 lines)
            - Add realistic elements:
            - delivery experience
            - packaging
            - quality
            - pricing opinion
            - expectations vs reality
            
            IMPORTANT:
            - Avoid generic phrases like 'Great product' repeatedly
            - Avoid copy-paste style repetition
            - Reviews must feel spontaneous and natural
            Return ONLY valid JSON. No explanation.";
            
            $userPrompt = $customPrompt ?: "Generate 5 realistic customer reviews for the product:
            Product Name: {$product->title}
            Category: {$product->category->title}

            REQUIREMENTS:
            Ratings Distribution:
            - Mix of ratings (1 to 5 stars)
            - At least:
            - 1 negative (1-2 star)
            - 1 average (3 star)
            - 2-3 positive (4-5 star)
            
            Language Distribution:
            - 1-2 reviews in Hindi (Devanagari)
            - 3-4 reviews in natural English
            
            CONTENT GUIDELINES:
            - Each review MUST be unique in tone and structure
            - Do NOT repeat words or sentence patterns
            - Add human-like expressions:
            - 'delivery was late'
            - 'quality is okay'
            - 'expected better'
            - 'totally worth it'
            - Some reviews can mention:
            - value for money
            - packaging
            - durability
            - actual usage experience
            HINDI EXAMPLES:
            - बहुत बढ़िया प्रोडक्ट! पूरी उम्मीद पर खरा उतरा। (5 Star)
            - अच्छा प्रोडक्ट है लेकिन कीमत थोड़ी ज्यादा है। (4 Star)
            - ठीक-ठाक प्रोडक्ट है। काम चला लिया। (3 Star)
            - निराश किया। क्वालिटी उम्मीद से कम है। (2 Star)
            - बिल्कुल बेकार। पैसे बर्बाद। (1 Star)

            STYLE VARIATION:
            - 1 review → very short (1 line)
            - 2-3 reviews → medium length
            - 1 review → slightly detailed

            REALISTIC TONE:
            - Use casual expressions like:
            - 'not bad'
            - 'okay product'
            - 'loved it'
            - 'not worth the price'
            - Hindi should be simple & conversational (not formal)

            STRICT NAME RULES:
            1. ALL 5 names MUST be UNIQUE
            2. Only Indian names (English script)
            3. No duplicates
            4. No western names

            
            Return ONLY valid JSON array in this exact format:
            [
            {
                \"title\": \"Short catchy title (2-10 words) in same language as review\",
                \"rating\": 1-5,
                \"review\": \"Authentic, Natural, human-like review\",
                \"name\": \"Unique Indian customer name in English script\",
                \"language\": \"hindi\" or \"english\"
            }]
            
            IMPORTANT: Generate a mix of ratings (some 1-3 stars and some 4-5 stars) for authentic reviews.";
            
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
                    "temperature" => 0.85,
                    "max_tokens" => 2000
                ]
            ]);
            
            $result = json_decode($response->getBody(), true);
            Log::info('AI Response', ['result' => $result]);
            $tokensUsed = $result['usage']['total_tokens'] ?? 0;            
            
            if (!isset($result['choices'][0]['message']['content'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'AI response failed. Please try again.',
                    'form' => $this->getErrorForm('AI response failed.o Please try again.', $product->id)
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
            $reviews = $this->ensureUniqueAndAuthenticReviews($reviews);
            
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
            Log::error('AI Review Generation Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'form' => $this->getErrorForm('Error: ' . $e->getMessage(), $id)
            ]);
        }
    }
    
    private function ensureUniqueAndAuthenticReviews($reviews)
    {
        $usedNames = [];
        $usedTitles = [];        
        $authenticIndianNames = [
            'Deepa Sharma', 'Amit Verma', 'Pooja Singh', 'Ravi Gupta', 'Neha Patel',
            'Rajesh Kumar', 'Priya Singh', 'Babita Mukherjee', 'Jismi Verma', 
            'Sanjay Mehta', 'Anita Kapoor', 'Vikram Singh', 'Kavita Reddy', 
            'Manoj Joshi', 'Sunita Sharma', 'Rahul Khanna', 'Geeta Malhotra',
            'Arun Nair', 'Jyoti Iyer', 'Suresh Menon', 'Meera Das', 'Ajay Thakur'
        ];        
        $englishTitles = [
            'Good product', 'Awesome!', 'Nice', 'Very good', 'Super product',
            'Excellent!', 'Great quality', 'Worth it', 'Happy with purchase',
            'Recommended', 'Best purchase', 'Loved it', 'Perfect', 'Amazing'
        ];        
        $hindiTitles = [
            'बहुत अच्छा', 'शानदार!', 'बेहतरीन', 'वाह!', 'कमाल',
            'उत्कृष्ट', 'सुपर', 'बढ़िया', 'लाजवाब', 'दमदार'
        ];        
        foreach ($reviews as $index => &$review) {
            $name = $review['name'] ?? '';
            if (empty($name) || in_array($name, $usedNames)) {
                $newName = $authenticIndianNames[array_rand($authenticIndianNames)];
                while (in_array($newName, $usedNames)) {
                    $newName = $authenticIndianNames[array_rand($authenticIndianNames)];
                }
                $review['name'] = $newName;
                $usedNames[] = $newName;
            } else {
                $usedNames[] = $name;
            }
            $isHindi = preg_match('/[ऀ-ॿ]/', $review['review'] ?? '');
            if (empty($review['title']) || in_array($review['title'], $usedTitles)) {
                if ($isHindi) {
                    $review['title'] = $hindiTitles[array_rand($hindiTitles)];
                } else {
                    $review['title'] = $englishTitles[array_rand($englishTitles)];
                }
            }
            $usedTitles[] = $review['title'] ?? '';
            if (isset($review['review'])) {
                $review['review'] = $this->makeReviewAuthentic($review['review'], $index, $isHindi);
            }
        }
        
        return $reviews;
    }
    
    private function makeReviewAuthentic($reviewText, $index, $isHindi = false)
    {
        if (strlen($reviewText) < 200 && (strpos($reviewText, '.') < 3 || strpos($reviewText, '।') < 3)) {
            return $reviewText;
        }
        if ($isHindi) {
            $shortHindiReviews = [
                "बहुत अच्छा प्रोडक्ट है। मजबूत और टिकाऊ। रोज़ाना इस्तेमाल के लिए परफेक्ट।",
                "शानदार! क्वालिटी बहुत अच्छी है। पैसे वसूल प्रोडक्ट।",
                "बेहतरीन प्रोडक्ट। बहुत खुश हूं इस खरीदारी से।",
                "वाह! कमाल का प्रोडक्ट है। सब कुछ बढ़िया काम कर रहा है।",
                "अच्छा प्रोडक्ट है। मजबूत भी है और अच्छा काम करता है।",
                "सुपर! डिजाइन और क्वालिटी दोनों बहुत अच्छी है।",
                "बढ़िया प्रोडक्ट। रसोई के लिए बहुत उपयोगी।",
                "लाजवाब! बिल्कुल सही प्रोडक्ट है।",
                "दमदार प्रोडक्ट। मजबूत स्टील की क्वालिटी बहुत अच्छी।"
            ];
            return $shortHindiReviews[$index % count($shortHindiReviews)];
        }        
        $authenticEnglishReviews = [
            "Good product, very strong material. Working well for daily use. Happy with my purchase.",
            "Awesome! The quality is superb. Really happy with this product. Worth the money.",
            "Nice product. Looks great and works perfectly. Using it daily without any issues.",
            "Very good product. The build quality is excellent. Definitely value for money.",
            "Super product! Heats up quickly and cooks food evenly. Recommended for everyone.",
            "Excellent! Exactly what I needed. Working great so far. Very satisfied.",
            "Good product also strong. Using it for my kitchen and no complaints at all.",
            "Very helpful kitchen appliance. Makes cooking easy and fast. Good buy.",
            "Nice design and good performance. Happy with my purchase. Would recommend.",
            "Superb quality! Worth every penny. Definitely recommend to others.",
            "Great product! Works perfectly and looks stylish in my kitchen.",
            "Very good quality. Strong and durable. Using it daily with no problems.",
            "Best purchase! Cooking has become so easy with this. Love it."
        ];        
        return $authenticEnglishReviews[$index % count($authenticEnglishReviews)];
    }
    
    private function checkAndFixDuplicates($reviews)
    {
        return $this->ensureUniqueAndAuthenticReviews($reviews);
    }
    
    private function createNameVariation($originalName, $usedNames)
    {
        $authenticNames = [
            'Deepa Sharma', 'Amit Verma', 'Pooja Singh', 'Ravi Gupta', 'Neha Patel',
            'Rajesh Kumar', 'Priya Singh', 'Babita Mukherjee', 'Jismi Verma', 
            'Sanjay Mehta', 'Anita Kapoor', 'Vikram Singh', 'Kavita Reddy'
        ];        
        $newName = $authenticNames[array_rand($authenticNames)];
        while (in_array($newName, $usedNames)) {
            $newName = $authenticNames[array_rand($authenticNames)];
        }
        
        return $newName;
    }
    
    private function convertToEnglishName($hindiName)
    {
        $authenticNames = [
            'Rajesh Sharma', 'Priya Singh', 'Amit Patel', 'Sunita Verma', 
            'Vikram Mehta', 'Anita Kapoor', 'Rahul Khanna', 'Deepika Reddy',
            'Sanjay Gupta', 'Neha Malhotra', 'Arun Kumar', 'Jyoti Choudhary',
            'Deepa Sharma', 'Amit Verma', 'Pooja Singh', 'Ravi Gupta', 'Neha Patel'
        ];        
        return $authenticNames[array_rand($authenticNames)];
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
                'reviews.*.rating' => 'required|integer|min:1|max:5',
                'reviews.*.review_title' => 'required|string|max:255',
                'reviews.*.review_message' => 'required|string',
                'reviews.*.review_name' => 'required|string|max:255',
                'reviews.*.review_email' => 'required|email|max:255',
            ]);   
            
            $savedCount = 0;
            $usedEmails = [];          
            
            foreach ($request->reviews as $reviewData) {
                $randomDays = rand(-90, 0);
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
            Log::error('Save AI Review Error: ' . $e->getMessage());
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
                            placeholder="Example: Generate short, authentic reviews...">' . $promptValue . '</textarea>
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
                    <p class="text-muted small">Suggestions: "Generate short, authentic reviews", "Focus on quality and durability"</p>
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