<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visitorssignal;

class CountVisitor
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
        $ip = hash('sha512', $request->ip());
        $visitor = Visitorssignal::where('ip', $ip)->first();
        if($visitor == null)
        {
            Visitorssignal::create([
                'count' => 1,
                'ip' => $ip,
                'date' => today(),
            ]);
        }
        
        return $next($request);
    }
}