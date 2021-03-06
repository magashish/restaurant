<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class IsSeller
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(auth()->user()->type != User::SELLER) {
            return redirect()->route('restaurantfront.all')->with('error', 'You are not a Seller');
        }
        return $next($request);
    }
}
