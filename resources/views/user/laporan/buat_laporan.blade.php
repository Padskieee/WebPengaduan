@extends('layouts.user')

@section('title', 'Buat Laporan')

@section('styles')
<style>
    .form-card {
        background: rgba(255,255,255,0.97);
        border-radius: 16px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.12);
        overflow: hidden;
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
        content: '\f303';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        right: -10px;
        bottom: -15px;
        font-size: 5rem;
        color: rgba(255,255,255,0.07);
    }

    .form-card-header h6 {
        font-weight: 700;
        font-size: 1rem;
        margin: 0;
    }

    .form-card-body { padding: 1.5rem; }

    .form-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #424242;
        margin-bottom: 0.4rem;
    }

    .form-label span.required {
        color: #F44336;
        margin-left: 2px;
    }

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

    textarea.form-control { resize: vertical; min-height: 140px; }

    /* UPLOAD AREA */
    .upload-area {
        border: 2px dashed #c8e6c9;
        border-radius: 10px;
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        background: #f9fbe7;
        position: relative;
    }

    .upload-area:hover {
        border-color: #2E7D32;
        background: #f1f8e9;
    }

    .upload-area input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
    }

    .upload-area i {
        font-size: 2rem;
        color: #81C784;
        margin-bottom: 0.5rem;
        display: block;
    }

    .upload-area p {
        font-size: 0.85rem;
        color: #757575;
        margin: 0;
    }

    .upload-area small {
        font-size: 0.75rem;
        color: #9e9e9e;
    }

    /* PREVIEW LAMPIRAN */
    .preview-list {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 0.75rem;
    }

    .preview-item {
        background: #f5f5f5;
        border-radius: 8px;
        padding: 0.4rem 0.75rem;
        font-size: 0.78rem;
        color: #424242;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .preview-item i { color: #2E7D32; }

    /* ANONIM TOGGLE */
    .anonim-card {
        background: #f9fbe7;
        border: 1.5px solid #c8e6c9;
        border-radius: 10px;
        padding: 1rem 1.2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    .anonim-info h6 {
        font-size: 0.9rem;
        font-weight: 600;
        color: #1B5E20;
        margin-bottom: 0.2rem;
    }

    .anonim-info p {
        font-size: 0.78rem;
        color: #757575;
        margin: 0;
    }

    .form-switch .form-check-input {
        width: 3rem;
        height: 1.5rem;
        cursor: pointer;
    }

    .form-check-input:checked {
        background-color: #2E7D32;
        border-color: #2E7D32;
    }

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
        transition: all 0.2s;
    }

    .btn-cancel:hover {
        background: #f5f5f5;
        color: #424242;
    }

    /* STEP INDICATOR */
    .step-indicator {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0;
        margin-bottom: 1.5rem;
    }

    .step {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
    }

    .step-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #e0e0e0;
        color: #9e9e9e;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        font-weight: 700;
        transition: all 0.3s;
    }

    .step.active .step-circle {
        background: #2E7D32;
        color: white;
    }

    .step-label {
        font-size: 0.7rem;
        color: #9e9e9e;
        white-space: nowrap;
    }

    .step.active .step-label { color: #e0e0e0; font-weight: 600; }

    .step-line {
        flex: 1;
        height: 2px;
        background: #e0e0e0;
        margin: 0 4px;
        margin-bottom: 18px;
    }
</style>
@endsection

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">

        {{-- PAGE TITLE --}}
        <div class="d-flex align-items-center gap-2 mb-3">
            <a href="{{ route('user.dashboard') }}" class="text-white opacity-75 text-decoration-none">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h6 class="text-white fw-bold mb-0">Buat Laporan Baru</h6>
        </div>

        {{-- STEP INDICATOR --}}
        <div class="step-indicator">
            <div class="step active">
                <div class="step-circle">1</div>
                <span class="step-label">Info Laporan</span>
            </div>
            <div class="step-line"></div>
            <div class="step active">
                <div class="step-circle">2</div>
                <span class="step-label">Detail Kejadian</span>
            </div>
            <div class="step-line"></div>
            <div class="step active">
                <div class="step-circle">3</div>
                <span class="step-label">Lampiran</span>
            </div>
        </div>

        {{-- FORM --}}
        <div class="form-card">
            <div class="form-card-header">
                <i class="fas fa-file-alt fa-lg"></i>
                <h6>Form Pengaduan Masyarakat</h6>
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

                <form action="{{ route('user.laporan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- SECTION 1: INFO LAPORAN --}}
                    <div class="section-divider">
                        <span><i class="fas fa-info-circle me-1"></i>Informasi Laporan</span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Judul Laporan <span class="required">*</span>
                        </label>
                        <input type="text" name="judul_laporan"
                            class="form-control @error('judul_laporan') is-invalid @enderror"
                            placeholder="Tuliskan judul laporan secara singkat dan jelas"
                            value="{{ old('judul_laporan') }}" required>
                        @error('judul_laporan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Kategori Laporan <span class="required">*</span>
                        </label>
                        <select name="id_kategori"
                            class="form-select @error('id_kategori') is-invalid @enderror" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id_kategori }}"
                                    {{ old('id_kategori') == $kategori->id_kategori ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Isi Laporan <span class="required">*</span>
                        </label>
                        <textarea name="isi_laporan"
                            class="form-control @error('isi_laporan') is-invalid @enderror"
                            placeholder="Ceritakan secara detail permasalahan yang ingin Anda laporkan..."
                            required>{{ old('isi_laporan') }}</textarea>
                        @error('isi_laporan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- SECTION 2: DETAIL KEJADIAN --}}
                    <div class="section-divider">
                        <span><i class="fas fa-map-marker-alt me-1"></i>Detail Kejadian</span>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Kejadian</label>
                            <input type="date" name="tanggal_kejadian"
                                class="form-control @error('tanggal_kejadian') is-invalid @enderror"
                                value="{{ old('tanggal_kejadian') }}"
                                max="{{ date('Y-m-d') }}">
                            @error('tanggal_kejadian')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Lokasi Kejadian</label>
                            <input type="text" name="lokasi_kejadian"
                                class="form-control @error('lokasi_kejadian') is-invalid @enderror"
                                placeholder="Contoh: Jl. Sisingamangaraja No. 10"
                                value="{{ old('lokasi_kejadian') }}">
                            @error('lokasi_kejadian')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- SECTION 3: LAMPIRAN --}}
                    <div class="section-divider">
                        <span><i class="fas fa-paperclip me-1"></i>Lampiran</span>
                    </div>

                    <div class="mb-3">
                        <div class="upload-area" id="uploadArea">
                            <input type="file" name="lampiran[]"
                                id="lampiranInput" multiple
                                accept=".jpg,.jpeg,.png,.pdf,.mp4">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p class="fw-600">Klik atau drag file ke sini</p>
                            <small>Format: JPG, PNG, PDF, MP4 • Maks. 10MB per file</small>
                        </div>
                        <div class="preview-list" id="previewList"></div>
                    </div>

                    {{-- TOMBOL --}}
                    <div class="d-flex gap-3 justify-content-end">
                        <a href="{{ route('user.dashboard') }}" class="btn-cancel">
                            <i class="fas fa-times me-1"></i>Batal
                        </a>
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-paper-plane me-2"></i>Kirim Laporan
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

@endsection

@section('scripts')
<script>
    // Preview lampiran
    document.getElementById('lampiranInput').addEventListener('change', function() {
        const previewList = document.getElementById('previewList');
        previewList.innerHTML = '';

        Array.from(this.files).forEach(file => {
            const ext  = file.name.split('.').pop().toLowerCase();
            const icon = ['jpg','jpeg','png'].includes(ext) ? 'fa-image'
                       : ext === 'pdf' ? 'fa-file-pdf'
                       : ext === 'mp4' ? 'fa-video' : 'fa-file';

            const item = document.createElement('div');
            item.className = 'preview-item';
            item.innerHTML = `<i class="fas ${icon}"></i> ${file.name}`;
            previewList.appendChild(item);
        });
    });
</script>
@endsection
