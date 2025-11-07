<div><!-- ROOT START -->


    <!-- Filter Tahun -->
    <div class="row mb-4">
        <div class="col-md-3">
            <label for="yearFilter" class="form-label">Pilih Tahun:</label>
            <select id="yearFilter" class="form-select" wire:model.live="year">
                @foreach($availableYears as $y)
                    <option value="{{ $y }}">{{ $y }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row">
        <!-- Grafik Transaksi Bulanan -->
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Transaksi Bulanan ({{ $year }})</h5>
                    <div id="monthlyTransactionsChart"></div>
                </div>
            </div>
        </div>

        <!-- Grafik Distribusi Kategori -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Distribusi Pemasukan & Pengeluaran ({{ $year }})</h5>
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
