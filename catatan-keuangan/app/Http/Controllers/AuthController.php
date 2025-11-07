<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function login()
    {
        return view('pages.auth.login');
    }

    /**
     * Proses login user
     */
    public function loginProcess(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect('/app/home');
        }

        return back()->with('error', 'Email atau password salah.');
    }

    /**
     * Tampilkan halaman register
     */
    public function register()
    {
        return view('pages.auth.register');
    }

    /**
     * Proses register user baru
     */
    public function registerProcess(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return redirect('/auth/login')->with('success', 'Pendaftaran berhasil! Silakan login.');
    }

    /**
     * Logout user
     */
    public function logout()
    {
        Auth::logout();
        return redirect('/auth/login');
    }
}
