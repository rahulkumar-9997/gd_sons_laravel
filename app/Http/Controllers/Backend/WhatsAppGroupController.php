<?php
namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Groups;
use App\Models\GroupCategories;
use App\Models\Customer;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Support\Facades\Log;
// use Illuminate\Support\Facades\Cache;
// use Illuminate\Support\Facades\Http;
// use Intervention\Image\Facades\Image;
// use Illuminate\Support\Facades\File;
class WhatsAppGroupController extends Controller
{
    public function index(){
        return view('backend.manage-whatsapp.manage-group-whatsapp.index');
    }

    public function create(Request $request){
        $groupId = $request->query('group');
        $groups = Groups::orderBy('id', 'DESC')->get();
        $customer_list = collect();
        if ($groupId) {
            $selected_group = Groups::with('groupCategory')->findOrFail($groupId);
            // $customer_list = Customer::with('groupCategory')
            //     ->where('group_category_id', $selected_group->groups_category_id)
            //     ->get();
            // $customer_list->each(function ($customer) use ($selected_group) {
            //     $customer->group_name = $selected_group->name;
            //     $customer->group_category_name = $selected_group->groupCategory->name ?? 'N/A';
            // });
            $customer_list = Customer::where('group_category_id', $selected_group->groups_category_id)
                ->get();
            $customer_list->each(function ($customer) use ($selected_group) {
                $customer->group_name = $selected_group->name;
                $customer->group_category_name = $selected_group->groupCategory->name ?? 'N/A';
            });

           //return response()->json($customer_list);
        }        
        return view('backend.manage-whatsapp.manage-group-whatsapp.create', compact('groups', 'customer_list'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'group' => 'required|exists:groups,id',
            'customer_id' => 'required|array',
            'customer_id.*' => 'exists:customers,id',
            'product_url' => 'required|url',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 422);
        }

        $selectedCustomers = $request->input('customer_id');
        foreach ($selectedCustomers as $customerId) {
            $customer = Customer::find($customerId);
            if ($customer) {
                // Here, you can integrate WhatsApp API logic to send messages
                // Example: Send message to $customer->phone_number with $request->product_url
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'WhatsApp messages sent successfully!',
        ]);
    }
}
