<!-- Modal Import -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content border-0 shadow-lg rounded-3">
      
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="importModalLabel">
          <i class="fas fa-file-import me-2"></i> Import Data Siswa
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="{{ route('admin.siswa.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">

          <!-- Dropzone -->
          <div class="file-drop-area text-center p-4 border border-2 border-dashed rounded-3 bg-light" id="drop-area">
            <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-3"></i>
            <p class="mb-1 fw-bold">Drag & Drop file CSV ke sini</p>
            <p class="text-muted small">atau</p>
            <label class="btn btn-outline-primary mt-2">
              <i class="fas fa-folder-open"></i> Pilih File
              <input type="file" name="file" id="file" class="d-none" accept=".csv" required>
            </label>
            <div id="file-info" class="mt-3 text-secondary small fst-italic">Belum ada file dipilih...</div>
          </div>

          <div class="mt-3">
            <small class="text-muted">
              Format file harus: <code>NIS, Nama Lengkap, Email, Password, Kelas</code>
            </small>
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">
            <i class="fas fa-times"></i> Batal
          </button>
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-upload"></i> Import
          </button>
        </div>
      </form>

    </div>
  </div>
</div>

<!-- Script untuk drag & drop + preview -->
<script>
const fileInput = document.getElementById('file');
const fileInfo = document.getElementById('file-info');
const dropArea = document.getElementById('drop-area');

// klik label → buka file explorer
fileInput.addEventListener('change', function() {
  const fileName = this.files[0] ? this.files[0].name : "Belum ada file dipilih...";
  fileInfo.textContent = fileName;
});

// drag over
dropArea.addEventListener('dragover', (e) => {
  e.preventDefault();
  dropArea.classList.add('bg-white', 'border-primary');
});

// drag leave
dropArea.addEventListener('dragleave', () => {
  dropArea.classList.remove('bg-white', 'border-primary');
});

// drop file
dropArea.addEventListener('drop', (e) => {
  e.preventDefault();
  fileInput.files = e.dataTransfer.files;
  const fileName = fileInput.files[0] ? fileInput.files[0].name : "Belum ada file dipilih...";
  fileInfo.textContent = fileName;
  dropArea.classList.remove('bg-white', 'border-primary');
});
</script>

<style>
.file-drop-area {
  cursor: pointer;
  transition: all 0.3s ease;
}
.file-drop-area:hover {
  background: #f8f9fa;
  border-color: #0d6efd;
}
</style>
