<div>

    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="m-0">Detail Catatan Keuangan</h4>
                </div>

                <div class="card-body">

                    <!-- Judul -->
                    <div class="mb-3">
                        <h3 class="fw-bold">{{ $finance->judul }}</h3>
                    </div>

                    <!-- Jenis -->
                    <div class="mb-3">
                        <span class="badge 
                            @if($finance->jenis == 'pemasukan') bg-success 
                            @else bg-danger @endif
                        ">
                            {{ ucfirst($finance->jenis) }}
                        </span>
                    </div>

                    <!-- Nominal -->
                    <div class="mb-3">
                        <h4 class="fw-semibold">Rp {{ number_format($finance->nominal, 0, ',', '.') }}</h4>
                    </div>

                    <!-- Tanggal -->
                    <div class="mb-3 text-muted">
                        Tanggal: {{ \Carbon\Carbon::parse($tanggal)->format('d M Y') }}
                    </div>

                    <!-- Cover / Bukti Foto -->
                    @if ($finance->cover)
                        <div class="text-center my-4">
                            <img src="{{ asset('storage/' . $finance->cover) }}" 
                                 class="img-fluid rounded border" 
                                 style="max-height: 350px;">
                            <button class="btn btn-warning btn-sm mt-2" 
                                    data-bs-toggle="modal" data-bs-target="#editFinanceCoverModal">
                                Ubah Gambar
                            </button>
                        </div>
                    @else
                        <div class="text-center my-4">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editFinanceCoverModal">
                                + Tambah Gambar
                            </button>
                        </div>
                    @endif

                    <!-- Tombol kembali -->
                    <div class="mt-4">
                        <a href="/app/home" class="btn btn-secondary">Kembali</a>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- Modal Edit Cover -->
    @include('components.modals.finances.edit-cover')

</div>
