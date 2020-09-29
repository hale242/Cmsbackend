<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class AuthController extends Controller
{
     public function checkLogin(Request $request)
     {
          $username = $request->input('username');
          $password = $request->input('password');
          $remember = $request->input('remember' , 'F');
          if (Auth::attempt(['username' => $username, 'password' => $password, 'status' => 1] , $remember)) {
               // $user = Auth::guard('admin')->user();
               // if(!$user->api_token){
               //     $token = Hash::make('60');
               //     AdminUser::where('id' , $user->id)->update(['api_token' => $token]);
               // }
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
}
