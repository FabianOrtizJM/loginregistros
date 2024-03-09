<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifySignedUrl
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->hasValidSignature()) {
            abort(403, 'URL no firmada correctamente.');
        }

        return $next($request);
    }
}
