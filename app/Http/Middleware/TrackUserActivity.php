<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\UserSession;

class TrackUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
        UserSession::where('user_id', auth()->id())
            ->whereNull('logout_at')
            ->latest()
            ->first()
            ?->update([
                'last_activity_at' => now()
            ]);
    }

    return $next($request);
    }
}
