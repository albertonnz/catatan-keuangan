<div wire:ignore.self class="modal fade" id="editFinanceCoverModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- HEADER -->
            <div class="modal-header">
                <h5 class="modal-title">Ubah Cover / Bukti Foto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body">

                @if (isset($finance) && $finance->cover)
                    <div class="mb-3 text-center">
                        <p>Cover Saat Ini:</p>
                        <img src="{{ asset('storage/' . $finance->cover) }}"
                             class="img-fluid rounded border" style="max-height:200px;">
                    </div>
                @endif

                <label class="mt-2">Pilih Cover Baru</label>
                <input type="file" class="form-control" wire:model="editCoverFinanceFile" accept="image/*">

                @error('editCoverFinanceFile')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

                @if ($editCoverFinanceFile)
                    <div class="mt-3 text-center">
                        <p>Preview Cover Baru:</p>
                        <img src="{{ $editCoverFinanceFile->temporaryUrl() }}"
                             class="img-fluid rounded border" style="max-height:200px;">
                    </div>
                @endif

            </div>

            <!-- FOOTER -->
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-primary" wire:click="editFinanceCover">Simpan</button>
            </div>

        </div>
    </div>
</div>
