<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
        public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $notification = array(
            'message' => 'User Logged Out Successfully',
            'alert-type' => 'success'
        );

        return redirect('/login')->with($notification);
    }

    public function Profile(){
        $id = Auth::user()->id;
        $adminData= User::find($id);
        return view('admin.admin_profile_view', compact('adminData'));
    }

    public function editProfile(){
        $id = Auth::user()->id;
        $editData= User::find($id);
        return view('admin.admin_profile_edit', compact('editData'));
    }

    public function storeProfile(Request $request){
        $id = Auth::user()->id;
        $data= User::find($id);
        $data->name = $request->name;
        $data->username = $request->username;
        $data->email = $request->email;

        if($request->file('profile_image')){
            $file = $request->file('profile_image');

            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'),$filename);
            $data['profile_image'] = $filename;
        }
        $data->save();

        $notification = array(
            'message' => 'Admin Profile Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.profile')->with($notification);
    }

    public function changePassword(){
        return view('admin.admin_change_password');
    }
    
    public function updatePassword(Request $request){

        $validateData = $request->validate([
            'oldPassword' => 'required',
            'newPassword' => 'required',
            'confirmPassword' => 'required|same:newPassword',
        ]);

        $hashedPassword = Auth::user()->password;
        if (hash::check($request->oldPassword, $hashedPassword )){
            $user = User::find(Auth::id());
            $user->password = bcrypt($request->newPassword);
            $user->save();

            session()->flash('message','Password Updated Successfully');
            return redirect()->back();
        } else{
            session()->flash('message','Old Password is not matched.');
            return redirect()->back();
        }
    }
}