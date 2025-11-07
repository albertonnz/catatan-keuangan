<div wire:ignore.self class="modal fade" id="editFinanceModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- HEADER -->
            <div class="modal-header">
                <h5 class="modal-title">Edit Catatan Keuangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body">

                <label>Judul</label>
                <input type="text" class="form-control mb-2" wire:model.defer="editJudul">

                <label>Jenis</label>
                <select class="form-control mb-2" wire:model.defer="editJenis">
                    <option value="pemasukan">Pemasukan</option>
                    <option value="pengeluaran">Pengeluaran</option>
                </select>

                <label>Nominal</label>
                <input type="number" class="form-control mb-2" wire:model.defer="editNominal">

                <label>Tanggal</label>
                <input type="date" class="form-control mb-2" wire:model.defer="editTanggal">

            </div>

            <!-- FOOTER -->
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button class="btn btn-warning" wire:click="editFinance">Update</button>
            </div>

        </div>
    </div>
</div>
