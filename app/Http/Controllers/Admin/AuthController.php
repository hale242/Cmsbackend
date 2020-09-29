<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AdminUser;
use Auth;
use Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }

    public function checkLogin(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $remember = $request->input('remember' , 'F');
        if(Auth::guard('admin')->attempt(['username' => $username, 'password' => $password, 'status' => 1] , $remember)) {
            $admin_user = Auth::guard('admin')->user();
            AdminUser::where('admin_id', $admin_user->admin_id)->update(['last_login' => date('Y-m-d H:i:s')]);
            $return['status'] = 1;
            $return['title'] = "สำเร็จ";
            $return['content'] = "เข้าสู่ระบบเรียบร้อย";
        }else{
            $return['status'] = 0;
            $return['title'] = "ไม่สำเร็จ";
            $return['content'] = "Username หรือ Password ไม่ถูกต้อง";
        }

        return $return;
    }

    public function Logout(){
        Auth::guard('admin')->logout();
        return redirect('/admin');
    }
}
