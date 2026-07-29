<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminOnly
{
    public function handle(Request $request, Closure $next)
    {
        if (session('role') !== 'Admin') {
            return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }
        return $next($request);
    }
}