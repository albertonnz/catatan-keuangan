<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class HomeLivewire extends Component
{
    public $user;

    public function mount()
    {
        // Pastikan user sudah login
        $this->user = Auth::user();

        if (!$this->user) {
            return redirect('/auth/login');
        }
    }

    public function render()
    {
        return view('livewire.home-livewire', [
            'user' => $this->user
        ]);
    }
}
