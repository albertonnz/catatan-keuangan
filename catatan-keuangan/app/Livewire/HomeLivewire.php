<?php

namespace App\Livewire;

use App\Models\Finance;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class HomeLivewire extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $filterJenis = '';

    public $editFinanceId;

    protected $listeners = ['financeUpdated' => 'render'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterJenis()
    {
        $this->resetPage();
    }

    public function prepareEditFinance($id)
    {
        $this->editFinanceId = $id;
        $this->dispatch('finance-edit-prepared', $id);
    }

    public function prepareDeleteFinance($id)
    {
        $this->editFinanceId = $id;
        $this->dispatch('finance-delete-prepared', $id);
    }

    public function render()
    {
        $userId = Auth::id();

        $financesQuery = Finance::where('user_id', $userId);

        // Search
        if ($this->search) {
            $financesQuery->where('judul', 'like', '%' . $this->search . '%');
        }

        // Filter
        if ($this->filterJenis) {
            $financesQuery->where('jenis', $this->filterJenis);
        }

        $finances = $financesQuery->latest('tanggal')->paginate(20);

        // Ringkasan
        $totalPemasukan = Finance::where('user_id', $userId)->where('jenis', 'pemasukan')->sum('nominal');
        $totalPengeluaran = Finance::where('user_id', $userId)->where('jenis', 'pengeluaran')->sum('nominal');

        // Data untuk chart di halaman home (jika diperlukan)
        $chartData = $this->getMonthlyChartData($userId);

        return view('livewire.home-livewire', [
            'finances' => $finances,
            'totalPemasukan' => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran,
            'chartData' => $chartData,
        ]);
    }

    private function getMonthlyChartData($userId)
    {
        $currentYear = date('Y');
        $transactions = Finance::where('user_id', $userId)
            ->whereYear('tanggal', $currentYear)
            ->selectRaw('MONTH(tanggal) as month, jenis, SUM(nominal) as total')
            ->groupBy('month', 'jenis')
            ->get();

        $monthlyTotals = array_fill(1, 12, 0);

        foreach ($transactions as $transaction) {
            if ($transaction->jenis == 'pemasukan') {
                $monthlyTotals[$transaction->month] += $transaction->total;
            } else {
                $monthlyTotals[$transaction->month] -= $transaction->total;
            }
        }

        // Mengembalikan array nilai saja, diurutkan berdasarkan bulan
        return array_values($monthlyTotals);
    }
}