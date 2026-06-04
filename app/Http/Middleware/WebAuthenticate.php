<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class WebAuthenticate
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (!session('user_id')) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}