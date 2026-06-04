<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class WebEnsureRole
{
    public function handle(Request $request, Closure $next, string $role): mixed
    {
        if (session('user_role') !== $role) {
            return redirect()->route('login')
                ->with('error', 'Akses ditolak.');
        }

        return $next($request);
    }
}