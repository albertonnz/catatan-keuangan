<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Finance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FinanceLivewire extends Component
{
    use WithFileUploads, WithPagination;

    public $search = '';
    public $filterJenis = '';
    public $auth;

    // Form ADD
    public $addJudul, $addNominal, $addJenis, $addTanggal, $addCover;

    // Form EDIT
    public $editFinanceId, $editJudul, $editNominal, $editJenis;

    // Form DELETE
    public $deleteFinanceId, $deleteFinanceTitle, $deleteConfirmTitle;

    public $editCoverFinanceFile;

    public function mount()
    {
        $this->auth = Auth::user();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterJenis()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Finance::where('user_id', Auth::id());

        if ($this->search) {
            $query->where('judul', 'like', '%' . $this->search . '%');
        }

        if ($this->filterJenis) {
            $query->where('jenis', $this->filterJenis);
        }

        $finances = $query->orderBy('tanggal', 'desc')
                          ->paginate(20);

        $totalPemasukan = Finance::where('user_id', Auth::id())
            ->where('jenis', 'pemasukan')
            ->sum('nominal');

        $totalPengeluaran = Finance::where('user_id', Auth::id())
            ->where('jenis', 'pengeluaran')
            ->sum('nominal');

        $totalSaldo = $totalPemasukan - $totalPengeluaran;

        // ✅ DATA GRAFIK PER BULAN
        $chartData = Finance::where('user_id', Auth::id())
            ->selectRaw('EXTRACT(MONTH FROM tanggal) as bulan, SUM(nominal) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        return view('livewire.finance-livewire', [ // Layout akan di-handle oleh Controller
            'finances' => $finances,
            'totalPemasukan' => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran,
            'totalSaldo' => $totalSaldo,
            'chartData' => $chartData,
        ]);
    }

    // ADD
    public function addFinance()
    {
        $this->validate([
            'addJudul' => 'required|string|max:255',
            'addNominal' => 'required|integer',
            'addJenis' => 'required|in:pemasukan,pengeluaran',
            'addTanggal' => 'required|date',
            'addCover' => 'nullable|image|max:2048',
        ]);

        $path = $this->addCover ? $this->addCover->store('finance_covers', 'public') : null;

        Finance::create([
            'user_id' => $this->auth->id,
            'judul' => $this->addJudul,
            'nominal' => $this->addNominal,
            'jenis' => $this->addJenis,
            'tanggal' => $this->addTanggal,
            'cover' => $path,
        ]);

        $this->reset(['addJudul', 'addNominal', 'addJenis', 'addTanggal', 'addCover']);

        $this->dispatch('alertSuccess', message: 'Data berhasil ditambahkan!');
        $this->dispatch('closeModal', id: 'addFinanceModal');
    }

    // PREP EDIT
    public function prepareEditFinance($id)
    {
        $finance = Finance::where('id', $id)
            ->where('user_id', $this->auth->id)
            ->first();

        if (!$finance) return;

        $this->editFinanceId = $finance->id;
        $this->editJudul = $finance->judul;
        $this->editNominal = $finance->nominal;
        $this->editJenis = $finance->jenis;

        $this->dispatch('showModal', id: 'editFinanceModal');
    }

    // EDIT
    public function editFinance()
    {
        $this->validate([
            'editJudul' => 'required|string|max:255',
            'editNominal' => 'required|integer',
            'editJenis' => 'required|in:pemasukan,pengeluaran',
        ]);

        $finance = Finance::find($this->editFinanceId);
        if (!$finance) return;

        $finance->update([
            'judul' => $this->editJudul,
            'nominal' => $this->editNominal,
            'jenis' => $this->editJenis,
        ]);

        $this->reset(['editFinanceId', 'editJudul', 'editNominal', 'editJenis']);
        $this->dispatch('closeModal', id: 'editFinanceModal');
    }

    // PREP DELETE
    public function prepareDeleteFinance($id)
    {
        $finance = Finance::find($id);
        if (!$finance) return;

        $this->deleteFinanceId = $finance->id;
        $this->deleteFinanceTitle = $finance->judul;

        $this->dispatch('showModal', id: 'deleteFinanceModal');
    }

    // DELETE
    public function deleteFinance()
    {
        if ($this->deleteConfirmTitle !== $this->deleteFinanceTitle) {
            $this->addError('deleteConfirmTitle', 'Judul konfirmasi tidak sesuai.');
            return;
        }

        Finance::destroy($this->deleteFinanceId);
        $this->reset(['deleteFinanceId', 'deleteFinanceTitle', 'deleteConfirmTitle']);
        $this->dispatch('closeModal', id: 'deleteFinanceModal');
    }

    // EDIT COVER
    public function editFinanceCover()
    {
        $this->validate([
            'editCoverFinanceFile' => 'required|image|max:2048',
        ]);

        $finance = Finance::find($this->editFinanceId);
        if (!$finance) return;

        if ($finance->cover && Storage::disk('public')->exists($finance->cover)) {
            Storage::disk('public')->delete($finance->cover);
        }

        $path = $this->editCoverFinanceFile->store('finance_covers', 'public');

        $finance->update(['cover' => $path]);

        $this->reset(['editCoverFinanceFile']);
        $this->dispatch('closeModal', id: 'editFinanceCoverModal');
    }
}
