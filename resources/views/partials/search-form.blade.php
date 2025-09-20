<h3 class="fw-bold mb-4 text-center">Pencarian</h3>
<form action="{{ route('dashboard-siswa') }}" method="GET">
    <div class="row g-3">
        <div class="col-12 col-md-6">
            <label class="form-label">Jenjang</label>
            <select class="form-select"><option value="">Semua Jenjang</option></select>
        </div>
        <div class="col-12 col-md-6">
            <label class="form-label">Tema</label>
            <select class="form-select" name="kategori">
                <option value="">Semua Tema</option>
                @if(isset($kategoris))
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->nama }}" {{ request('kategori') == $kategori->nama ? 'selected' : '' }}>
                            {{ $kategori->nama }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="col-12">
            <label class="form-label">Kata Kunci</label>
            <input type="text" name="search" class="form-control" placeholder="Masukkan kata kunci..." value="{{ request('search') }}">
        </div>
        <div class="col-12 mt-4">
            <button type="submit" class="btn btn-dark w-100 fw-bold">CARI</button>
        </div>
    </div>
</form>