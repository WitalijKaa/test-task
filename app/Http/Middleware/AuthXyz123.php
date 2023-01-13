<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Closure;

class AuthXyz123
{
    public function handle(Request $request, Closure $next)
    {
        if (!config('app.superSecretToken') || $request->get('token') != config('app.superSecretToken')) {
            return redirect(RouteServiceProvider::HOME);
        }

        return $next($request);
    }
}
