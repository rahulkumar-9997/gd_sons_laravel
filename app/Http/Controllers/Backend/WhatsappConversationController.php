<?php
namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WhatsappConversation;
use Illuminate\Support\Facades\Http;

class WhatsappConversationController extends Controller
{
    public function index(){
        $WhatsappConversation = WhatsappConversation::orderBy('id', 'desc')->get();
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
           'mobile_number' => 'required|string|max:15|unique:whats_app_conversation,mobile_number',
            'name' => 'nullable|string|max:255',
            'conversation_message' => 'required|string',
        ]);
        $conversation = WhatsappConversation::create([
            'mobile_number' => $request->mobile_number,
            'name' => $request->name,
            'conversation_message' => $request->conversation_message,
        ]);
        $response = $this->sendWhatsappMessage($request->mobile_number, $request->name, $request->conversation_message);
        if ($response->successful()) {
            $WhatsappConversation = WhatsappConversation::orderBy('id', 'desc')->get();
    
            return response()->json([
                'status' => 'success',
                'message' => 'Conversation stored successfully and API request sent.',
                'conversationContent' => view('backend.manage-whatsapp.manage-whatsapp-conversation.partials.ajax-conversation-list', compact('WhatsappConversation'))->render(),
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to send API request.',
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
                    
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="conversation_message" class="form-label">Conversation Message</label>
                            <textarea class="form-control" id="conversation_message" rows="2" name="conversation_message">'.$WhatsappConversation->conversation_message.'</textarea>
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
            'conversation_message' => 'required|string',
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
            'conversation_message' => $request->conversation_message,
        ]);
        $response = $this->sendWhatsappMessage($request->mobile_number, $request->name, $request->conversation_message);
        $WhatsappConversation = WhatsappConversation::orderBy('id', 'desc')->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Conversation updated successfully.',
            'conversationContent' => view('backend.manage-whatsapp.manage-whatsapp-conversation.partials.ajax-conversation-list', compact('WhatsappConversation'))->render(),
        ]);
    }

    private function sendWhatsappMessage($mobileNumber, $name, $message){
        $name = !empty($name) ? $name : $mobileNumber;
        $apiData = [
            "apiKey" => "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY1NmYwNjVjNmE5ZjJlN2YyMTBlMjg1YSIsIm5hbWUiOiJHaXJkaGFyIERhcyBhbmQgU29ucyIsImFwcE5hbWUiOiJBaVNlbnN5IiwiY2xpZW50SWQiOiI2NDJiZmFhZWViMTg3NTA3MzhlN2ZkZjgiLCJhY3RpdmVQbGFuIjoiTk9ORSIsImlhdCI6MTcwMTc3NDk0MH0.x19Hzut7u4K9SkoJA1k1XIUq209JP6IUlv_1iwYuKMY",
            "campaignName" => "Confirm_Product_Enquiry_Admin",
            "destination" => $mobileNumber,
            "userName" =>  $mobileNumber,
            "templateParams" => [
                $name,
                $message
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

    public function destroy($id){
        $conversation = WhatsappConversation::findOrFail($id);
        $conversation->delete();
        return redirect('manage-whatsapp-conversation')->with('success','Whatsapp conversation deleted successfully');
    }

}
