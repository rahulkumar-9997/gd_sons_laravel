<?php
namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WhatsappConversation;
use App\Models\WhatsappConversationMessage;
use Illuminate\Support\Facades\Http;
use Vinkla\Hashids\Facades\Hashids;
class WhatsappConversationController extends Controller
{
    public function index(){
        $WhatsappConversation = WhatsappConversation::with('messages')
        ->withCount('messages')
        ->orderBy('id', 'desc')
        ->get();
        //return response()->json($WhatsappConversation);
        return view('backend.manage-whatsapp.manage-whatsapp-conversation.index', compact('WhatsappConversation'));
    }

    public function create(Request $request){
        $token = $request->input('_token'); 
        $size = $request->input('size'); 
        $url = $request->input('url'); 
        $form ='
        <div class="modal-body">            
            <form method="POST" action="'.route('manage-whatsapp-conversation.store').'" accept-charset="UTF-8" enctype="multipart/form-data" id="add_new_conversation_form">
                '.csrf_field().'
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="mobile_number" class="form-label">Mobile No. *</label>
                            <input type="text" id="mobile_number" name="mobile_number" class="form-control" maxlength="10" pattern="^\d{10}$">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" name="name" class="form-control">
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="conversation_message" class="form-label">Conversation Message</label>
                            <textarea class="form-control" id="conversation_message" rows="2" name="conversation_message"></textarea>
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
            'message' => 'Conversation Form created successfully',
            'form' => $form,
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'mobile_number' => 'required|string|max:10',
            'name' => 'nullable|string|max:255',
            'conversation_message' => 'required|string',
        ]);
        $conversation = WhatsappConversation::where('mobile_number', $request->mobile_number)->first();
        if ($conversation) {
            $conversation_id = $conversation->id;
        } else {
            $conversation = WhatsappConversation::create([
                'mobile_number' => $request->mobile_number,
                'name' => $request->name,
                'conversation_message' => $request->conversation_message,
            ]);
            $conversation_id  =  $conversation->id;
        }
        $WhatsappConversationMessage = WhatsappConversationMessage::create([
            'whats_app_conversation_id' => $conversation_id,
            'conversation_message' => $request->conversation_message,
        ]);
        $response = $this->sendWhatsappMessage(
            $request->mobile_number,
            $request->name,
            $request->conversation_message,
            $WhatsappConversationMessage->id,
        );
        if ($response->successful()) {
            $WhatsappConversation = WhatsappConversation::with('messages')
            ->withCount('messages')
            ->orderBy('id', 'desc')
            ->get();
            return response()->json([
                'status' => 'success',
                'message' => 'Conversation processed and API request sent.',
                'conversationContent' => view(
                    'backend.manage-whatsapp.manage-whatsapp-conversation.partials.ajax-conversation-list',
                    compact('WhatsappConversation')
                )->render(),
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'API request failed.',
                'errorDetails' => $response->json(),
            ], 500);
        }
    }

    public function edit(Request $request, $id){
        $WhatsappConversation = WhatsappConversation::findOrFail($id);
        $form ='
        <div class="modal-body">            
            <form method="POST" action="'.route('manage-whatsapp-conversation.update', $id).'" accept-charset="UTF-8" enctype="multipart/form-data" id="edit_conversation_form">
                '.csrf_field().'
                '.method_field('PUT').'
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="mobile_number" class="form-label">Mobile No. *</label>
                            <input type="text" id="mobile_number" name="mobile_number" class="form-control" value="'.$WhatsappConversation->mobile_number.'" maxlength="10" pattern="^\d{10}$">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" name="name" class="form-control" value="'.$WhatsappConversation->name.'">
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
            'message' => 'Conversation Form created successfully',
            'form' => $form,
        ]);
    }

    public function update(Request $request, $id){
        $request->validate([
            'mobile_number' => 'required|string|max:15|unique:whats_app_conversation,mobile_number,'.$id,
            'name' => 'nullable|string|max:255',
            
        ]);
        $conversation = WhatsappConversation::find($id);
        if (!$conversation) {
            return response()->json([
                'status' => 'error',
                'message' => 'Conversation not found.',
            ], 404);
        }

        $conversation->update([
            'mobile_number' => $request->mobile_number,
            'name' => $request->name,
        ]);
        
        $WhatsappConversation = WhatsappConversation::with('messages')
            ->withCount('messages')
            ->orderBy('id', 'desc')
            ->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Conversation updated successfully.',
            'conversationContent' => view('backend.manage-whatsapp.manage-whatsapp-conversation.partials.ajax-conversation-list', compact('WhatsappConversation'))->render(),
        ]);
    }

    private function sendWhatsappMessage($mobileNumber, $name, $message, $WhatsappConversationMessageId){
        $name = !empty($name) ? $name : $mobileNumber;
        $WhatsappConversationMessageId = Hashids::encode($WhatsappConversationMessageId);
        $url = "https://www.gdsons.co.in/confirmwa/yes/{$WhatsappConversationMessageId}";
        $apiData = [
            "apiKey" => "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY1NmYwNjVjNmE5ZjJlN2YyMTBlMjg1YSIsIm5hbWUiOiJHaXJkaGFyIERhcyBhbmQgU29ucyIsImFwcE5hbWUiOiJBaVNlbnN5IiwiY2xpZW50SWQiOiI2NDJiZmFhZWViMTg3NTA3MzhlN2ZkZjgiLCJhY3RpdmVQbGFuIjoiTk9ORSIsImlhdCI6MTcwMTc3NDk0MH0.x19Hzut7u4K9SkoJA1k1XIUq209JP6IUlv_1iwYuKMY",
            "campaignName" => "Send Message to Customer for Keyword Enquiry",
            "destination" => $mobileNumber,
            "userName" =>  $name,
            "templateParams" => [
                $name,
                $message,
                $WhatsappConversationMessageId
            ],
            "source" => "new-landing-page form",
            "media" => new \stdClass(),
            "buttons" => [],
            "carouselCards" => [],
            "location" => new \stdClass(),
            "paramsFallbackValue" => [
                "FirstName" => "User"
            ]
        ];

        return Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->post('https://backend.aisensy.com/campaign/t1/api/v2', $apiData);
    }

    public function sendAgainMsgModal(Request $request, $id){
        $WhatsappConversation = WhatsappConversation::with('messages')
        ->where('id', $id)
        ->first();
        $form ='
        <div class="modal-body">
            <h5>'.$WhatsappConversation->name.'</h5>
            <table class="table table-bordered">
                <tr>
                    <th>
                        Earlier Message
                    </th>
                <tr>';
                foreach($WhatsappConversation->messages as $message){                    
                    $form .='
                    <tr>
                        <td>'.$message->conversation_message .'</td>
                    </tr>';
                }
            $form .='
            </table>            
            <form method="POST" action="'.route('whatsapp-conversation.sendmessage', $id).'" accept-charset="UTF-8" enctype="multipart/form-data" id="send_again_conversation_form">
                '.csrf_field().'
                '.method_field('POST').'
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="mobile_number" class="form-label">Mobile No. *</label>
                            <input type="text" id="mobile_number" name="mobile_number" class="form-control" value="'.$WhatsappConversation->mobile_number.'" maxlength="10" pattern="^\d{10}$" readonly="">
                        </div>
                    </div>
                                        
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="conversation_message" class="form-label">Conversation Messagem *</label>
                            <textarea class="form-control" id="conversation_message" rows="2" name="conversation_message"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer pb-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </div>
                </div>
            </form>
        </div>
        ';
        return response()->json([
            'message' => 'Conversation Form created successfully',
            'form' => $form,
        ]);
    }

    public function sendAgainMsgModalSubmit(Request $request, $id){
        $request->validate([
            'mobile_number' => 'required|string|max:15|unique:whats_app_conversation,mobile_number,'.$id,
            'conversation_message' => 'required|string',
        ]);
        $conversation = WhatsappConversation::find($id);
        if (!$conversation) {
            return response()->json([
                'status' => 'error',
                'message' => 'Conversation not found.',
            ], 404);
        }

        $WhatsappConversationMessage = WhatsappConversationMessage::create([
            'whats_app_conversation_id' => $id,
            'conversation_message' => $request->conversation_message,
        ]);
        $response = $this->sendWhatsappMessage(
            $request->mobile_number,
            $conversation->name,
            $request->conversation_message,
            $WhatsappConversationMessage->id,
        );
        $WhatsappConversation = WhatsappConversation::with('messages')
            ->withCount('messages')
            ->orderBy('id', 'desc')
            ->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Conversation updated successfully.',
            'conversationContent' => view('backend.manage-whatsapp.manage-whatsapp-conversation.partials.ajax-conversation-list', compact('WhatsappConversation'))->render(),
        ]);
    }

    public function destroy($id){
        $conversation = WhatsappConversation::with('messages')->findOrFail($id);
        $conversation->messages()->delete();  
        $conversation->delete();
        return redirect('manage-whatsapp-conversation')->with('success', 'Whatsapp conversation  and its messages deleted successfully');
    }

}
