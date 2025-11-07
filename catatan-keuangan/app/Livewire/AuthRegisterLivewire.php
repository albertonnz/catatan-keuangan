<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthRegisterLivewire extends Component
{
    public $name;
    public $email;
    public $password;
    public $password_confirmation;

    /**
     * Tampilkan halaman register
     */
    public function render()
    {
        return view('livewire.auth-register-livewire');
    }

    /**
     * Proses register user baru
     */
    public function register()
    {
        $this->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        User::create([
            'name'     => $this->name,
            'email'    => $this->email,
            'password' => Hash::make($this->password)
        ]);

        // Reset setelah daftar
        $this->reset(['name', 'email', 'password', 'password_confirmation']);

        // Redirect ke login
        session()->flash('success', 'Pendaftaran berhasil! Silakan login.');
        return redirect('/auth/login');
    }
}
