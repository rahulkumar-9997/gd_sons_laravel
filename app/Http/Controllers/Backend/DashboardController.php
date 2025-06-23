<?php
namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\Attribute_values;
use App\Models\Brand;
use App\Models\Customer;
use App\Models\Orders;
use App\Models\OrderStatus;
use App\Models\VisitorTracking;
use App\Models\ClickTrackers;
use App\Models\Counter;
use Image;
class DashboardController extends Controller
{
    public function index(){
        $user = Auth::user();
        $data['category_count'] = Category::count();
        $data['product_count'] = Product::count();
        $data['attribute_count'] = Attribute::count();
        $data['attributeValue_count'] = Attribute_values::count();
        $data['brand_count'] = Brand::count();
        $data['customer_count'] = Customer::count();
        $data['order_count'] = Orders::count();
        $data['order_status_count'] = OrderStatus::withCount('orders')->get();
        $data['button_counter'] = Counter::all();
        $data['click_tracker'] = ClickTrackers::count();
        return view('backend.dashboard.index', compact('data'));
    }

    public function getFilteredProductData(Request $request){
        $filter = $request->input('filter', 'all');
        $query = Product::selectRaw('MONTH(created_at) as month, COUNT(*) as total_products')
            ->groupBy('month')->orderBy('month');
        if ($filter === '1M') {
            $query->where('created_at', '>=', now()->subMonth());
        } elseif ($filter === '6M') {
            $query->where('created_at', '>=', now()->subMonths(6));
        } elseif ($filter === '1Y') {
            $query->where('created_at', '>=', now()->subYear());
        }
        $filteredData = $query->get();
        $formattedData = [
            'months' => [],
            'totals' => []
        ];
        foreach ($filteredData as $data) {
            $formattedData['months'][] = date('F', mktime(0, 0, 0, $data->month, 1)); 
            $formattedData['totals'][] = $data->total_products;
        }
        return response()->json($formattedData); // Return JSON response
    }


    public function showProfileUpdateForm(){
        $user = Auth::user();
        return view('backend.profile.index' , compact('user'));
    }

    public function updateProfile(Request $request){
        $user_id = Auth::user()->id;
        
        // $this->validate($request, [
        //     'profile_name' => ['nullable', 'required'],
        //     'mobile_number' =>  ['nullable', 'required|numeric|digits:10'],
        //     //'profile_photo' =>  ['nullable', 'required'],
        //     'update_password' =>  ['nullable', 'required|digits:8'],
        // ]);

        $input['name'] = $request->input('profile_name');
        $input['phone_number'] = $request->input('mobile_number');
        $input['email'] = $request->input('profile_email');
       
        $user_row = User::find($user_id);
        
        if ($request->hasFile('profile_photo')){
            $image = $request->file('profile_photo');
            $filenameWithExt = $image->getClientOriginalName();  
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $image->getClientOriginalExtension();
            $image_file_name = $filename.'_'.time().'.'.$extension;
            
           
            $destination_path_main_img_ = public_path('hotel-sankalp-image-file/profile-img/');
            /*Unlink image*/
            // $file_old_thumb = $destination_path_thumb.$user_row->profile_img;
            if(!empty($user_row->profile_img)){
                $file_old_main = $destination_path_main_img_.$user_row->profile_img;
                
                if (file_exists($file_old_main)) {
                    unlink($file_old_main);
                }
            }
            $destinationPath = public_path('hotel-sankalp-image-file/profile-img/');
            $image->move($destinationPath, $image_file_name);
            $input['profile_img'] = $image_file_name;
        }
        $image_upload = $user_row->update($input);
        if($request->input('current_password') && $request->input('new_password')){
            $auth = Auth::user();
            if (!Hash::check($request->get('current_password'), $auth->password)) 
            {
                return back()->with('error', "Current Password is Invalid");
            }
                        
            if (strcmp($request->get('current_password'), $request->new_password) == 0) 
            {
                return redirect()->back()->with("error", "New Password cannot be same as your current password.");
            }
            $user =  User::find($auth->id);
            $user->password =  Hash::make($request->new_password);
            $user->save();
            return back()->with('success', "Password Changed Successfully");
        }
 

        if ($image_upload){
            return redirect('manage-profile')->with('success','Profile updated successfully');
        }else{
            return redirect()->back()->with('error','Somthings went wrong please try again !.');
        }
    }

    public function getVisitorStats(){
        $monthlyData = VisitorTracking::selectRaw('DATE(visited_at) as date, COUNT(DISTINCT ip_address) as unique_visitors')
        ->whereBetween('visited_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])
        ->groupBy('date')
        ->orderBy('date', 'ASC')
        ->get();

        $formattedData = [];
        $categories = [];

        foreach ($monthlyData as $data) {
            $formattedData[] = $data->unique_visitors; 
            $categories[] = Carbon::parse($data->date)->format('M d');
        }

        return response()->json([
            'data' => $formattedData,
            'categories' => $categories
        ]);
    
    }

    public function getVisitorList(){
        $data['visitor_list'] = VisitorTracking::orderBy('id', 'desc')->paginate(50);
        $data['page_counts'] = VisitorTracking::selectRaw('
                page_name, 
                COUNT(*) as visitor_count'
            )
            ->groupBy('page_name')
            ->get()
            ->keyBy(function($item) {
                return $item->page_name;
            });
        return view('backend.dashboard.visitor-list', compact('data')); 
    }

    public function getClickDetails()
    {
        $data['click-link'] = ClickTrackers::orderBy('click_time', 'desc')->paginate(50);
        return view('backend.dashboard.click-list', compact('data'));
    }
}
