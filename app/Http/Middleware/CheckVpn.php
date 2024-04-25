<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckVpn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->user()->hasRole('Usuario')){
            $allowedIps= ['10.34.0.20','10.34.0.19','10.34.0.18','10.34.0.17', '10.34.0.16', '10.34.0.15','10.34.0.14','10.34.0.13'];
            $ip = $request->ip();
            if(in_array($ip, $allowedIps)){
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('inicio');
            }
        }
        if($request->user()->hasRole('Administrador')){
            $allowedIps= ['10.34.0.20','10.34.0.19','10.34.0.18','10.34.0.17', '10.34.0.16', '10.34.0.15','10.34.0.14','10.34.0.13'];
            $ip = $request->ip();
            if(!in_array($ip, $allowedIps)){
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('inicio');
            }
        }
        return $next($request);
    }
}
