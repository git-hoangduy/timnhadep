<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function login(){
        return view('admin.auth.login');
    }
    public function postLogin(Request $request){

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('post.index');
        }
  
        return redirect()->back()->with("error", "Thông tin email hoặc mặt khẩu không chính xác, xin hãy thử lại.");
        
    }

    public function logout() {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    public function changePassword()
    {
        return view('admin.auth.passwords.change');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        $user = Auth::guard('admin')->user();

        if (!Hash::check($request->old_password, $user->password)){
            return back()->with("error", "Mật khẩu cũ không trùng khớp");
        }
        
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with("success", "Thay đổi mật khẩu thành công");
    }
}
