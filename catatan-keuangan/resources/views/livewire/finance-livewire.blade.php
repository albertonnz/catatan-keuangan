<div>

    <!-- Header + Tombol Tambah -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Catatan Keuangan</h4>
        <div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFinanceModal">
                + Tambah Catatan
            </button>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="row mb-4">
        <div class="col-md-6">
            <input type="text" class="form-control" placeholder="Cari judul..." wire:model="search">
        </div>
        <div class="col-md-4">
            <select class="form-control" wire:model="filterJenis">
                <option value="">Semua Jenis</option>
                <option value="pemasukan">Pemasukan</option>
                <option value="pengeluaran">Pengeluaran</option>
            </select>
        </div>
    </div>

    <!-- Statistik -->
    <div class="row mb-4 text-center">
        <div class="col-md-6">
            <div class="p-3 border rounded bg-light">
                <h5 class="text-success">Total Pemasukan</h5>
                <h3 class="fw-bold text-success">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h3>
            </div>
        </div>
        <div class="col-md-6">
            <div class="p-3 border rounded bg-light">
                <h5 class="text-danger">Total Pengeluaran</h5>
                <h3 class="fw-bold text-danger">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    
    <div class="p-3 border rounded bg-light">
        <h5 class="text-primary">Total Saldo</h5>
        <h3 class="fw-bold text-primary">Rp {{ number_format($totalSaldo, 0, ',', '.') }}</h3>
    </div>
</div>



    <!-- Grafik -->
    <div class="mb-4">
        <h5 class="fw-bold text-center">Grafik Keuangan Bulanan</h5>
        <div id="chart"></div>
    </div>

    <script>
document.addEventListener("livewire:navigated", () => {
    var chart = new ApexCharts(document.querySelector("#chart"), {
        chart: { type: "area", height: 300, animations: { enabled: true } },
        colors: ["#4e73df"],
        dataLabels: { enabled: false },
        stroke: { curve: "smooth", width: 3 },
        series: [{
            name: "Total Transaksi",
            data: @json($chartData)
        }],
        xaxis: { 
            categories: ["Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des"]
        },
        tooltip: { theme: "dark" }
    });
    chart.render();
});
</script>

    <!-- TABEL DATA -->
    <table class="table table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>Judul</th>
                <th>Jenis</th>
                <th>Nominal</th>
                <th>Tanggal</th>
                <th style="width:140px;">Tindakan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($finances as $finance)
            <tr>
                <td>{{ $finance->judul }}</td>
                <td class="text-capitalize">{{ $finance->jenis }}</td>
                <td>Rp {{ number_format($finance->nominal, 0, ',', '.') }}</td>
                <td>{{ \Carbon\Carbon::parse($finance->tanggal)->format('d M Y') }}</td>
                <td>
                <a href="/app/finance/{{ $finance->id }}" class="btn btn-info btn-sm">Detail</a>
                <button class="btn btn-warning btn-sm" wire:click="prepareEditFinance({{ $finance->id }})" data-bs-toggle="modal" data-bs-target="#editFinanceModal">Edit</button>
                <button class="btn btn-danger btn-sm" wire:click="prepareDeleteFinance({{ $finance->id }})" data-bs-toggle="modal" data-bs-target="#deleteFinanceModal">Hapus</button>
                </td>

            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Belum ada data.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $finances->links() }}

    <!-- ✅ Modal Add / Edit / Delete / Edit Cover -->
    @include('components.modals.finances.add')
    @include('components.modals.finances.edit')
    @include('components.modals.finances.delete')
    @include('components.modals.finances.edit-cover')

</div>
