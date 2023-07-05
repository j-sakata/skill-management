<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Type\AuthorityType;
use Illuminate\Support\Facades\Log;

class AuthAuthority
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
        $authority = Auth::user()->authority;
        if($authority !== AuthorityType::Admin->name){
          Log::error("Authority Error: $authority");
          return redirect('/');
        }
        return $next($request);
    }
}