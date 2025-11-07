<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AuthLoginLivewire extends Component
{
    public $email;
    public $password;

    /**
     * Tampilkan halaman login
     */
    public function render()
    {
        return view('livewire.auth-login-livewire');
    }

    /**
     * Proses login
     */
    public function login()
    {
        // Validasi input
        $this->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        // Cek kredensial
        if (Auth::attempt([
            'email'    => $this->email,
            'password' => $this->password
        ])) {
            session()->regenerate();

            // Redirect jika berhasil
            return redirect('/app/home');
        }

        // Jika gagal
        $this->addError('email', 'Email atau password salah.');
    }
}
