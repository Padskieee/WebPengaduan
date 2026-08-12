@extends('layouts.admin')

@section('title', 'Buat Hasil Penyelesaian')

@section('styles')
<style>
    .form-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        overflow: hidden;
        margin-bottom: 1.2rem;
    }

    .form-card-header {
        background: linear-gradient(135deg, #1B5E20, #2E7D32);
        padding: 1.2rem 1.5rem;
        color: white;
        display: flex;
        align-items: center;
        gap: 10px;
        position: relative;
        overflow: hidden;
    }

    .form-card-header::after {
        content: '';
        position: absolute;
        right: -30px;
        bottom: -30px;
        width: 120px;
        height: 120px;
        background: rgba(255,255,255,0.06);
        border-radius: 50%;
    }

    .form-card-header h6 {
        font-weight: 700;
        font-size: 1rem;
        margin: 0;
        position: relative;
        z-index: 1;
    }

    .form-card-body { padding: 1.5rem; }

    .form-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #424242;
        margin-bottom: 0.4rem;
    }

    .form-label .required { color: #F44336; margin-left: 2px; }

    .form-control, .form-select {
        border: 1.5px solid #e0e0e0;
        border-radius: 8px;
        padding: 0.65rem 1rem;
        font-size: 0.9rem;
        transition: all 0.2s;
    }

    .form-control:focus, .form-select:focus {
        border-color: #2E7D32;
        box-shadow: 0 0 0 3px rgba(46,125,50,0.12);
    }

    textarea.form-control { resize: vertical; min-height: 150px; }

    /* SECTION DIVIDER */
    .section-divider {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin: 1.25rem 0 1rem;
    }

    .section-divider span {
        font-size: 0.78rem;
        font-weight: 700;
        color: #2E7D32;
        text-transform: uppercase;
        letter-spacing: 1px;
        white-space: nowrap;
    }

    .section-divider::before,
    .section-divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #e0e0e0;
    }

    /* PUBLISH TOGGLE */
    .publish-card {
        background: #f9fbe7;
        border: 1.5px solid #c8e6c9;
        border-radius: 10px;
        padding: 1rem 1.2rem;
    }

    .publish-card h6 {
        font-size: 0.88rem;
        font-weight: 700;
        color: #1B5E20;
        margin-bottom: 0.75rem;
    }

    .publish-options {
        display: flex;
        gap: 0.75rem;
    }

    .publish-option {
        flex: 1;
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 0.75rem 1rem;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 0.85rem;
        background: white;
    }

    .publish-option:has(input:checked) {
        border-color: #2E7D32;
        background: #E8F5E9;
    }

    .publish-option input { display: none; }

    /* UPLOAD LAMPIRAN */
    .lampiran-container { }

    .lampiran-row {
        background: #f9f9f9;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 0.75rem;
        border: 1.5px solid #e0e0e0;
    }

    .btn-add-lampiran {
        background: #E8F5E9;
        color: #1B5E20;
        border: 2px dashed #81C784;
        border-radius: 8px;
        padding: 0.65rem;
        font-size: 0.85rem;
        font-weight: 600;
        width: 100%;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-add-lampiran:hover {
        background: #c8e6c9;
        border-color: #2E7D32;
    }

    .btn-remove {
        background: #FFEBEE;
        color: #B71C1C;
        border: none;
        border-radius: 6px;
        padding: 0.3rem 0.7rem;
        font-size: 0.78rem;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-remove:hover { background: #B71C1C; color: white; }

    /* LAPORAN INFO */
    .laporan-info-box {
        background: #E8F5E9;
        border-radius: 10px;
        padding: 1rem 1.2rem;
        margin-bottom: 1.5rem;
        border-left: 4px solid #2E7D32;
    }

    .laporan-info-box h6 {
        font-size: 0.85rem;
        font-weight: 700;
        color: #1B5E20;
        margin-bottom: 0.5rem;
    }

    .laporan-info-box p {
        font-size: 0.8rem;
        color: #424242;
        margin: 0;
    }

    /* BUTTONS */
    .btn-submit {
        background: linear-gradient(135deg, #1B5E20, #2E7D32);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.2s;
    }

    .btn-submit:hover {
        background: linear-gradient(135deg, #2E7D32, #4CAF50);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(27,94,32,0.3);
    }

    .btn-cancel {
        background: white;
        color: #757575;
        border: 1.5px solid #e0e0e0;
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        font-size: 0.95rem;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-cancel:hover { background: #f5f5f5; color: #424242; }
</style>
@endsection

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-9">

        {{-- BACK --}}
        <div class="d-flex align-items-center gap-2 mb-3">
            <a href="{{ route('admin.laporan.show', $laporan->id_laporan) }}"
               class="text-muted text-decoration-none">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h6 class="fw-bold mb-0" style="color:#1B5E20;">
                Buat Hasil Penyelesaian
            </h6>
        </div>

        {{-- INFO LAPORAN --}}
        <div class="laporan-info-box">
            <h6><i class="fas fa-file-alt me-2"></i>Laporan yang Diselesaikan</h6>
            <p><strong>{{ $laporan->judul_laporan }}</strong></p>
            <p class="mt-1">
                <i class="fas fa-tag me-1"></i>{{ $laporan->kategori->nama_kategori ?? '-' }}
                &nbsp;•&nbsp;
                <i class="fas fa-user me-1"></i>
                {{ $laporan->anonim ? 'Anonim' : ($laporan->user->nama ?? '-') }}
                &nbsp;•&nbsp;
                <i class="fas fa-calendar me-1"></i>
                {{ \Carbon\Carbon::parse($laporan->created_at)->locale('id')->isoFormat('D MMM Y') }}
            </p>
        </div>

        {{-- FORM --}}
        <form action="{{ route('admin.hasil.store', $laporan->id_laporan) }}"
              method="POST" enctype="multipart/form-data">
            @csrf

            {{-- HASIL PENYELESAIAN --}}
            <div class="form-card">
                <div class="form-card-header">
                    <i class="fas fa-check-circle fa-lg"></i>
                    <h6>Informasi Hasil Penyelesaian</h6>
                </div>
                <div class="form-card-body">

                    @if($errors->any())
                        <div class="alert alert-danger py-2 px-3 rounded-3 mb-3">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <strong>Terdapat kesalahan:</strong>
                            <ul class="mb-0 mt-1 ps-3">
                                @foreach($errors->all() as $error)
                                    <li class="small">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">
                            Judul Hasil <span class="required">*</span>
                        </label>
                        <input type="text" name="judul_output"
                            class="form-control @error('judul_output') is-invalid @enderror"
                            placeholder="Contoh: Penanganan Jalan Rusak di Jl. Sisingamangaraja"
                            value="{{ old('judul_output') }}" required>
                        @error('judul_output')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Deskripsi Hasil <span class="required">*</span>
                        </label>
                        <textarea name="deskripsi_output"
                            class="form-control @error('deskripsi_output') is-invalid @enderror"
                            placeholder="Jelaskan secara detail tindakan yang telah dilakukan untuk menyelesaikan laporan ini..."
                            required>{{ old('deskripsi_output') }}</textarea>
                        @error('deskripsi_output')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- LAMPIRAN --}}
                    <div class="section-divider">
                        <span><i class="fas fa-images me-1"></i>Lampiran Hasil</span>
                    </div>

                    <div class="lampiran-container" id="lampiranContainer">
                        <div class="lampiran-row" id="lampiran-0">
                            <div class="row g-2 align-items-end">
                                <div class="col-md-6">
                                    <label class="form-label">File</label>
                                    <input type="file" name="lampiran[]"
                                        class="form-control"
                                        accept=".jpg,.jpeg,.png,.pdf,.mp4">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Jenis</label>
                                    <select name="jenis_lampiran[]" class="form-select">
                                        <option value="sebelum">Foto Sebelum</option>
                                        <option value="sesudah">Foto Sesudah</option>
                                        <option value="lainnya">Lainnya</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn-remove w-100"
                                        onclick="removeLampiran(0)" style="display:none;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn-add-lampiran mt-2"
                        onclick="addLampiran()">
                        <i class="fas fa-plus me-2"></i>Tambah Lampiran
                    </button>

                    {{-- PUBLISH --}}
                    <div class="section-divider">
                        <span><i class="fas fa-globe me-1"></i>Status Publikasi</span>
                    </div>

                    <div class="publish-card">
                        <h6><i class="fas fa-eye me-1"></i>Pilih Status Publikasi</h6>
                        <div class="publish-options">
                            <label class="publish-option">
                                <input type="radio" name="status_publish"
                                    value="draft" checked>
                                <i class="fas fa-file-alt" style="color:#757575;"></i>
                                <div>
                                    <div class="fw-600">Simpan Draft</div>
                                    <div class="text-muted" style="font-size:0.75rem;">
                                        Belum dipublikasikan
                                    </div>
                                </div>
                            </label>
                            <label class="publish-option">
                                <input type="radio" name="status_publish" value="publish">
                                <i class="fas fa-globe" style="color:#1B5E20;"></i>
                                <div>
                                    <div class="fw-600">Publikasikan</div>
                                    <div class="text-muted" style="font-size:0.75rem;">
                                        Tampil di feed publik
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                </div>
            </div>

            {{-- TOMBOL --}}
            <div class="d-flex gap-3 justify-content-end">
                <a href="{{ route('admin.laporan.show', $laporan->id_laporan) }}"
                   class="btn-cancel">
                    <i class="fas fa-times me-1"></i>Batal
                </a>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save me-2"></i>Simpan Hasil
                </button>
            </div>

        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    let lampiranCount = 1;

    function addLampiran() {
        const container = document.getElementById('lampiranContainer');
        const index     = lampiranCount;

        const row = document.createElement('div');
        row.className = 'lampiran-row';
        row.id = `lampiran-${index}`;
        row.innerHTML = `
            <div class="row g-2 align-items-end">
                <div class="col-md-6">
                    <label class="form-label">File</label>
                    <input type="file" name="lampiran[]"
                        class="form-control"
                        accept=".jpg,.jpeg,.png,.pdf,.mp4">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Jenis</label>
                    <select name="jenis_lampiran[]" class="form-select">
                        <option value="sebelum">Foto Sebelum</option>
                        <option value="sesudah">Foto Sesudah</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn-remove w-100"
                        onclick="removeLampiran(${index})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;

        container.appendChild(row);
        lampiranCount++;
    }

    function removeLampiran(index) {
        const row = document.getElementById(`lampiran-${index}`);
        if (row) row.remove();
    }
</script>
@endsection
