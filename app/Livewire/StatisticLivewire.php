<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Finance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatisticLivewire extends Component
{
    public $year;
    public $availableYears = [];

    // Data untuk chart
    public $monthlyTransactionsChart = [
        'pemasukan' => [],
        'pengeluaran' => [],
        'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
    ];

    public $categoryDistributionChart = [
        'series' => [],
        'labels' => [],
    ];

    public function mount()
    {
        $this->availableYears = Finance::where('user_id', Auth::id())
            ->select(DB::raw('EXTRACT(YEAR FROM tanggal) as year'))
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        // Set tahun default ke tahun saat ini atau tahun terakhir yang ada data
        $this->year = date('Y');
        if (!in_array($this->year, $this->availableYears) && !empty($this->availableYears)) {
            $this->year = $this->availableYears[0];
        }

        $this->loadChartData();
    }

    public function updatedYear()
    {
        $this->loadChartData();
        $this->dispatch('updateCharts', data: [
            'monthly' => $this->monthlyTransactionsChart,
            'category' => $this->categoryDistributionChart
        ]);
    }

    public function loadChartData()
    {
        $userId = Auth::id();

        $monthlyTotals = Finance::where('user_id', $userId)
            ->whereYear('tanggal', $this->year)
            ->selectRaw('EXTRACT(MONTH FROM tanggal) as month, jenis, SUM(nominal) as total')
            ->groupBy('month', 'jenis')
            ->get();

        $pemasukan = $monthlyTotals->where('jenis', 'pemasukan')->pluck('total', 'month');
        $pengeluaran = $monthlyTotals->where('jenis', 'pengeluaran')->pluck('total', 'month');

        $this->monthlyTransactionsChart['pemasukan'] = array_map(fn($m) => $pemasukan[$m] ?? 0, range(1, 12));
        $this->monthlyTransactionsChart['pengeluaran'] = array_map(fn($m) => $pengeluaran[$m] ?? 0, range(1, 12));

        // 2. Data untuk Category Distribution (Donut Chart)
        $categoryTotals = $monthlyTotals->groupBy('jenis')->map->sum('total');
        $this->categoryDistributionChart['series'] = [(float)($categoryTotals['pemasukan'] ?? 0), (float)($categoryTotals['pengeluaran'] ?? 0)];
        $this->categoryDistributionChart['labels'] = ['Pemasukan', 'Pengeluaran'];
    }

    public function render()
    {
        return view('livewire.statistic-livewire')
            ->layout('layouts.app');
    }
}