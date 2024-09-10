<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        return Auth::guard('web')->check() ? redirect('/')->with('error', 'You do not have  access!') : response()->json([
            'error' => 'Forbidden',
            'message' => 'You do not have admin access.'
        ], 403);

        //for web view
       // return redirect('/')->with('error', 'You do not have  access!');

    }
}
