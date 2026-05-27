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
            $reviewCount = rand(3, 5); // Randomly decide how many reviews to generate            
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
            - 2 reviews → 5 stars
            - 2 reviews → 4 stars
            - DO NOT generate any review with 1, 2, or 3 stars under any circumstance
            
            Language Distribution:
            - Exactly 1 review in Hindi (Devanagari script only)
            - Exactly 3 reviews in natural conversational English
            
            REVIEW TYPE RULES (VERY IMPORTANT):
            Review #1 — SEO DETAILED REVIEW (English, 5 stars, MINIMUM 100 words):
            - Must be written in natural, casual, human speaking language — like texting a friend about a good buy
            - Must naturally include SEO-relevant keywords related to the product name, category, features, usage, and benefits
            - Keywords must flow organically within sentences — do NOT stuff keywords unnaturally
            - Cover topics like: product quality, build material, performance, ease of use, daily usage experience, value for money, delivery, packaging
            - Length: minimum 100 words, maximum 160 words
            - OPENING RULES (VERY IMPORTANT):
              * NEVER start with 'I recently purchased', 'I recently bought', 'I purchased', 'I bought', or any variation of these
              * NEVER start with 'I' at all
              * START with one of these styles instead:
                → The product name directly (e.g. 'The Cello Blazing cooktop is...')
                → A casual observation (e.g. 'Honestly, this thing surprised me...')
                → A situation or context (e.g. 'Been using this for 3 weeks now...')
                → A direct opinion (e.g. 'Solid buy for the price...')
                → A comparison or contrast (e.g. 'Switched from gas to this and...')
              * Keep the opening line punchy, casual, and fresh

            Review #2 — MEDIUM ENGLISH REVIEW (English, 5 or 4 stars):
            - 2 to 3 sentences
            - Casual and natural tone
            - Mention delivery or packaging or pricing

            Review #3 — HINDI REVIEW (Hindi Devanagari, 5 or 4 stars):
            - Written entirely in Hindi Devanagari script
            - Simple, conversational, emotional tone like an Indian housewife or family buyer
            - 2 to 4 sentences
            - PRODUCT NAME RULE: The product name must also be transliterated and written in Devanagari script within the review (e.g. 'सेलो ब्लेज़िंग', 'फिलिप्स मिक्सर'). Do NOT write the product name in English/Roman letters inside the Hindi review.
            - Examples of tone:
            - सेलो ब्लेज़िंग कुकटॉप बहुत अच्छा है, पसंद आया।
            - यह प्रोडक्ट पैसे के हिसाब से एकदम सही है।
            - घर के लिए बिल्कुल सही है, सबको पसंद आया।

            Review #4 — SHORT ENGLISH REVIEW (English, 4 or 5 stars):
            - Very short, 1 to 2 sentences only
            - Punchy and genuine
            - Use casual expressions like 'loved it', 'happy with purchase', 'value for money', 'nice product'

            CONTENT GUIDELINES (ALL REVIEWS):
            - Each review must be completely unique
            - Avoid repeating phrases across reviews
            - Add realistic human elements: delivery experience, packaging, quality feel, daily usage
            - Avoid robotic or overly promotional language
            - Hindi should be simple & conversational (not formal Hindi)

            STRICT NAME RULES:
            1. ALL {$reviewCount} names MUST be UNIQUE and DIFFERENT from each other
            2. Only Indian names (English script for all reviews including Hindi review)
            3. No duplicate names
            4. No western names (no John, David, etc.)

            Return ONLY valid JSON array in this exact format:
            [
            {
                \"title\": \"Short catchy title (2-10 words) in same language as review\",
                \"rating\": 4 or 5 only,
                \"review\": \"Authentic, Natural, human-like review\",
                \"name\": \"Unique Indian customer name in English script\",
                \"language\": \"hindi\" or \"english\"
            }]

            IMPORTANT: Generate exactly {$reviewCount} reviews total. Only 4-star and 5-star ratings. No exceptions. Every reviewer name must be completely different — no two names can be same or similar.";
            
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
            
            $reviews = array_slice(array_values($reviews), 0, $reviewCount);
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
            // A
            'Aarti Sharma', 'Abhijit Dey', 'Abhilasha Tiwari', 'Abhinav Rao', 'Abhishek Joshi',
            'Aditi Nair', 'Aditya Verma', 'Ajay Thakur', 'Ajit Patil', 'Akash Yadav',
            'Akhil Menon', 'Akshay Kulkarni', 'Akshita Gupta', 'Amita Bose', 'Amit Verma',
            'Amitabh Chatterjee', 'Amruta Desai', 'Amulya Reddy', 'Ananya Mishra', 'Anil Dubey',
            'Anita Kapoor', 'Anjali Bhatt', 'Ankit Mishra', 'Ankita Pandey', 'Anoop Nambiar',
            'Anuradha Sinha', 'Anurag Tiwari', 'Anushka Jain', 'Aparna Pillai', 'Archana Saxena',
            'Arjun Singh', 'Arpit Agarwal', 'Aruna Devi', 'Arun Kumar', 'Arun Nair',
            'Arvind Pandey', 'Asha Rani', 'Ashish Tripathi', 'Ashok Srivastava', 'Ashwini Patil',
            'Avni Shah', 'Ayesha Khan', 'Ayush Sharma',
            // B
            'Babita Mukherjee', 'Balaji Venkatesh', 'Bharat Patel', 'Bharati Kulkarni', 'Bhavana Reddy',
            'Bhavesh Joshi', 'Bhawna Gupta', 'Bindu Nair', 'Bipasha Sen', 'Brijesh Yadav',
            // C
            'Chandan Kumar', 'Chandni Mehta', 'Charu Srivastava', 'Chetan Sharma', 'Chhavi Gupta',
            // D
            'Deepa Sharma', 'Deepak Chauhan', 'Deepali Joshi', 'Deepika Reddy', 'Deepti Mishra',
            'Devika Iyer', 'Dhanashree Patil', 'Dhruv Agarwal', 'Dimple Singh', 'Divya Menon',
            'Divyanka Tripathi', 'Dolly Sharma',
            // G
            'Garima Srivastava', 'Gaurav Verma', 'Gayatri Pillai', 'Geeta Malhotra', 'Geetanjali Devi',
            'Girish Nambiar', 'Gita Rani', 'Govind Sharma', 'Gulab Singh',
            // H
            'Harish Joshi', 'Harpreet Kaur', 'Harsh Vardhan', 'Harsha Reddy', 'Heena Patel',
            'Hemant Soni', 'Hema Sharma', 'Himani Gupta', 'Hitesh Agarwal',
            // I
            'Indira Nair', 'Indrajit Roy', 'Ishaan Khanna', 'Isha Malhotra', 'Ishita Sinha',
            // J
            'Jagdish Prasad', 'Jai Prakash', 'Janhvi Kapoor', 'Janki Devi', 'Jayant Kulkarni',
            'Jayashree Iyer', 'Jismi Verma', 'Jitendra Yadav', 'Juhi Chawla', 'Jyoti Choudhary',
            'Jyoti Iyer', 'Jyotsna Patel',
            // K
            'Kajal Agarwal', 'Kalyani Menon', 'Kamlesh Sharma', 'Kamna Singh', 'Kanchan Devi',
            'Karan Mehta', 'Karthik Rajan', 'Kavita Reddy', 'Kavitha Nair', 'Kirti Sharma',
            'Komal Pandey', 'Kritika Jain', 'Kuldeep Singh', 'Kumar Saurabh',
            // L
            'Lakshmi Devi', 'Lakshmi Priya', 'Lalitha Rao', 'Lavanya Krishnan', 'Leela Nair',
            'Lekha Pillai', 'Lovepreet Kaur',
            // M
            'Madhavi Rao', 'Madhu Bala', 'Madhuri Dixit', 'Mahesh Babu', 'Mahesh Kumar',
            'Mamta Sharma', 'Manasi Joshi', 'Mandeep Kaur', 'Manik Rao', 'Manisha Patel',
            'Manjeet Kaur', 'Manjula Devi', 'Manoj Joshi', 'Manorama Singh', 'Meena Kumari',
            'Meenakshi Rao', 'Meera Das', 'Megha Sharma', 'Meghna Kulkarni', 'Mohan Lal',
            'Mohini Singh', 'Mridula Srivastava', 'Mukesh Kumar', 'Muskaan Verma',
            // N
            'Nalini Krishnan', 'Namrata Joshi', 'Nandini Pillai', 'Nandita Sen', 'Naresh Gupta',
            'Naveen Reddy', 'Neelam Yadav', 'Neeraj Sharma', 'Neeta Desai', 'Neha Patel',
            'Neha Malhotra', 'Nidhi Agarwal', 'Nidhi Tiwari', 'Nikhil Mehta', 'Nikita Jain',
            'Nilima Sinha', 'Nilufar Khan', 'Nisha Tripathi', 'Nishant Verma', 'Nitu Singh',
            'Nivedita Menon',
            // O
            'Om Prakash', 'Omkar Patil',
            // P
            'Padmini Rao', 'Pallavi Joshi', 'Pankaj Tiwari', 'Parag Desai', 'Paramjit Kaur',
            'Parvati Devi', 'Pawan Kumar', 'Pooja Singh', 'Poonam Yadav', 'Poornima Nair',
            'Pradip Ghosh', 'Prajakta Kulkarni', 'Prakash Rajan', 'Pranav Sharma', 'Pranjali Patil',
            'Prasad Iyer', 'Pratibha Singh', 'Pratiksha Joshi', 'Preeti Agarwal', 'Preeti Soni',
            'Prerna Mishra', 'Priya Menon', 'Priya Singh', 'Priyanka Bhatt', 'Priyanka Chopra',
            'Puja Biswas', 'Punit Sharma', 'Pushpa Devi', 'Pushpalatha Reddy',
            // R
            'Rachna Gupta', 'Radhika Pillai', 'Rahul Khanna', 'Raj Kumar', 'Rajani Devi',
            'Rajesh Kumar', 'Rajesh Sharma', 'Rajeshwari Rao', 'Rajni Patel', 'Rajnish Verma',
            'Raju Yadav', 'Rakesh Gupta', 'Rakhi Sharma', 'Ram Prasad', 'Rama Devi',
            'Ramesh Babu', 'Rani Sharma', 'Ranjit Singh', 'Rashmi Desai', 'Ravi Gupta',
            'Ravi Nair', 'Rekha Joshi', 'Rekha Sharma', 'Ritesh Agarwal', 'Ritu Chauhan',
            'Rohit Srivastava', 'Roshan Kumar', 'Rupa Das', 'Rupali Mehta',
            // S
            'Sachin Yadav', 'Sakshi Sharma', 'Saloni Gupta', 'Sandhya Iyer', 'Sandip Patil',
            'Sangeeta Rao', 'Sanjay Mehta', 'Sanjukta Dey', 'Santosh Kumar', 'Sapna Tiwari',
            'Saraswati Devi', 'Sarla Singh', 'Satish Reddy', 'Savita Mishra', 'Seema Agarwal',
            'Seema Joshi', 'Shalini Pillai', 'Shalini Sharma', 'Shanta Bai', 'Sheela Rani',
            'Shekhar Mehta', 'Shilpa Kulkarni', 'Shilpa Shetty', 'Shivani Gupta', 'Shobha Nair',
            'Shradha Kapoor', 'Shreya Ghoshal', 'Shubham Verma', 'Shweta Singh', 'Simran Kaur',
            'Sneha Reddy', 'Sneha Yadav', 'Sonam Patel', 'Sonal Mehta', 'Sonia Gandhi',
            'Sonia Sharma', 'Sourav Banerjee', 'Sreedevi Menon', 'Sridhar Rao', 'Sudhir Joshi',
            'Suhas Kulkarni', 'Sujata Verma', 'Sujatha Nair', 'Sunanda Singh', 'Sunita Sharma',
            'Sunita Devi', 'Supriya Pillai', 'Suraj Kumar', 'Surekha Patil', 'Suresh Menon',
            'Surya Prakash', 'Sushma Swaraj', 'Swati Sharma',
            // T
            'Tabassum Khan', 'Tanuja Desai', 'Tanushree Dutta', 'Tara Singh', 'Tarun Sharma',
            'Tejaswi Rao',
            // U
            'Uma Shankar', 'Umarani Pillai', 'Urmila Sharma', 'Usha Devi', 'Usha Rani',
            // V
            'Vandana Sharma', 'Varsha Gupta', 'Vasant Rao', 'Veena Iyer', 'Venkat Raman',
            'Vibha Singh', 'Vidya Balan', 'Vijaya Lakshmi', 'Vijayalakshmi Menon', 'Vijaylaxmi Sharma',
            'Vikram Malhotra', 'Vikram Singh', 'Vinay Kumar', 'Vinayak Joshi', 'Vineeta Singh',
            'Vipul Shah', 'Vishal Agarwal', 'Vishnu Prasad', 'Vrinda Nair',
            // Y
            'Yamini Rao', 'Yashoda Devi', 'Yashpal Singh', 'Yogesh Sharma', 'Yogita Patil',
            // Additional names for variety across regions
            'Aabha Jain', 'Aakash Dubey', 'Aanchal Srivastava', 'Aarushi Gupta', 'Abhay Desai',
            'Abha Singh', 'Abha Verma', 'Achyut Rao', 'Ajanta Biswas', 'Ajita Pillai',
            'Alka Sharma', 'Alok Pandey', 'Ambar Singh', 'Ambika Devi', 'Amisha Patel',
            'Amitesh Yadav', 'Amol Kulkarni', 'Amrish Puri', 'Amrita Singh', 'Anand Kumar',
            'Anandhi Rajan', 'Anchal Mehta', 'Andaleeb Khan', 'Anil Sharma', 'Anila Nair',
            'Anirudh Mishra', 'Anisa Khan', 'Anjana Devi', 'Anjalika Roy', 'Annapurna Devi',
            'Anshul Verma', 'Anupama Sharma', 'Anupam Mishra', 'Anusha Iyer', 'Apoorva Joshi',
            'Aradhana Singh', 'Arati Ghosh', 'Archit Agarwal', 'Aruna Verma', 'Arundathi Rao',
            'Asha Kumari', 'Asha Devi', 'Ashima Sharma', 'Astha Srivastava', 'Atharv Kulkarni',
            'Avantika Jain', 'Avdhesh Yadav', 'Ayaan Khan',
            'Badri Prasad', 'Bajrang Singh', 'Bakul Sharma', 'Balvinder Kaur', 'Bandana Sinha',
            'Basanti Devi', 'Bela Rani', 'Bhagwati Devi', 'Bhagyashree Patil', 'Bhavik Shah',
            'Bhoomika Nair', 'Bhoomi Sharma', 'Bhuvan Mehta',
            'Chaitali Dey', 'Chaitra Rao', 'Chanda Devi', 'Chandana Menon', 'Chandrakala Singh',
            'Chandramukhi Pillai', 'Chandrashekhar Joshi', 'Charu Lata', 'Charusheela Patil',
            'Chirag Patel', 'Chitra Iyer', 'Chitrakshi Verma',
            'Daksha Mehta', 'Dakshita Rao', 'Damodar Sharma', 'Damini Singh', 'Darshana Patil',
            'Darshini Menon', 'Dayanand Mishra', 'Devaki Nair', 'Devanshi Gupta', 'Devashree Joshi',
            'Devyani Sharma', 'Dhananjay Kulkarni', 'Dhara Patel', 'Dharmendra Singh', 'Dhruva Rao',
            'Disha Agarwal', 'Divija Menon', 'Draupadi Devi',
            'Ekta Kapoor', 'Eshaan Sharma',
            'Falak Khan', 'Farida Begum', 'Fatima Nair',
            'Gajanan Patil', 'Gajra Rani', 'Ganesh Kumar', 'Geeta Iyer', 'Geetika Sharma',
            'Girija Devi', 'Girish Kulkarni', 'Gomati Devi', 'Gunjan Verma', 'Gurmeet Singh',
            'Hansika Motwani', 'Harini Pillai', 'Haritha Rao', 'Harsha Gupta', 'Harshali Sharma',
            'Harshit Jain', 'Harshita Mishra', 'Hemalata Nair', 'Hetal Patel', 'Himanshi Singh',
            'Hiranya Devi',
            'Indumati Sharma', 'Induja Menon', 'Ishani Rao', 'Ishu Verma',
            'Jagannath Mishra', 'Jalaja Nair', 'Jamuna Devi', 'Janardhan Rao', 'Jasleen Kaur',
            'Jasmine Patel', 'Jasminder Kaur', 'Jaswant Singh', 'Jatin Sharma', 'Jaya Bachchan',
            'Jayalakshmi Iyer', 'Jayaraj Menon', 'Jayashri Kulkarni', 'Jessy Thomas', 'Jigna Shah',
            'Jinal Mehta', 'Jinisha Patel', 'Jitesh Verma',
            'Kainaaz Patel', 'Kalawati Devi', 'Kalyani Pillai', 'Kamala Devi', 'Kamalini Rao',
            'Kamalnath Singh', 'Kanika Sharma', 'Kannan Iyer', 'Kanta Bai', 'Kanti Devi',
            'Karishma Kapoor', 'Karuna Nair', 'Kasturba Devi', 'Kaushalya Sharma', 'Keshav Mishra',
            'Khyati Jain', 'Kirandeep Kaur', 'Kiruba Devi', 'Kokilaben Patel', 'Komala Rao',
            'Kripa Sharma', 'Krishna Kumar', 'Krishnapriya Nair', 'Kriti Sanon', 'Kumari Nair',
            'Kumud Sharma', 'Kunal Mehta', 'Kundan Singh',
            'Lajwanti Devi', 'Lata Mangeshkar', 'Lata Sharma', 'Latika Mishra', 'Latika Singh',
            'Leena Iyer', 'Lekshmi Menon', 'Lila Devi', 'Lilibai Singh', 'Lipi Sharma',
            'Lisha Pillai', 'Lopa Mehta',
            'Madhumita Roy', 'Madhusudan Rao', 'Mahima Chaudhary', 'Manavi Joshi', 'Mangal Devi',
            'Mangala Rao', 'Mangi Lal', 'Manickam Iyer', 'Manini Sharma', 'Manjiri Kulkarni',
            'Manohar Lal', 'Mansi Agarwal', 'Manya Singh', 'Mareechi Pillai', 'Matangi Devi',
            'Maya Devi', 'Mayuri Patil', 'Mohana Krishnan', 'Monika Sharma', 'Mrinalini Sen',
            'Mrunal Kulkarni', 'Mudra Joshi',
            'Nagma Patel', 'Nagmani Singh', 'Naina Agarwal', 'Nalina Pillai', 'Namita Sharma',
            'Namrta Jain', 'Nandita Pillai', 'Narayani Devi', 'Naresh Iyer', 'Nasreen Khan',
            'Natasha Singh', 'Neeraja Rao', 'Neethu Menon', 'Nidhan Singh', 'Nidheesh Kumar',
            'Niranjana Pillai', 'Nirmal Singh', 'Nirmala Devi', 'Nishtha Sharma',
            'Ojaswi Rao', 'Ojus Patel',
            'Padma Devi', 'Padmaja Nair', 'Palak Jain', 'Pallabi Roy', 'Palomi Ghosh',
            'Parimala Rao', 'Parineeti Chopra', 'Parul Sharma', 'Parveen Babi', 'Pavithra Nair',
            'Payel Ghosh', 'Phool Kumari', 'Pinki Sharma', 'Pinky Yadav', 'Piyush Gupta',
            'Pragati Singh', 'Pragya Mishra', 'Prajakta Joshi', 'Pratima Rao', 'Priti Sharma',
            'Priyadarshini Nair', 'Priyamvada Pillai', 'Priyanka Mishra', 'Priyanka Rao',
            'Puja Kumari', 'Purnima Sharma', 'Pushpa Lata',
            'Radheshyam Yadav', 'Ragini Sharma', 'Rajalakshmi Iyer', 'Rajani Pillai', 'Rajashri Kulkarni',
            'Rajeswari Rao', 'Rajni Sharma', 'Rajshree Joshi', 'Ramadevi Nair', 'Ramakrishnan Iyer',
            'Ramani Pillai', 'Ramdas Sharma', 'Ramlal Singh', 'Ramona D Cruz', 'Ramya Krishnan',
            'Rani Mukherjee', 'Ranjana Devi', 'Rashida Khan', 'Rashmika Mandanna', 'Ratna Devi',
            'Ratnabai Rao', 'Reena Kapoor', 'Rekha Nair', 'Renu Bala', 'Reshma Singh',
            'Revathi Menon', 'Rinki Gupta', 'Risha Sharma', 'Rishita Jain', 'Roma Agarwal',
            'Romila Rao', 'Roopa Iyer', 'Ruhi Verma', 'Rukmini Devi', 'Rupa Sharma',
            'Rupinder Kaur',
            'Sadhana Singh', 'Sahansha Rao', 'Saira Banu', 'Sairam Krishnan', 'Sakina Begum',
            'Sakunthala Devi', 'Salma Khan', 'Saloni Verma', 'Samiksha Sharma', 'Sampada Kulkarni',
            'Samridhi Jain', 'Samta Devi', 'Sanchita Saha', 'Sangeeta Iyer', 'Sangeetha Nair',
            'Sangita Roy', 'Sanjana Sharma', 'Sarabjit Kaur', 'Saraswati Rao', 'Saroj Singh',
            'Sarojini Nair', 'Satinder Kaur', 'Savitri Devi', 'Savitri Pillai', 'Shaila Nair',
            'Shailaja Rao', 'Shakuntala Sharma', 'Sharada Devi', 'Sharanya Pillai', 'Sharmila Tagore',
            'Shasikala Menon', 'Shefali Shah', 'Shikha Sharma', 'Shilpa Joshi', 'Shivali Gupta',
            'Shivani Sharma', 'Shloka Mehta', 'Shobhana Menon', 'Shraddha Sharma', 'Shruti Haasan',
            'Shruti Verma', 'Shubhangi Patil', 'Shyamala Devi', 'Simarjeet Kaur', 'Sireesha Rao',
            'Smitha Pillai', 'Smriti Irani', 'Smriti Sharma', 'Sobha Iyer', 'Sonica Kapoor',
            'Soniya Sharma', 'Soumya Pillai', 'Sridevi Menon', 'Subhadra Devi', 'Subhashini Rao',
            'Subrata Sen', 'Sudha Murty', 'Sudha Rao', 'Suhasini Menon', 'Sujata Sharma',
            'Sujitha Pillai', 'Sulochana Devi', 'Sumangali Rao', 'Sumathi Nair', 'Sumithra Pillai',
            'Sunanda Rao', 'Suneha Sharma', 'Sunita Yadav', 'Suprabha Nair', 'Supriya Menon',
            'Surabhi Pillai', 'Sushila Devi', 'Sushma Sharma', 'Swapna Pillai', 'Swarnalata Devi',
            'Sweta Mishra',
            'Tanvi Sharma', 'Tapasya Singh', 'Tarini Pillai', 'Taruna Mehta', 'Tasneem Khan',
            'Tejal Patel', 'Tejaswini Rao', 'Thara Nair', 'Tina Sinha', 'Tripti Dimri',
            'Triveni Devi', 'Tulasi Devi', 'Tulsi Sharma',
            'Umarani Devi', 'Umashankari Rao', 'Urvashi Rautela', 'Usha Kumari', 'Utpala Sen',
            'Uttara Pillai',
            'Vaishnavi Pillai', 'Vaishnavi Sharma', 'Valarmathi Rao', 'Varalakshmi Nair', 'Vasantha Devi',
            'Vasundhara Raje', 'Vedha Iyer', 'Vedika Sharma', 'Vega Singh', 'Venkateshwari Rao',
            'Vibhuti Singh', 'Vidula Joshi', 'Vijaya Devi', 'Vijayashree Rao', 'Vimala Nair',
            'Vinodha Menon', 'Vinutha Rao', 'Visakha Devi',
            'Yamuna Devi', 'Yashaswi Sharma', 'Yashoda Nair', 'Yashodhara Pillai', 'Yasmin Patel',
            'Yogamaya Devi', 'Yogeshwari Rao', 'Yugandhar Singh',
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
            $name = trim($review['name'] ?? '');
            // Only use fallback list if AI returned empty name
            if (empty($name)) {
                $newName = $authenticIndianNames[array_rand($authenticIndianNames)];
                while (in_array($newName, $usedNames)) {
                    $newName = $authenticIndianNames[array_rand($authenticIndianNames)];
                }
                $review['name'] = $newName;
                $usedNames[] = $newName;
            } elseif (in_array($name, $usedNames)) {
                // AI returned a duplicate — append a unique suffix to differentiate
                $suffix = ['Kumar', 'Singh', 'Devi', 'Bai', 'Rao', 'Lal', 'Das', 'Nair', 'Iyer', 'Pillai'];
                $parts = explode(' ', $name);
                $newName = $parts[0] . ' ' . $suffix[array_rand($suffix)];
                $attempts = 0;
                while (in_array($newName, $usedNames) && $attempts < 20) {
                    $newName = $parts[0] . ' ' . $suffix[array_rand($suffix)];
                    $attempts++;
                }
                if (in_array($newName, $usedNames)) {
                    // Ultimate fallback: use list
                    $newName = $authenticIndianNames[array_rand($authenticIndianNames)];
                    while (in_array($newName, $usedNames)) {
                        $newName = $authenticIndianNames[array_rand($authenticIndianNames)];
                    }
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
                $wordCount = str_word_count(strip_tags($review['review']));
                // Protect review #1 (SEO review) and any review already 100+ words from being replaced
                if ($index === 0 || $wordCount >= 100) {
                    // Keep the AI-generated review as-is
                } else {
                    $review['review'] = $this->makeReviewAuthentic($review['review'], $index, $isHindi);
                }
            }
        }
        
        return $reviews;
    }
    
    private function makeReviewAuthentic($reviewText, $index, $isHindi = false)
    {
        // If the review is already a decent length, keep it as-is — don't overwrite with fallback
        if (strlen($reviewText) >= 150 || str_word_count($reviewText) >= 25) {
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
            'Sanjay Mehta', 'Anita Kapoor', 'Vikram Singh', 'Kavita Reddy',
            'Manoj Joshi', 'Sunita Sharma', 'Rahul Khanna', 'Geeta Malhotra',
            'Arun Nair', 'Jyoti Iyer', 'Suresh Menon', 'Meera Das', 'Ajay Thakur',
            'Aditi Nair', 'Ananya Mishra', 'Abhishek Joshi', 'Akshay Kulkarni',
            'Divya Menon', 'Harpreet Kaur', 'Karan Mehta', 'Lavanya Krishnan',
            'Nidhi Agarwal', 'Pallavi Joshi', 'Rohit Srivastava', 'Sakshi Sharma',
            'Tanvi Sharma', 'Varsha Gupta', 'Yogesh Sharma', 'Swati Sharma'
        ];
        $newName = $authenticNames[array_rand($authenticNames)];
        while (in_array($newName, $usedNames)) {
            $newName = $authenticNames[array_rand($authenticNames)];
        }
        
        return $newName;
    }
    
    private function convertToEnglishName($hindiName)
    {
        // Build a random name from first+last pools for maximum variety
        $firstNames = [
            'Aarav', 'Aditi', 'Ajay', 'Akash', 'Amita', 'Amruta', 'Ananya', 'Anil',
            'Anita', 'Anjali', 'Ankit', 'Ankita', 'Anurag', 'Archana', 'Arjun', 'Arpit',
            'Arun', 'Asha', 'Ashish', 'Ashok', 'Avni', 'Chandan', 'Chandni', 'Chetan',
            'Deepa', 'Deepak', 'Deepika', 'Devika', 'Dhruv', 'Dimple', 'Divya', 'Dolly',
            'Garima', 'Gaurav', 'Gayatri', 'Geeta', 'Girish', 'Harish', 'Harpreet',
            'Harsh', 'Heena', 'Hemant', 'Hema', 'Himani', 'Hitesh', 'Indira', 'Ishaan',
            'Isha', 'Jagdish', 'Jai', 'Janki', 'Jayant', 'Jitendra', 'Jyoti', 'Kajal',
            'Kamla', 'Karan', 'Karthik', 'Kavita', 'Kavitha', 'Kirti', 'Komal', 'Kritika',
            'Kuldeep', 'Lakshmi', 'Lalitha', 'Lavanya', 'Leela', 'Madhavi', 'Madhu',
            'Mahesh', 'Mamta', 'Mandeep', 'Manish', 'Manisha', 'Manoj', 'Meena',
            'Meenakshi', 'Meera', 'Megha', 'Mohan', 'Mohini', 'Mukesh', 'Nalini',
            'Namrata', 'Nandini', 'Naresh', 'Naveen', 'Neelam', 'Neeraj', 'Neeta',
            'Neha', 'Nidhi', 'Nikhil', 'Nikita', 'Nisha', 'Nishant', 'Pankaj', 'Parag',
            'Pawan', 'Pooja', 'Poonam', 'Pradip', 'Pranav', 'Preeti', 'Prerna', 'Priya',
            'Priyanka', 'Rachna', 'Radhika', 'Rahul', 'Raj', 'Rajani', 'Rajesh', 'Rajni',
            'Raju', 'Rakesh', 'Rakhi', 'Ram', 'Ramesh', 'Rani', 'Ranjit', 'Rashmi',
            'Ravi', 'Rekha', 'Ritesh', 'Ritu', 'Rohit', 'Roshan', 'Rupali', 'Sachin',
            'Sakshi', 'Saloni', 'Sandhya', 'Sandip', 'Sangeeta', 'Sanjay', 'Santosh',
            'Sapna', 'Satish', 'Savita', 'Seema', 'Shalini', 'Shikha', 'Shilpa',
            'Shivani', 'Shreya', 'Shubham', 'Shweta', 'Simran', 'Sneha', 'Sonam',
            'Sonal', 'Sudhir', 'Sujata', 'Sunanda', 'Sunita', 'Suraj', 'Suresh',
            'Swati', 'Tanvi', 'Tarun', 'Usha', 'Vandana', 'Varsha', 'Vikram',
            'Vinay', 'Vishal', 'Yamini', 'Yogesh'
        ];
        $lastNames = [
            'Agarwal', 'Banerjee', 'Bhat', 'Bhatt', 'Biswas', 'Chakraborty', 'Chatterjee',
            'Chauhan', 'Chaudhary', 'Chopra', 'Das', 'Desai', 'Dey', 'Dubey', 'Dutta',
            'Gandhi', 'Ghosh', 'Gupta', 'Iyer', 'Jain', 'Jha', 'Joshi', 'Kapur',
            'Kapoor', 'Kaur', 'Khan', 'Khanna', 'Krishnan', 'Kulkarni', 'Kumar',
            'Malhotra', 'Mehta', 'Menon', 'Mishra', 'Mukherjee', 'Nair', 'Nambiar',
            'Pandey', 'Patel', 'Patil', 'Pillai', 'Prasad', 'Rajan', 'Rao', 'Reddy',
            'Roy', 'Saha', 'Saxena', 'Sen', 'Shah', 'Sharma', 'Shukla', 'Singh',
            'Sinha', 'Soni', 'Srivastava', 'Thakur', 'Thomas', 'Tiwari', 'Tripathi',
            'Varma', 'Verma', 'Yadav'
        ];
        return $firstNames[array_rand($firstNames)] . ' ' . $lastNames[array_rand($lastNames)];
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