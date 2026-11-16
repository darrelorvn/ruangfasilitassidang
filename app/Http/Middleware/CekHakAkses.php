<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekHakAkses
{
    public function handle(Request $request, Closure $next, string $level = 'login'): Response
    {
        $user = session('auth_user');

        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if ($level === 'admin' && ($user['role'] ?? '') !== 'admin') {
            return redirect()->route('ruang.index')->with('error', 'Akses ditolak! Hanya Admin yang dapat menambah, mengubah, atau menghapus data.');
        }

        return $next($request);
    }
}
