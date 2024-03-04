<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\support\facades\Hash;
use Illuminate\support\facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Traits\HasRoles;
use TimeHunter\LaravelGoogleReCaptchaV2\Validations\GoogleReCaptchaV2ValidationRule;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Support\Facades\Crypt;

class LoginController extends Controller
{
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
            $google2fa = app(Google2FA::class);
            $secret = $google2fa->generateSecretKey();
            $encryptsecret = Crypt::encryptString($secret);
            $user->token_login = $encryptsecret;
            $deencrypt = Crypt::decryptString($encryptsecret);
            Log::info('Se registro un usuario como administrador con los siguientes datos: '. ' name: '. $request->name . ' ' . ' email: '. $request->email);
            $user->save();
            return redirect()->route('login')->with(['success'=>'2FA: ' .$deencrypt]);          
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
        $remember = ($request->has('remember') ? true : false);
        if(Auth::attempt($credentials,$remember)){
            $request->session()->regenerate();
                $user = Auth::user();
                if($user->hasRole('Administrador')){
                    Log::info('Se inicio sesion como administrador con los siguientes datos: ' . ' email: '. $request->email . ' ip: ' . $request->ip());
                    return view("auth2fa", compact('user'));  
                }else{
                    Log::info('Se inicio sesion como usuario con los siguientes datos: '. ' email: '. $request->email . ' ip: ' . $request->ip()); 
                }  
            return redirect()->intended(route('inicio'));
        }else{
            Log::error('Intento de inicio de sesion con los siguientes datos: '. ' email: '. $request->email . ' ip: ' . $request->ip()); 
            return redirect()->route('login')->with(['error' => 'Datos no validos, vuelve a intentarlo']);
        }

      
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
    if ((new Google2FA())->verifyKey($deencrypt, $request->code_verification)) {
        $request->session()->regenerate();

        Auth::login($user);

        return redirect()->route('inicio');
    }
    return redirect()->back()->withErrors(['error'=> 'Código de verificación incorrecto']);
    }
}
