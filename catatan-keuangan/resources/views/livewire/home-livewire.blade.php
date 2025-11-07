<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Catatan Keuangan</h3>

        <!-- Tombol Tambah -->
        <button class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#addFinanceModal">
            + Tambah Catatan
        </button>
    </div>

    <!-- ✅ RINGKASAN & GRAFIK -->
    <div class="row mb-4">

        <div class="col-md-4">
            <div class="card shadow-sm p-3">
                <h5>Total Pemasukan</h5>
                <h3 class="text-success">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm p-3">
                <h5>Total Pengeluaran</h5>
                <h3 class="text-danger">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h3>
            </div>
        </div>

        <div class="col-md-4"> {{-- Total Saldo --}}
            <div class="card shadow-sm p-3">
                <h5>Total Saldo</h5>
                <h3 class="fw-bold text-primary">Rp {{ number_format($totalPemasukan - $totalPengeluaran, 0, ',', '.') }}</h3>
            </div>
        </div>

    </div>
    <!-- ✅ END RINGKASAN -->

    <!-- Filter Tahun untuk Statistik -->
    <div class="row mb-4">
        <div class="col-md-3">
            <label for="yearFilter" class="form-label">Pilih Tahun Statistik:</label>
            <select id="yearFilter" class="form-select" wire:model.live="year">
                @foreach($availableYears as $y)
                    <option value="{{ $y }}">{{ $y }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Grafik Statistik -->
    <div class="row mb-4">
        <!-- Grafik Transaksi Bulanan -->
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Transaksi Bulanan ({{ $year }})</h5>
                    <div id="monthlyTransactionsChart"></div>
                </div>
            </div>
        </div>

    </div>
    <!-- ✅ END RINGKASAN & GRAFIK -->

    <div class="card shadow-sm">
        <div class="card-body">

            <!-- ✅ Search & Filter -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <input type="text" wire:model.live="search" class="form-control" placeholder="Cari judul...">
                </div>

                <div class="col-md-4">
                    <select wire:model.live="filterJenis" class="form-control">
                        <option value="">Semua Jenis</option>
                        <option value="pemasukan">Pemasukan</option>
                        <option value="pengeluaran">Pengeluaran</option>
                    </select>
                </div>
            </div>
            <!-- ✅ END -->

            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Judul</th>
                        <th>Jenis</th>
                        <th>Nominal</th>
                        <th>Tanggal</th>
                        <th style="width: 160px;">Tindakan</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($finances as $finance)
                        <tr>
                            <td>{{ $finance->judul }}</td>

                            <td>
                                @if ($finance->jenis == 'pemasukan')
                                    <span class="badge bg-success">Pemasukan</span>
                                @else
                                    <span class="badge bg-danger">Pengeluaran</span>
                                @endif
                            </td>

                            <td>
                                Rp {{ number_format($finance->nominal, 0, ',', '.') }}
                            </td>

                            <td>{{ $finance->created_at->format('d M Y') }}</td>

                            <td>
                                <button class="btn btn-warning btn-sm"
                                        wire:click="prepareEditFinance({{ $finance->id }})"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editFinanceModal">
                                    Edit
                                </button>

                                <button class="btn btn-danger btn-sm"
                                        wire:click="prepareDeleteFinance({{ $finance->id }})"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteFinanceModal">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-3">
                                Belum ada catatan keuangan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

            <!-- ✅ PAGINATION -->
            <div class="mt-3">
                {{ $finances->links() }}
            </div>
            <!-- ✅ END PAGINATION -->

        </div>
    </div>

</div>

<!-- ✅ MASUKKAN SCRIPT DI SINI (setelah card) -->
<script>
document.addEventListener('livewire:init', () => {
    const chart = new ApexCharts(document.querySelector("#chart"), {
        chart: { type: 'line' },
        series: [{
            name: 'Total',
            data: @json($chartData)
        }],
        xaxis: {
            categories: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des']
        }
    });
    chart.render();
});
</script>
