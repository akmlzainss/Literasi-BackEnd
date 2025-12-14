<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form id="confirmForm">
                @csrf
                <input type="hidden" id="confirmId" name="id">
                <input type="hidden" id="confirmType" name="type">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Pemenang</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0">Yakin ingin memilih ini sebagai pemenang bulan ini? Form akan otomatis terisi.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Ya, Pilih!</button>
                </div>
            </form>
        </div>
    </div>
</div>