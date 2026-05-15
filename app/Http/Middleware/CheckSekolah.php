<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSekolah
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = null;
        $idSekolah = null;

        // Get current user and their sekolah ID
        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();
            $idSekolah = $user->id_sekolah;
        } elseif (Auth::guard('guru')->check()) {
            $user = Auth::guard('guru')->user();
            $idSekolah = $user->kode_sekolah;
        } elseif (Auth::guard('siswa')->check()) {
            $user = Auth::guard('siswa')->user();
            $idSekolah = $user->kode_sekolah;
        }

        // Share id_sekolah with all views
        if ($idSekolah) {
            view()->share('id_sekolah', $idSekolah);
        }

        return $next($request);
    }
}
