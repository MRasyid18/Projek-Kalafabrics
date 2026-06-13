<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            // LOGIKA BARU: Cek apakah akun Ranger sudah diverifikasi Admin
            if ($user->role === 'ranger' && !$user->is_verified) {
                Auth::logout();
                return back()->withInput($request->only('email'))->withErrors([
                    'email' => 'Akun Ranger Anda sedang dalam tahap tinjauan. Mohon tunggu verifikasi dari Admin.'
                ]);
            }

            $request->session()->regenerate();
            return $this->redirectByRole($user)->with('success', 'Login berhasil!');
        }

        return back()->withInput($request->only('email'))->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan salah.'
        ]);
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role'     => 'required|in:b2c,ranger',
        ]);

        // LOGIKA BARU: Tentukan status verifikasi
        $isVerified = ($request->role === 'ranger') ? false : true;

        $user = User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'role'        => $request->role,
            'is_verified' => $isVerified,
        ]);

        // LOGIKA BARU: Jika Ranger, jangan login otomatis, arahkan ke halaman login dengan pesan sukses
        if (!$isVerified) {
            return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Akun Ranger Anda sedang menunggu verifikasi dari Admin sebelum dapat digunakan.');
        }

        // Jika B2C, login otomatis
        Auth::login($user);
        $request->session()->regenerate();

        return $this->redirectByRole($user)->with('success', 'Akun berhasil dibuat! Selamat datang, ' . $user->name . '.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Anda berhasil keluar.');
    }

    private function redirectByRole(User $user)
    {
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'ranger') {
            return redirect()->route('ranger.dashboard');
        }
        
        return redirect()->route('home');
    }
}