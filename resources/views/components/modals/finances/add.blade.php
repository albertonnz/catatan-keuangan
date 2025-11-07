<div wire:ignore.self class="modal fade" id="addFinanceModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- HEADER -->
            <div class="modal-header">
                <h5 class="modal-title">Tambah Catatan Keuangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body">

                <!-- JUDUL -->
                <label class="mt-2">Judul</label>
                <input type="text" class="form-control mb-2" wire:model.defer="addJudul">

                <!-- JENIS -->
                <label class="mt-2">Jenis</label>
                <select class="form-control mb-2" wire:model.defer="addJenis">
                    <option value="">Pilih Jenis</option>
                    <option value="pemasukan">Pemasukan</option>
                    <option value="pengeluaran">Pengeluaran</option>
                </select>

                <!-- NOMINAL -->
                <label class="mt-2">Nominal</label>
                <input type="number" class="form-control mb-2" wire:model.defer="addNominal">

                <!-- TANGGAL -->
                <label class="mt-2">Tanggal</label>
                <input type="date" class="form-control mb-2" wire:model.defer="addTanggal">

                <!-- UPLOAD GAMBAR -->
                <label class="mt-2">Upload Gambar (Opsional)</label>
                <input type="file" class="form-control" wire:model="addCover" accept="image/*">

                @error('addCover')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

            </div>

            <!-- FOOTER -->
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button class="btn btn-primary" wire:click="addFinance">Simpan</button>
            </div>

        </div>
    </div>
</div>
