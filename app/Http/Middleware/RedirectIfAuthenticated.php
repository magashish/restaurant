<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    // public function handle($request, Closure $next, $guard = null)
    // {
    //     if (Auth::guard($guard)->check()) {
    //         return redirect('/home');
    //     }

    //     return $next($request);
    // }

    // public function handle($request, Closure $next, $guard = null)
    // {
    //     switch ($guard) {
    //         case 'admin':
    //             if (Auth::guard($guard)->check()) {
    //                 return redirect()->route('admin.dashboard');
    //             }
    //         break;
    //         case 'rider':
    //             if (Auth::guard($guard)->check()) {
    //                 return redirect()->route('rider.dashboard');
    //             }
    //         break;

    //         default:
    //             if (Auth::guard($guard)->check()) {
    //                 return redirect()->intended('/home');
    //             }
    //         break;
    //     }

    //     return $next($request);
    // }

    public function handle($request, Closure $next, $guard = null)
    {
        // dd($guard);
        switch ($guard) {
            case 'admin':
                if (Auth::guard($guard)->check()) {
                    return redirect()->route('admin.dashboard');
                }
            break;

            case 'rider':
                if (Auth::guard($guard)->check()) {
                    return redirect()->route('rider.dashboard');
                }
            break;

            default:
                if (Auth::guard($guard)->check()) {
                    return redirect('/home');
                }
            break;
        }

        return $next($request);
    }
}
