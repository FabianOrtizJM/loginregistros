<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\CodeMail;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use TimeHunter\LaravelGoogleReCaptchaV2\Validations\GoogleReCaptchaV2ValidationRule;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class AuthController extends Controller
{
    public function mostrarFormularioRegistro()
    {
        return view('registro');
    }
    public function mostrarFormulariologin()
    {
        return view('login');
    }
    public function mostrarFormularioinicio()
    {
        return view('inicio');
    }
    public function registro(Request $request){
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50|unique:users',
            'email' => 'required|email|max:50|unique:users',
            'password' => 'required|min:8|max:30|confirmed',
            'g-recaptcha-response' => [new GoogleReCaptchaV2ValidationRule()],
        ]);

        if ($validator->fails()) {
            $errorMessage = $validator->errors();

            Log::error('Error al validar el formulario de registro: ' . $errorMessage, [
                'name' => $request->name,
                'email' => $request->email,
                'location' => $request->ip(),
            ]);
            return redirect()->route('registro')->with(['error' => 'Datos no validos, vuelve a intentarlo']);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $cantidadusuarios = DB::table('users')->count();
        if($cantidadusuarios == 0){
            $user->assignRole(1);
            Log::info('Se registro un usuario como administrador con los siguientes datos: '. ' name: '. $request->name . ' ' . ' email: '. $request->email);
            $user->save();
            return redirect()->route('login');         
        }else{
            $user->assignRole(2);
            $user->save();
            Log::info('Se registro un usuario como usuario normal con los siguientes datos: '. ' name: '. $request->name . ' ' . ' email: '. $request->email);
            return redirect(route('login'));
        }

    }

    public function login(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:50',
            'password' => 'required|min:8|max:30',
            'g-recaptcha-response' => [new GoogleReCaptchaV2ValidationRule()],
        ]);

        if ($validator->fails()) {
            $errorMessage = $validator->errors();

            Log::error('Error al validar el formulario de inicio de sesion: ' . $errorMessage, [
                'email' => $request->email,
                'location' => $request->ip(),
            ]);
            return redirect()->route('login')->with(['error' => 'Datos no validos, vuelve a intentarlo']);
        }

        $credentials =[
            "email" => $request->email,
            "password" => $request->password,
        ];

        if(Auth::once($credentials)){
        $user = Auth::user();
        if($user->hasRole('Administrador')){
            $ip = $request->ip();
            if(!in_array($ip, $allowedIps)){
                Log::error('Intento de inicio de sesion con los siguientes datos: '. ' email: '. $request->email . ' ip: ' . $request->ip()); 
                return redirect()->route('login')->with(['error' => 'El administrador debe loguear desde una red privada']);
            }
            $user->token_login = '';
            $user->triple_factor_code = Crypt::encryptString($code = rand(9999, 1000));
            $user->save();
            Mail::to($user->email)->send(new CodeMail($code, $user->email));
            return view("auth2fa", compact('user'))->with(['success' => 'Se ha enviado un código de verificación a tu correo']);
        }
        $allowedIps= ['10.124.2.7'];
        $ip = $request->ip();
        if(in_array($ip, $allowedIps)){
            Log::error('Intento de inicio de sesion con los siguientes datos: '. ' email: '. $request->email . ' ip: ' . $request->ip());
            return redirect()->route('login')->with(['error' => 'El usuario no puede loguear desde una red privada']);
        }
        $user->token_login = Crypt::encryptString($code = rand(9999, 1000));
        $user->save();
        Mail::to($user->email)->send(new CodeMail($code, $user->email));
        return view("auth2fa", compact('user'))->with(['success' => 'Se ha enviado un código de verificación a tu correo']);      
        }
        Log::error('Intento de inicio de sesion con los siguientes datos: '. ' email: '. $request->email . ' ip: ' . $request->ip()); 
        return redirect()->route('login')->with(['error' => 'Datos no validos, vuelve a intentarlo']);
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('login'));
    }
    
    public function login2FA(Request $request, User $user)
    {
        $request->validate(['code_verification' => 'required']);
        $encrypt = $user->token_login;
        $deencrypt = Crypt::decryptString($encrypt);
        if ($request->code_verification == $deencrypt) {
            $request->session()->regenerate();
            Auth::login($user);
            $urlFirmada = URL::signedRoute('inicio');
            return redirect()->away($urlFirmada);
        }
        return redirect()->back()->withErrors(['error'=> 'Código de verificación incorrecto']);
    }

    // public function verifyEmail(Request $request){
    //     $user = User::find($request->user()->id);
    //     if($user->email_verified_at == null){
    //         $user->email_verified_at = now();
    //         $user->save();
    //     }
    //     return redirect()->route('inicio');
    // }

    public function verifyAdminCode(Request $request){
        $validator = Validator::make($request->all(), [
            'admin_code' => 'required',
            'email' => 'required|email|max:50',
        ]);
        if($validator->fails()){
            return response()->json([
                'error' => $validator->errors()
            ]);
        }
        $user = User::where('email', $request->email)->first();
        if($user){
            if($user->triple_factor_code == ''){
                return response()->json(['error' => 'No se ha solicitado un código de verificación']);
            }
            $encrypt = $user->triple_factor_code;
            $deencrypt = Crypt::decryptString($encrypt);
            if($request->admin_code == $deencrypt){
                $user->token_login = Crypt::encryptString($code = rand(9999, 1000));
                $user->triple_factor_code = '';
                $user->save();
                return response()->json(['success' => 'Código de verificación correcto, ingresa el siguiente codigo en la app web: ' . $code . ' para iniciar sesion']);
            }
        }
        return response()->json(['error' => 'Código de verificación incorrecto']);
    }
}
