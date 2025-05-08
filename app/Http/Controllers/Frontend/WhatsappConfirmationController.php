<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;
use App\Models\WhatsappConversation;
use App\Models\WhatsappConversationMessage;
use Illuminate\Support\Facades\Log;
class WhatsappConfirmationController extends Controller
{
    public function confirmWhatsappYes($WhatsappConversationMessageId)
    {
        try {
            $decodedId = Hashids::decode($WhatsappConversationMessageId)[0] ?? null;
            if (!$decodedId) {
                abort(404, 'Invalid ID');
            }
            $message = WhatsappConversationMessage::find($decodedId);
            if (!$message) {
                abort(404, 'Message not found');
            }
            $message->reply = 'Yes';
            $message->save();
            $conversationMessage = $message->conversation_message;
            $conversation = WhatsappConversation::find($message->whats_app_conversation_id);
            $apiData = [
                'apiKey' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY1NmYwNjVjNmE5ZjJlN2YyMTBlMjg1YSIsIm5hbWUiOiJHaXJkaGFyIERhcyBhbmQgU29ucyIsImFwcE5hbWUiOiJBaVNlbnN5IiwiY2xpZW50SWQiOiI2NDJiZmFhZWViMTg3NTA3MzhlN2ZkZjgiLCJhY3RpdmVQbGFuIjoiTk9ORSIsImlhdCI6MTcwMTc3NDk0MH0.x19Hzut7u4K9SkoJA1k1XIUq209JP6IUlv_1iwYuKMY',
                'campaignName' => 'Yes Message from Customer to Admin',
                'destination' => '9935070000',
                'userName' => 'Girdhar Das and Sons',
                'templateParams' => [
                    $conversation->name,
                    $conversation->mobile_number,
                    $conversationMessage
                ],
                'source' => 'new-landing-page form',
                'media' => new \stdClass(),
                'buttons' => [],
                'carouselCards' => [],
                'location' => new \stdClass(),
                'attributes' => new \stdClass(),
                'paramsFallbackValue' => [
                    'FirstName' => 'user'
                ]
            ];
            $ch = curl_init('https://backend.aisensy.com/campaign/t1/api/v2');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($apiData));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json'
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);
            if ($response === false || $httpCode !== 200) {
                Log::error('AiSensy API Error', [
                    'http_code' => $httpCode,
                    'curl_error' => $curlError,
                    'response' => $response
                ]);
                return redirect()
                    ->route('search', ['query' => $conversationMessage])
                    ->with('error', 'Message confirmed, but failed to notify admin via WhatsApp.');
            }

            return redirect()
                ->route('search', ['query' => $conversationMessage])
                ->with('success', 'You confirmed "Yes" and we searched your message successfully.');
        } catch (\Throwable $e) {
            Log::error('Exception in confirmWhatsappYes', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->back()
                ->with('error', 'Something went wrong while confirming the message. Please try again.');
        }
    }

    
}

