<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckDefaultBranch
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated and if the default_branch is not set
        if (Auth::check() && !Auth::user()->default_branch) {
            // Redirect to dashboard if default_branch is not set
            return redirect()->route('dashboard')->with('warning', 'Please Select a Branch!');
        }

        // Allow the request to proceed
        return $next($request);
    }
}
