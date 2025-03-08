<?php
namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use DB;
use Illuminate\Support\Str;
class UsersController extends Controller
{
    public function index() 
    {
        $users = User::latest()->paginate(10);

        return view('backend.users.index', compact('users'));
    }

    public function create() 
    {
        return view('backend.users.create');
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|min:3|max:50',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|min:10',
            'password' => 'min:8|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:8'
        ]);
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
    
        $user = User::create($input);
        if($user){
            return redirect()->route('users')
            ->with('success','User created successfully');
        }
        return redirect()->back()->with('error','Somthings went wrong please try again !.');
    }

    public function edit(User $user) {
        return view('backend.users.edit', [
            'user' => $user,
            'userRole' => $user->roles->pluck('name')->toArray(),
            'roles' => Role::latest()->get()
        ]);
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'name' => 'required|min:3|max:50',
            'phone_number' => 'required|min:10',
           
        ]);
        $input = $request->all();
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
        $user->assignRole($request->input('role'));
        return redirect()->route('users')->with('success','User updated successfully');
        
    }

    public function destroy(User $user) {
        $user->delete();
        return redirect()->route('users')->with('success','User deleted successfully');
    }

    public function UserProfile() {
        return view('backend.users.profile');
    }

    public function UserProfileEditForm($id) {
        return view('backend.users.profile-edit');
    }

    public function UserProfileEditFormSubmit(Request $request, $id){
        $request->validate([
            'name' => 'nullable|string|max:255',
            'phone_number' => 'nullable|numeric',
            'gender' => 'nullable|string|max:10',
            'address' => 'nullable|string|max:255',
            'profile_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
            'email' => 'nullable|email|unique:users,email,' . $id
        ]);
        $user = User::findOrFail($id);
        $emailChanged = false;
        if ($request->has('email') && $request->email != $user->email) {
            $emailChanged = true;
        }
        
        if ($request->hasFile('profile_img')) {
            /**Remove profile image */
            $remove_profile_image = public_path('profile-images'.$user->profile_img);
            if (file_exists($remove_profile_image) && !is_dir($remove_profile_image)) {
                unlink($remove_profile_image);
            } 
            /**Remove profile image */

            $image = $request->file('profile_img');
            $user_name = Str::slug($request->input('name', $user->name));
            $filenameWithExt = $image->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $image_file_name = 'profile-image-' . $user_name . '.webp'; 

            $profile_image_path = public_path('profile-images');
            if (!file_exists($profile_image_path)) {
                mkdir($profile_image_path, 0775, true);
            }                   
            
            $img_large = Image::make($image->getRealPath());
            $img_large->resize(800, 800, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('webp', 100)->save($profile_image_path . '/' . $image_file_name);
            $user->profile_img = $image_file_name;
        }
        $user->name = $request->input('name', $user->name);
        $user->email = $request->input('email', $user->email);
        $user->phone_number = $request->input('phone_number', $user->phone_number);
        $user->gender = $request->input('gender', $user->gender);
        $user->address = $request->input('address', $user->address);
        $user->save();
        /*Store session flag for email change*/
        if ($emailChanged) {
            session(['email_changed' => true]);
        }
        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    }

}
