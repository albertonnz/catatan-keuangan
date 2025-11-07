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
            ->select(DB::raw('extract(year from tanggal) as year'))
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

        // 1. Data untuk Monthly Transactions (Line Chart)
        $pemasukan = Finance::where('user_id', $userId)->where('jenis', 'pemasukan')->where(DB::raw('extract(year from tanggal)'), $this->year)
            ->selectRaw('extract(month from tanggal) as month, SUM(nominal) as total')
            ->groupBy('month')->pluck('total', 'month')->all();

        $pengeluaran = Finance::where('user_id', $userId)->where('jenis', 'pengeluaran')->where(DB::raw('extract(year from tanggal)'), $this->year)
            ->selectRaw('extract(month from tanggal) as month, SUM(nominal) as total')
            ->groupBy('month')->pluck('total', 'month')->all();

        $this->monthlyTransactionsChart['pemasukan'] = array_map(fn($m) => $pemasukan[$m] ?? 0, range(1, 12));
        $this->monthlyTransactionsChart['pengeluaran'] = array_map(fn($m) => $pengeluaran[$m] ?? 0, range(1, 12));

        // 2. Data untuk Category Distribution (Donut Chart)
        $this->categoryDistributionChart['series'] = [
            (float) Finance::where('user_id', $userId)->where('jenis', 'pemasukan')->where(DB::raw('extract(year from tanggal)'), $this->year)->sum('nominal'),
            (float) Finance::where('user_id', $userId)->where('jenis', 'pengeluaran')->where(DB::raw('extract(year from tanggal)'), $this->year)->sum('nominal'),
        ];
        $this->categoryDistributionChart['labels'] = ['Pemasukan', 'Pengeluaran'];
    }

    public function render()
    {
        return view('livewire.statistic-livewire')->layout('components.layouts.app');
    }
}