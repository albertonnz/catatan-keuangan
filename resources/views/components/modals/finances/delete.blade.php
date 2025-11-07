<div wire:ignore.self class="modal fade" id="deleteFinanceModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- HEADER -->
            <div class="modal-header">
                <h5 class="modal-title">Hapus Catatan Keuangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body">

                <p>Apakah kamu yakin ingin menghapus catatan:</p>
                <h5 class="text-danger">{{ $deleteFinanceTitle }}</h5>

                <p class="mt-3">Masukkan kembali judul <strong>{{ $deleteFinanceTitle }}</strong> untuk konfirmasi:</p>

                <input type="text" class="form-control" placeholder="Ketik ulang judul disini"
                       wire:model.defer="deleteConfirmTitle">

                @error('deleteConfirmTitle')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

            </div>

            <!-- FOOTER -->
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-danger" wire:click="deleteFinance">Hapus</button>
            </div>

        </div>
    </div>
</div>
