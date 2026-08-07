<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class KepalaDesaOnly
{
    public function handle(Request $request, Closure $next)
    {
        if (session('role') !== 'Kepala Desa') {
            return redirect('/dashboard')->with('error', 'Hanya Kepala Desa yang dapat menyetujui/menolak.');
        }
        return $next($request);
    }
}