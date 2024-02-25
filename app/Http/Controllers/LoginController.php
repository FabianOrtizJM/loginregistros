<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\support\facades\Hash;
use Illuminate\support\facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function registro(Request $request){
        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $cantidadusuarios = DB::table('users')->count();
        if($cantidadusuarios == 0){
            $user->assignRole(1);
        }else{
            $user->assignRole(2);
        }

        $user->save();

        return redirect(route('login'));
    }

    public function login(Request $request){

        $credentials =[
            "email" => $request->email,
            "password" => $request->password,
        ];

        $remember = ($request->has('remember') ? true : false);

        if(Auth::attempt($credentials,$remember)){
            $request->session()->regenerate();
            return redirect()->intended(route('inicio'));
        }else{
            return redirect('login');
        }
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('login'));
    }
}
