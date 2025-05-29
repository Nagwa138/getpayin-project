<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPostRateLimit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $todayPostsCount = auth()->user()->posts()
            ->whereDate('created_at', today())
            ->count();

        if ($todayPostsCount >= 10) {
            return response()->json([
                'message' => 'You have reached your daily limit of 10 scheduled posts.'
            ], 429); // 429 = Too Many Requests
        }

        return $next($request);
    }
}
