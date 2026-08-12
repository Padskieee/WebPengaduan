@extends('layouts.admin')

@section('title', 'Edit Kategori')

@push('styles')
<style>
    .page-header {
        background: linear-gradient(135deg, #1B5E20, #2E7D32);
        border-radius: 16px;
        padding: 1.2rem 1.5rem;
        color: white;
        margin-bottom: 1.5rem;
        position: relative;
        overflow: hidden;
    }
    .page-header::after {
        content: '';
        position: absolute;
        right: -30px; bottom: -30px;
        width: 150px; height: 150px;
        background: rgba(255,255,255,0.06);
        border-radius: 50%;
    }
    .page-header h6 { font-weight: 700; font-size: 1rem; margin: 0; position: relative; z-index: 1; }
    .page-header p  { font-size: 0.8rem; opacity: 0.8; margin: 0; position: relative; z-index: 1; }

    .form-card {
        background: white;
        border-radius: 14px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        padding: 1.75rem;
        max-width: 640px;
    }

    .info-bar {
        background: #F3F8FF;
        border: 1px solid #BBDEFB;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        margin-bottom: 1.5rem;
        font-size: 0.82rem;
        color: #1565C0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #424242;
        margin-bottom: 0.4rem;
    }

    .form-control {
        border: 1.5px solid #e0e0e0;
        border-radius: 9px;
        font-size: 0.875rem;
        padding: 0.55rem 0.85rem;
        transition: border-color 0.15s, box-shadow 0.15s;
    }
    .form-control:focus {
        border-color: #2E7D32;
        box-shadow: 0 0 0 3px rgba(46,125,50,0.1);
        outline: none;
    }
    .form-control.is-invalid { border-color: #B71C1C; }
    .invalid-feedback { font-size: 0.78rem; }

    textarea.form-control { resize: vertical; min-height: 100px; }

    .char-count {
        font-size: 0.75rem;
        color: #9e9e9e;
        text-align: right;
        margin-top: 4px;
    }

    .divider { border: none; border-top: 1px solid #f0f0f0; margin: 1.4rem 0; }

    .btn-simpan {
        background: #2E7D32;
        color: white;
        border: none;
        border-radius: 9px;
        padding: 0.55rem 1.4rem;
        font-size: 0.875rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        transition: background 0.15s;
    }
    .btn-simpan:hover { background: #1B5E20; color: white; }

    .btn-batal {
        background: #f5f5f5;
        color: #616161;
        border: none;
        border-radius: 9px;
        padding: 0.55rem 1.2rem;
        font-size: 0.875rem;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        transition: background 0.15s;
    }
    .btn-batal:hover { background: #eeeeee; color: #424242; }
</style>
@endpush

@section('content')

{{-- PAGE HEADER --}}
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h6><i class="fas fa-pen me-2"></i>Edit Kategori Laporan</h6>
            <p>Perbarui informasi kategori laporan</p>
        </div>
        <a href="{{ route('admin.kategori.index') }}"
           style="color:rgba(255,255,255,0.8);font-size:0.82rem;text-decoration:none;position:relative;z-index:1;">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<div class="form-card">

    {{-- INFO BAR --}}
    <div class="info-bar">
        <i class="fas fa-info-circle"></i>
        Kategori ini digunakan oleh
        <strong>{{ $kategori->laporan()->count() }} laporan</strong>.
        Perubahan nama akan langsung berlaku di semua laporan terkait.
    </div>

    <form action="{{ route('admin.kategori.update', $kategori->id_kategori) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- NAMA KATEGORI --}}
        <div class="mb-4">
            <label class="form-label">
                Nama Kategori <span class="text-danger">*</span>
            </label>
            <input type="text"
                   name="nama_kategori"
                   class="form-control @error('nama_kategori') is-invalid @enderror"
                   placeholder="Contoh: Infrastruktur, Pendidikan, Kesehatan..."
                   value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                   maxlength="100"
                   id="namaInput"
                   autocomplete="off">
            <div class="char-count"><span id="namaCount">0</span>/100</div>
            @error('nama_kategori')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        {{-- DESKRIPSI --}}
        <div class="mb-4">
            <label class="form-label">Deskripsi <span class="text-muted fw-normal">(opsional)</span></label>
            <textarea name="deskripsi"
                      class="form-control @error('deskripsi') is-invalid @enderror"
                      placeholder="Jelaskan jenis laporan apa saja yang termasuk kategori ini..."
                      maxlength="500"
                      id="deskripsiInput">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
            <div class="char-count"><span id="deskripsiCount">0</span>/500</div>
            @error('deskripsi')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <hr class="divider">

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn-simpan">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
            <a href="{{ route('admin.kategori.index') }}" class="btn-batal">
                <i class="fas fa-times"></i> Batal
            </a>
        </div>
    </form>
</div>

@endsection

@section('scripts')
<script>
    const namaInput      = document.getElementById('namaInput');
    const deskripsiInput = document.getElementById('deskripsiInput');
    const namaCount      = document.getElementById('namaCount');
    const deskripsiCount = document.getElementById('deskripsiCount');

    function updateCount(input, counter) {
        counter.textContent = input.value.length;
    }

    namaInput.addEventListener('input', () => updateCount(namaInput, namaCount));
    deskripsiInput.addEventListener('input', () => updateCount(deskripsiInput, deskripsiCount));

    updateCount(namaInput, namaCount);
    updateCount(deskripsiInput, deskripsiCount);
</script>
@endsection
