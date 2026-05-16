<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        
        if (Auth::guard('siswa')->check()) {
            return redirect()->route('siswa.dashboard');
        }
        
        if (Auth::guard('guru')->check()) {
            return redirect()->route('guru.dashboard');
        }
        
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        // Try to authenticate with admin guard first
        if (Auth::guard('admin')->attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            return redirect()->intended('/admin/dashboard')
                ->with('success', 'Login berhasil! Selamat datang Admin.');
        }
        
        // Try to authenticate with guru guard using email
        if (Auth::guard('guru')->attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            return redirect()->intended('/guru/dashboard')
                ->with('success', 'Login berhasil! Selamat datang ' . Auth::guard('guru')->user()->nama_guru);
        }

        if (Auth::guard('guru')->attempt(['username' => $credentials['username'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            return redirect()->intended('/guru/dashboard')
                ->with('success', 'Login berhasil! Selamat datang ' . Auth::guard('guru')->user()->nama_guru);
        }
        
        // Try to authenticate with siswa guard using username
        if (Auth::guard('siswa')->attempt(['username' => $credentials['email'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            return redirect()->intended(route('siswa.dashboard'))
                ->with('success', 'Login berhasil! Selamat datang ' . Auth::guard('siswa')->user()->nama_siswa);
        }
        
        // Try to authenticate with siswa guard using email
        if (Auth::guard('siswa')->attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            return redirect()->intended(route('siswa.dashboard'))
                ->with('success', 'Login berhasil! Selamat datang ' . Auth::guard('siswa')->user()->nama_siswa);
        }

        // If all attempts fail, return error
        return back()->withErrors([
            'login' => 'Email/Username atau password salah.',
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        // Try to logout from all possible guards
        Auth::guard('admin')->logout();
        Auth::guard('guru')->logout();
        Auth::guard('siswa')->logout();
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')
            ->with('success', 'Anda telah logout.');
    }
}
