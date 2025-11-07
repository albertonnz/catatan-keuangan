<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Finance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FinanceDetailLivewire extends Component
{
    use WithFileUploads;

    public $financeId;

    public $judul;
    public $jenis;
    public $nominal;
    public $cover;
    public $tanggal;

    public $editCoverFinanceFile;

    public $finance;

public function mount($id)
{
    $this->finance = Finance::where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail();

    $this->judul     = $this->finance->judul;
    $this->jenis     = $this->finance->jenis;
    $this->nominal   = $this->finance->nominal;
    $this->cover     = $this->finance->cover;
    $this->tanggal   = $this->finance->tanggal; // bukan created_at
}

    public function render()
{
    return view('livewire.finance-detail-livewire', [
        'finance' => $this->finance
    ])->layout('components.layouts.app');
}

    public function editFinanceCover()
    {
        $this->validate([
            'editCoverFinanceFile' => 'required|image|max:2048',
        ]);

        if (!$this->finance) return;

        // Hapus gambar lama jika ada
        if ($this->finance->cover && Storage::disk('public')->exists($this->finance->cover)) {
            Storage::disk('public')->delete($this->finance->cover);
        }

        // Simpan gambar baru
        $path = $this->editCoverFinanceFile->store('finance_covers', 'public');

        $this->finance->update(['cover' => $path]);
        $this->finance->refresh(); // Memuat ulang model untuk memastikan data terbaru di view

        // Reset properti dan tutup modal
        $this->cover = $path;
        $this->reset(['editCoverFinanceFile']);
        $this->dispatch('closeModal', id: 'editFinanceCoverModal');
        $this->dispatch('alertSuccess', message: 'Cover berhasil diubah!');
    }
}
