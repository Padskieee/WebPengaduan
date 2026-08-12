<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    public function showLogin()
    {
        return view('user.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();

            if (!Auth::guard('web')->user()->hasVerifiedEmail()) {
                return redirect()->route('user.verification.notice');
            }

            return redirect()->route('user.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.'
        ]);
    }

    public function showRegister()
    {
        return view('user.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'no_hp'    => 'nullable|string|max:20',
            'password' => 'required|min:6|confirmed'
        ]);

        $user = User::create([
            'nama'     => $request->nama,
            'email'    => $request->email,
            'no_hp'    => $request->no_hp,
            'password' => Hash::make($request->password)
        ]);

        event(new Registered($user));

        Auth::guard('web')->login($user);

        return redirect()->route('user.verification.notice');
    }

    public function verificationNotice()
    {
        $user = Auth::guard('web')->user();

        if ($user && $user->hasVerifiedEmail()) {
            return redirect()->route('user.dashboard');
        }

        return view('user.auth.verify-email');
    }

    public function verificationVerify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect()->route('user.dashboard')
            ->with('success', 'Email berhasil diverifikasi! Selamat datang di Ogek Wali.');
    }

    public function verificationResend(Request $request)
    {
        // Gunakan Auth::guard('web') bukan $request->user()
        // karena project ini pakai custom guard 'web', bukan default
        $user = Auth::guard('web')->user();

        if (!$user) {
            return redirect()->route('user.login');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('user.dashboard');
        }

        $user->sendEmailVerificationNotification();

        return back()->with('success', 'Link verifikasi sudah dikirim ulang. Silakan cek inbox atau folder spam.');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('user.login');
    }
}
