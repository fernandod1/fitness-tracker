<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiBlockIpMiddleware
{    
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {       
        $blockedIps = config("api.blockedIps");
        
        if (in_array($request->ip(), $blockedIps)) {
            return response()->json(['success' => false, 'message' => 'You are restricted to access the API'], 403);
        }
        return $next($request);
    }
}
