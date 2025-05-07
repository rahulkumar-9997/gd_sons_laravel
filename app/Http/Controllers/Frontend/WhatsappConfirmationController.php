<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;
use App\Models\WhatsappConversation;
use App\Models\WhatsappConversationMessage;
class WhatsappConfirmationController extends Controller
{
    public function confirmWhatsappYes($WhatsappConversationMessageId)
    {
        $decodedId = Hashids::decode($WhatsappConversationMessageId)[0] ?? null;
        if (!$decodedId) {
            abort(404, 'Invalid ID');
        }
        $message = WhatsappConversationMessage::find($decodedId);
        if ($message) {
            $message->reply = 'Yes';
            $message->save();
            $conversationMessage = $message->conversation_message;
            $conversation = WhatsappConversation::find($message->whats_app_conversation_id);
            return redirect()
            ->route('search', ['query' => $conversationMessage])
            ->with('success', 'You confirmed "Yes" and we searched your message successfully.');

        }
        abort(404, 'Message not found');
    }
    
}

