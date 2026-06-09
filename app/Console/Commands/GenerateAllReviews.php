<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\ProductReview;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Exception;
use Illuminate\Support\Facades\Log;

class GenerateAllReviews extends Command
{
    protected $signature = 'reviews:generate-all';

    protected $description = 'Generate AI reviews for all products';

    public function handle()
    {
        $this->info('Starting AI review generation for all products...');
        
        $successCount = 0;
        $failCount = 0;
        
        Product::chunk(10, function ($products) use (&$successCount, &$failCount) {
            foreach ($products as $product) {
                $this->info("Processing Product ID: {$product->id} - {$product->title}");
                
                try {
                    // Call the AI generation logic directly
                    $reviewsData = $this->generateAIReviewForProduct($product);
                    
                    if ($reviewsData && !empty($reviewsData['reviews'])) {
                        // Save the generated reviews
                        $savedCount = $this->saveGeneratedReviews($product, $reviewsData['reviews']);
                        $successCount++;
                        $this->info("✓ Generated and saved {$savedCount} reviews for: {$product->title}");
                    } else {
                        $failCount++;
                        $this->error("✗ Failed to generate reviews for: {$product->title}");
                    }
                    
                    // Sleep to avoid rate limiting
                    sleep(2);
                    
                } catch (Exception $e) {
                    $failCount++;
                    $this->error("✗ Error for Product {$product->id}: " . $e->getMessage());
                    Log::error("AI Review Generation Error for product {$product->id}: " . $e->getMessage());
                }
            }
        });
        
        $this->info("\n=== Generation Complete ===");
        $this->info("✓ Successful: {$successCount}");
        $this->info("✗ Failed: {$failCount}");
        $this->info("Total processed: " . ($successCount + $failCount));
    }
    
    private function generateAIReviewForProduct($product)
    {
        try {
            $client = new Client();
            $customPrompt = ''; // You can customize this for command line if needed
            $reviewCount = rand(3, 5);
            
            $systemPrompt = "You are an expert ecommerce review generator trained to write highly realistic, human-like customer reviews.
            Your job is to create reviews that feel 100% genuine, like they were written by real customers after actual usage.

            RATING LOGIC:
            - 5 Star → Very happy, loved the product, strong recommendation
            - 4 Star → Good product, satisfied with minor issues
            - 3 Star → Decent product, okay experience (no strong complaints)
            - 2 Star → Slight disappointment but still usable
            - 1 Star → Rare case, mild dissatisfaction (avoid harsh negativity)
            
            WRITING STYLE RULES:
            - Write like real customers, not like marketing content
            - Keep sentences simple, casual, and natural
            - Use friendly tone (like 'nice', 'good', 'happy with it', 'okay product')
            - Avoid robotic or over-polished language
            - Add small human imperfections (like slight grammar looseness)
            - Include real-life experiences (delivery, packaging, usage)
            
            LANGUAGE MIX:
            - Write in TWO languages:
            1. Simple conversational Hindi (Devanagari)
            2. Natural casual English (US style)
            - You may occasionally include Hinglish (mix of Hindi + English)
            
            CUSTOMER NAME RULES (VERY IMPORTANT):
            - GENERATE a fresh, random, realistic Indian full name for EACH review
            - Do NOT reuse names — every single review must have a completely different name
            - Names must sound like real Indian people from different parts of India
            - Mix names from different states and communities (e.g. Sharma, Patel, Nair, Iyer, Yadav, Kaur, Reddy, Menon, Das, Pillai)
            - Always write names in English script (Roman letters)
            - NO western names like John, David, Emily, etc.
            - Do NOT use the same first name or last name twice across the set
            
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
            
            $userPrompt = $customPrompt ?: "Generate exactly {$reviewCount} realistic customer reviews for the product:
            Product Name: {$product->title}
            Category: {$product->category->title}

            REQUIREMENTS:
            RATINGS DISTRIBUTION (STRICT - ONLY 4 AND 5 STAR REVIEWS):
            - " . ceil($reviewCount/2) . " reviews → 5 stars
            - " . floor($reviewCount/2) . " reviews → 4 stars
            - DO NOT generate any review with 1, 2, or 3 stars under any circumstance
            
            Language Distribution:
            - Exactly 1 review in Hindi (Devanagari script only) (if {$reviewCount} >= 2)
            - Remaining reviews in natural conversational English
            
            REVIEW TYPE RULES (VERY IMPORTANT):
            Review #1 — SEO DETAILED REVIEW (English, 5 stars, MINIMUM 100 words):
            - Must be written in natural, casual, human speaking language
            - Must naturally include SEO-relevant keywords
            - Length: minimum 100 words, maximum 160 words
            
            CONTENT GUIDELINES (ALL REVIEWS):
            - Each review must be completely unique
            - Avoid repeating phrases across reviews
            - Add realistic human elements: delivery experience, packaging, quality feel, daily usage
            
            STRICT NAME RULES:
            1. ALL {$reviewCount} names MUST be UNIQUE and DIFFERENT from each other
            2. Only Indian names (English script for all reviews including Hindi review)
            3. No duplicate names
            4. No western names

            Return ONLY valid JSON array in this exact format:
            [
            {
                \"title\": \"Short catchy title (2-10 words) in same language as review\",
                \"rating\": 4 or 5 only,
                \"review\": \"Authentic, Natural, human-like review\",
                \"name\": \"Unique Indian customer name in English script\",
                \"language\": \"hindi\" or \"english\"
            }]

            IMPORTANT: Generate exactly {$reviewCount} reviews total. Only 4-star and 5-star ratings. No exceptions.";
            
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
                    "max_tokens" => 3000
                ]
            ]);
            
            $result = json_decode($response->getBody(), true);
            $tokensUsed = $result['usage']['total_tokens'] ?? 0;
            
            if (!isset($result['choices'][0]['message']['content'])) {
                $this->error("No AI response content");
                return null;
            }
            
            $aiText = $result['choices'][0]['message']['content'];
            $aiText = preg_replace('/```json\s*|\s*```/', '', $aiText);
            $aiText = trim($aiText);
            $reviews = json_decode($aiText, true);
            
            if (!is_array($reviews) || empty($reviews)) {
                $this->error("Invalid JSON response from AI");
                return null;
            }
            
            // Filter only positive reviews (4-5 stars)
            $reviews = array_filter($reviews, function($review) {
                return isset($review['rating']) && $review['rating'] >= 4;
            });
            
            if (empty($reviews)) {
                $this->error("No positive reviews generated");
                return null;
            }
            
            // Ensure unique names
            $reviews = $this->ensureUniqueNames($reviews);
            
            return [
                'reviews' => array_slice(array_values($reviews), 0, $reviewCount),
                'tokens_used' => $tokensUsed
            ];
            
        } catch (Exception $e) {
            $this->error("AI API Error: " . $e->getMessage());
            Log::error("AI Review Generation Error: " . $e->getMessage());
            return null;
        }
    }
    
    private function ensureUniqueNames($reviews)
    {
        $usedNames = [];
        $authenticIndianNames = [
            'Aarti Sharma', 'Abhijit Dey', 'Abhinav Rao', 'Aditi Nair', 'Aditya Verma',
            'Ajay Thakur', 'Ajit Patil', 'Akash Yadav', 'Akhil Menon', 'Akshay Kulkarni',
            'Amit Verma', 'Ananya Mishra', 'Anil Dubey', 'Anita Kapoor', 'Anjali Bhatt',
            'Ankit Mishra', 'Arjun Singh', 'Ashok Srivastava', 'Babita Mukherjee',
            'Bharat Patel', 'Deepa Sharma', 'Deepak Chauhan', 'Divya Menon', 'Garima Srivastava',
            'Gaurav Verma', 'Geeta Malhotra', 'Harpreet Kaur', 'Jai Prakash', 'Jyoti Iyer',
            'Karan Mehta', 'Kavita Reddy', 'Lavanya Krishnan', 'Mahesh Kumar', 'Manisha Patel',
            'Meera Das', 'Neha Patel', 'Nidhi Agarwal', 'Pooja Singh', 'Priya Menon',
            'Rahul Khanna', 'Rajesh Kumar', 'Ravi Gupta', 'Rekha Joshi', 'Sanjay Mehta',
            'Sneha Reddy', 'Sunita Sharma', 'Suresh Menon', 'Swati Sharma', 'Vikram Singh'
        ];
        
        foreach ($reviews as &$review) {
            $name = trim($review['name'] ?? '');
            
            if (empty($name) || in_array($name, $usedNames)) {
                $newName = $authenticIndianNames[array_rand($authenticIndianNames)];
                $attempts = 0;
                while (in_array($newName, $usedNames) && $attempts < 20) {
                    $newName = $authenticIndianNames[array_rand($authenticIndianNames)];
                    $attempts++;
                }
                $review['name'] = $newName;
                $usedNames[] = $newName;
            } else {
                $usedNames[] = $name;
            }
        }
        
        return $reviews;
    }
    
    private function saveGeneratedReviews($product, $reviews)
    {
        $savedCount = 0;
        $usedEmails = [];
        
        foreach ($reviews as $reviewData) {
            $randomDays = rand(-200, 0);
            $reviewDate = Carbon::now()->addDays($randomDays);
            
            $baseEmail = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $reviewData['name']));
            $email = $baseEmail . rand(100, 999) . '@example.com';
            $counter = 1;
            while (in_array($email, $usedEmails) || ProductReview::where('review_email', $email)->exists()) {
                $email = $baseEmail . $counter . '@example.com';
                $counter++;
            }
            $usedEmails[] = $email;
            
            try {
                ProductReview::create([
                    'product_id' => $product->id,
                    'rating_star_value' => $reviewData['rating'],
                    'review_title' => $reviewData['title'],
                    'review_message' => $reviewData['review'],
                    'review_name' => $reviewData['name'],
                    'review_email' => $email,
                    'status' => 1,
                    'review_post_date' => $reviewDate
                ]);
                $savedCount++;
            } catch (Exception $e) {
                $this->error("Failed to save review: " . $e->getMessage());
                Log::error("Failed to save review for product {$product->id}: " . $e->getMessage());
            }
        }
        
        return $savedCount;
    }
}