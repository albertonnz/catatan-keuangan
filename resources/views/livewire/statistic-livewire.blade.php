<div class="container-fluid py-4 bg-light min-vh-100">
    <!-- Include ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <!-- Header Section -->
    <div class="bg-primary text-white shadow rounded-3 p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <a href="/app/home" class="btn btn-outline-light">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h4 class="fw-bold mb-1">📊 Statistik Keuangan</h4>
                    <p class="mb-0 opacity-75">Analisis keuangan Anda secara detail</p>
                </div>
            </div>
            <!-- Filter Tahun -->
            <div style="width: 200px;">
                <label class="text-white mb-2">Pilih Tahun</label>
                <select class="form-select form-select-lg shadow-sm" wire:model.live="year">
                    @foreach($availableYears as $y)
                        <option value="{{ $y }}">{{ $y }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 bg-success text-white shadow h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-2 opacity-75">Total Pemasukan</h6>
                            <h3 class="mb-0 fw-bold">{{ number_format(array_sum($monthlyTransactionsChart['pemasukan']), 0, ',', '.') }}</h3>
                        </div>
                        <div class="rounded-circle bg-white bg-opacity-25 p-3">
                            <i class="fas fa-arrow-up fa-2x text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 bg-danger text-white shadow h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-2 opacity-75">Total Pengeluaran</h6>
                            <h3 class="mb-0 fw-bold">{{ number_format(array_sum($monthlyTransactionsChart['pengeluaran']), 0, ',', '.') }}</h3>
                        </div>
                        <div class="rounded-circle bg-white bg-opacity-25 p-3">
                            <i class="fas fa-arrow-down fa-2x text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 bg-primary text-white shadow h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-2 opacity-75">Saldo {{ $year }}</h6>
                            <h3 class="mb-0 fw-bold">{{ number_format(array_sum($monthlyTransactionsChart['pemasukan']) - array_sum($monthlyTransactionsChart['pengeluaran']), 0, ',', '.') }}</h3>
                        </div>
                        <div class="rounded-circle bg-white bg-opacity-25 p-3">
                            <i class="fas fa-wallet fa-2x text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Grafik Transaksi Bulanan -->
        <div class="col-md-8">
            <div class="card border-0 shadow">
                <div class="card-header bg-white p-4 border-0">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-chart-line text-primary me-2"></i>
                        Transaksi Bulanan {{ $year }}
                    </h5>
                </div>
                <div class="card-body px-4">
                    <div id="monthlyTransactionsChart"></div>
                </div>
            </div>
        </div>

        <!-- Grafik Distribusi Kategori -->
        <div class="col-md-4">
            <div class="card border-0 shadow">
                <div class="card-header bg-white p-4 border-0">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-chart-pie text-primary me-2"></i>
                        Distribusi Pemasukan & Pengeluaran {{ $year }}
                    </h5>
                </div>
                <div class="card-body px-4">
                    <div id="categoryDistributionChart"></div>
                </div>
            </div>
        </div>
    </div>

</div><!-- ROOT END -->

@script
<script>
    document.addEventListener('livewire:navigated', () => {
        let monthlyChart, categoryChart;

        const renderCharts = (data) => {
            // Monthly Transactions Chart
            const monthlyOptions = {
                series: [{ name: 'Pemasukan', data: data.monthly.pemasukan }, { name: 'Pengeluaran', data: data.monthly.pengeluaran }],
                chart: { type: 'area', height: 350, toolbar: { show: false } },
                colors: ['#28a745', '#dc3545'],
                xaxis: { categories: data.monthly.categories },
                yaxis: { labels: { formatter: (value) => "Rp " + new Intl.NumberFormat('id-ID').format(value) } },
                tooltip: { y: { formatter: (val) => "Rp " + new Intl.NumberFormat('id-ID').format(val) } },
                dataLabels: { enabled: false },
            };
            monthlyChart = new ApexCharts(document.querySelector("#monthlyTransactionsChart"), monthlyOptions);
            monthlyChart.render();

            // Category Distribution Chart
            const categoryOptions = {
                series: data.category.series,
                chart: { type: 'donut', height: 350 },
                labels: data.category.labels,
                colors: ['#28a745', '#dc3545'],
                responsive: [{ breakpoint: 480, options: { chart: { width: 200 }, legend: { position: 'bottom' } } }]
            };
            categoryChart = new ApexCharts(document.querySelector("#categoryDistributionChart"), categoryOptions);
            categoryChart.render();
        }

        renderCharts({ monthly: @json($monthlyTransactionsChart), category: @json($categoryDistributionChart) });

        // Listen for updates from Livewire
        Livewire.on('updateCharts', ({ data }) => {
            if (monthlyChart) {
                monthlyChart.updateSeries([{ data: data.monthly.pemasukan }, { data: data.monthly.pengeluaran }]);
            }
            if (categoryChart) {
                categoryChart.updateSeries(data.category.series);
            }
        });
    });
</script>
@endscript
