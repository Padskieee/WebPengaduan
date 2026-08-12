@extends('layouts.admin')

@section('title', 'Detail Laporan')

@push('styles')
<style>
    .detail-card {
        background: white;
        border-radius: 14px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        overflow: hidden;
        margin-bottom: 1.2rem;
    }

    .detail-card-header {
        background: linear-gradient(135deg, #1B5E20, #2E7D32);
        padding: 1rem 1.3rem;
        color: white;
        font-weight: 600;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .detail-card-body { padding: 1.3rem; }

    .detail-row {
        display: flex;
        gap: 1rem;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f5f5f5;
    }
    .detail-row:last-child { border-bottom: none; }

    .detail-label {
        font-size: 0.78rem;
        font-weight: 700;
        color: #9e9e9e;
        min-width: 130px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .detail-value {
        font-size: 0.88rem;
        color: #212121;
        flex: 1;
    }

    /* STATUS BADGE */
    .status-badge {
        font-size: 0.78rem;
        font-weight: 600;
        padding: 0.35rem 0.9rem;
        border-radius: 20px;
    }
    .status-menunggu     { background:#FFF8E1; color:#F57F17; }
    .status-diverifikasi { background:#E3F2FD; color:#1565C0; }
    .status-diproses     { background:#FFF3E0; color:#E65100; }
    .status-ditolak      { background:#FFEBEE; color:#B71C1C; }
    .status-selesai      { background:#E8F5E9; color:#1B5E20; }

    .status-form {
        background: #f9fbe7;
        border: 1.5px solid #c8e6c9;
        border-radius: 12px;
        padding: 1.2rem;
    }
    .status-form h6 {
        font-size: 0.88rem;
        font-weight: 700;
        color: #1B5E20;
        margin-bottom: 1rem;
    }

    .status-options {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .status-option {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 0.6rem 0.9rem;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 0.82rem;
    }
    .status-option:has(input:checked) {
        border-color: #2E7D32;
        background: #E8F5E9;
    }
    .status-option input { display: none; }

    .btn-update {
        background: linear-gradient(135deg, #1B5E20, #2E7D32);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.65rem 1.5rem;
        font-weight: 600;
        font-size: 0.88rem;
        transition: all 0.2s;
        width: 100%;
    }
    .btn-update:hover {
        background: linear-gradient(135deg, #2E7D32, #4CAF50);
        color: white;
        transform: translateY(-1px);
    }

    /* TOMBOL AKSI */
    .btn-hasil {
        background: linear-gradient(135deg, #1565C0, #1976D2);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.65rem 1.5rem;
        font-weight: 600;
        font-size: 0.88rem;
        transition: all 0.2s;
        width: 100%;
        text-decoration: none;
        display: block;
        text-align: center;
        margin-top: 0.75rem;
    }
    .btn-hasil:hover {
        background: linear-gradient(135deg, #1976D2, #1E88E5);
        color: white;
        transform: translateY(-1px);
    }

    .btn-hapus-laporan {
        background: #FFEBEE;
        color: #B71C1C;
        border: 1.5px solid #FFCDD2;
        border-radius: 8px;
        padding: 0.55rem 1.2rem;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.2s;
        width: 100%;
        text-align: center;
        margin-top: 0.5rem;
        cursor: pointer;
    }
    .btn-hapus-laporan:hover { background: #B71C1C; color: white; border-color: #B71C1C; }

    /* HASIL LAPORAN SUMMARY */
    .hasil-summary {
        background: #E3F2FD;
        border: 1.5px solid #BBDEFB;
        border-radius: 10px;
        padding: 0.9rem 1rem;
        margin-top: 0.75rem;
        font-size: 0.83rem;
        color: #1565C0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* TIMELINE */
    .timeline { position: relative; padding-left: 1.5rem; }
    .timeline::before {
        content: '';
        position: absolute;
        left: 7px; top: 0; bottom: 0;
        width: 2px;
        background: #e0e0e0;
    }
    .timeline-item { position: relative; margin-bottom: 1.2rem; }
    .timeline-item:last-child { margin-bottom: 0; }
    .timeline-dot {
        position: absolute;
        left: -1.5rem; top: 4px;
        width: 16px; height: 16px;
        border-radius: 50%;
        background: #2E7D32;
        border: 3px solid white;
        box-shadow: 0 0 0 2px #2E7D32;
    }
    .timeline-content {
        background: #f9f9f9;
        border-radius: 10px;
        padding: 0.75rem 1rem;
    }
    .timeline-status { font-size: 0.82rem; font-weight: 700; color: #1B5E20; margin-bottom: 0.25rem; }
    .timeline-keterangan { font-size: 0.8rem; color: #616161; margin-bottom: 0.25rem; }
    .timeline-time { font-size: 0.72rem; color: #9e9e9e; }

    /* LAMPIRAN */
    .lampiran-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.6rem 0.9rem;
        background: #f9f9f9;
        border-radius: 8px;
        margin-bottom: 0.5rem;
        text-decoration: none;
        color: #212121;
        transition: all 0.2s;
    }
    .lampiran-item:hover { background: #E8F5E9; color: #1B5E20; }
    .lampiran-icon {
        width: 36px; height: 36px;
        border-radius: 8px;
        background: #E8F5E9;
        display: flex; align-items: center; justify-content: center;
        color: #2E7D32;
        flex-shrink: 0;
    }

    /* CUSTOM MODAL */
    .custom-backdrop {
        display: none; position: fixed; inset: 0;
        background: rgba(0,0,0,0.55); z-index: 9998;
    }
    .custom-modal-wrap {
        display: none; position: fixed; inset: 0;
        z-index: 9999; align-items: center; justify-content: center;
    }
    .custom-modal-wrap.show { display: flex; }
    .custom-modal {
        background: white; border-radius: 14px; width: 100%; max-width: 440px;
        box-shadow: 0 24px 64px rgba(0,0,0,0.25);
        animation: modalIn 0.2s ease; overflow: hidden;
    }
    @keyframes modalIn {
        from { transform: translateY(-20px); opacity: 0; }
        to   { transform: translateY(0);     opacity: 1; }
    }
    .custom-modal-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 1rem 1.4rem; border-bottom: 1px solid #f5f5f5;
    }
    .custom-modal-header h6 { margin: 0; font-weight: 700; font-size: 0.95rem; }
    .custom-modal-close {
        background: none; border: none; font-size: 1.1rem; color: #9e9e9e;
        cursor: pointer; line-height: 1; padding: 0.2rem 0.4rem;
        border-radius: 6px; transition: all 0.2s;
    }
    .custom-modal-close:hover { background: #f5f5f5; color: #424242; }
    .custom-modal-body  { padding: 1.2rem 1.4rem; }
    .custom-modal-footer {
        display: flex; justify-content: flex-end; gap: 0.5rem;
        padding: 0.9rem 1.4rem; border-top: 1px solid #f5f5f5;
    }
    .btn-batal {
        background: white; border: 1.5px solid #e0e0e0; border-radius: 8px;
        padding: 0.4rem 1rem; font-size: 0.85rem; font-weight: 600;
        color: #616161; cursor: pointer; transition: all 0.2s;
    }
    .btn-batal:hover { background: #f5f5f5; }
    .btn-konfirm-hapus {
        background: #C62828; border: none; border-radius: 8px;
        padding: 0.4rem 1rem; font-size: 0.85rem; font-weight: 600;
        color: white; cursor: pointer; transition: all 0.2s;
        display: inline-flex; align-items: center; gap: 5px;
    }
    .btn-konfirm-hapus:hover { background: #B71C1C; }
</style>
@endpush

@section('content')

<div class="row">
    <div class="col-lg-8">

        {{-- BACK --}}
        <div class="d-flex align-items-center gap-2 mb-3">
            <a href="{{ route('admin.laporan.index') }}" class="text-muted text-decoration-none">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h6 class="fw-bold mb-0" style="color:#1B5E20;">Detail Laporan</h6>
        </div>

        {{-- INFO LAPORAN --}}
        <div class="detail-card">
            <div class="detail-card-header">
                <i class="fas fa-file-alt"></i> Informasi Laporan
                <span class="ms-auto status-badge status-{{ $laporan->status }}">
                    {{ ucfirst($laporan->status) }}
                </span>
            </div>
            <div class="detail-card-body">
                <div class="detail-row">
                    <span class="detail-label">Pelapor</span>
                    <span class="detail-value">
                        @if($laporan->anonim)
                            <i class="fas fa-user-secret me-1"></i>Anonim
                        @else
                            {{ $laporan->user->nama ?? '-' }}
                            <span class="text-muted small ms-1">({{ $laporan->user->email ?? '' }})</span>
                        @endif
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Judul</span>
                    <span class="detail-value fw-bold">{{ $laporan->judul_laporan }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Kategori</span>
                    <span class="detail-value">{{ $laporan->kategori->nama_kategori ?? '-' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Isi Laporan</span>
                    <span class="detail-value" style="white-space:pre-line;">{{ $laporan->isi_laporan }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Tgl Kejadian</span>
                    <span class="detail-value">
                        {{ $laporan->tanggal_kejadian
                            ? \Carbon\Carbon::parse($laporan->tanggal_kejadian)->locale('id')->isoFormat('D MMMM Y')
                            : '-' }}
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Lokasi</span>
                    <span class="detail-value">{{ $laporan->lokasi_kejadian ?? '-' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Tgl Laporan</span>
                    <span class="detail-value">
                        {{ \Carbon\Carbon::parse($laporan->created_at)->locale('id')->isoFormat('D MMMM Y, HH:mm') }}
                    </span>
                </div>
                @if($laporan->admin)
                    <div class="detail-row">
                        <span class="detail-label">Ditangani</span>
                        <span class="detail-value">{{ $laporan->admin->nama_admin }}</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- LAMPIRAN --}}
        @if($laporan->lampiran->count() > 0)
            <div class="detail-card">
                <div class="detail-card-header">
                    <i class="fas fa-paperclip"></i>
                    Lampiran ({{ $laporan->lampiran->count() }})
                </div>
                <div class="detail-card-body">
                    @foreach($laporan->lampiran as $lamp)
                        <a href="{{ Storage::url($lamp->file_path) }}" target="_blank" class="lampiran-item">
                            <div class="lampiran-icon">
                                @if($lamp->tipe_file == 'foto') <i class="fas fa-image"></i>
                                @elseif($lamp->tipe_file == 'video') <i class="fas fa-video"></i>
                                @else <i class="fas fa-file-pdf"></i>
                                @endif
                            </div>
                            <div>
                                <div class="small fw-bold">{{ basename($lamp->file_path) }}</div>
                                <div class="small text-muted">{{ ucfirst($lamp->tipe_file) }}</div>
                            </div>
                            <i class="fas fa-external-link-alt ms-auto text-muted small"></i>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- HASIL LAPORAN (jika sudah ada) --}}
        @if($laporan->hasilLaporan->count() > 0)
            <div class="detail-card">
                <div class="detail-card-header">
                    <i class="fas fa-check-double"></i>
                    Hasil Penyelesaian ({{ $laporan->hasilLaporan->count() }})
                </div>
                <div class="detail-card-body">
                    @foreach($laporan->hasilLaporan as $hasil)
                        <div style="background:#f9f9f9;border-radius:10px;padding:1rem;margin-bottom:0.75rem;">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="fw-bold small">{{ $hasil->judul_output }}</div>
                                <span style="font-size:0.72rem;font-weight:600;padding:0.25rem 0.65rem;border-radius:20px;
                                    {{ $hasil->status_publish == 'publish' ? 'background:#E8F5E9;color:#1B5E20;' : 'background:#f5f5f5;color:#9e9e9e;' }}">
                                    {{ $hasil->status_publish == 'publish' ? 'Published' : 'Draft' }}
                                </span>
                            </div>
                            <p class="small text-muted mb-2">{{ Str::limit($hasil->deskripsi_output, 120) }}</p>
                            <a href="{{ route('admin.hasil.show', $hasil->id_hasil) }}"
                               style="font-size:0.78rem;color:#1565C0;text-decoration:none;">
                                <i class="fas fa-eye me-1"></i>Lihat Detail Hasil
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>

    <div class="col-lg-4">

        {{-- ══ UPDATE STATUS — selalu tampil ══ --}}
        <div class="detail-card">
            <div class="detail-card-header">
                <i class="fas fa-edit"></i> Update Status
            </div>
            <div class="detail-card-body">
                <form action="{{ route('admin.laporan.status', $laporan->id_laporan) }}" method="POST">
                    @csrf
                            <div class="status-form">
                <h6><i class="fas fa-tasks me-1"></i>Pilih Status Baru</h6>

                <div class="status-options">
                    <label class="status-option" title="Laporan telah diperiksa dan dinyatakan valid untuk ditindaklanjuti">
                <input type="radio" name="status" value="diverifikasi"
                    {{ $laporan->status == 'diverifikasi' ? 'checked' : '' }}>
                <i class="fas fa-check" style="color:#1565C0;"></i>
                <div>
                    <div style="font-weight:600;">Diverifikasi</div>
                    <div style="font-size:0.7rem;color:#9e9e9e;">Laporan valid & siap diproses</div>
                </div>
            </label>
            <label class="status-option" title="Laporan ditolak karena tidak memenuhi syarat atau tidak valid">
                <input type="radio" name="status" value="ditolak"
                    {{ $laporan->status == 'ditolak' ? 'checked' : '' }}
                    id="statusDitolak">
                <i class="fas fa-times-circle" style="color:#B71C1C;"></i>
                <div>
                    <div style="font-weight:600;">Ditolak</div>
                    <div style="font-size:0.7rem;color:#9e9e9e;">Laporan tidak valid/memenuhi syarat</div>
                </div>
            </label>
            <label class="status-option" title="Laporan sedang dalam proses penanganan dan telah diteruskan ke SP4N LAPOR">
                <input type="radio" name="status" value="diproses"
                    {{ $laporan->status == 'diproses' ? 'checked' : '' }}>
                <i class="fas fa-spinner" style="color:#E65100;"></i>
                <div>
                    <div style="font-weight:600;">Diproses</div>
                    <div style="font-size:0.7rem;color:#9e9e9e;">Sedang ditangani SP4N LAPOR</div>
                </div>
            </label>
            <label class="status-option" title="Laporan telah selesai ditangani dan siap dipublikasikan hasilnya">
                <input type="radio" name="status" value="selesai"
                    {{ $laporan->status == 'selesai' ? 'checked' : '' }}>
                <i class="fas fa-check-circle" style="color:#1B5E20;"></i>
                <div>
                    <div style="font-weight:600;">Selesai</div>
                    <div style="font-size:0.7rem;color:#9e9e9e;">Penanganan telah selesai</div>
                </div>
            </label>
                </div>

                <div id="infoStatus" style="
                    background:#E3F2FD;
                    border-left:3px solid #1565C0;
                    border-radius:0 8px 8px 0;
                    padding:0.6rem 0.9rem;
                    font-size:0.78rem;
                    color:#1565C0;
                    margin-bottom:1rem;
                    display:none;">
                    <i class="fas fa-info-circle me-1"></i>
                    <span id="infoStatusText"></span>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">
                        Keterangan
                        <span id="keteranganLabel" class="text-muted fw-normal">(opsional)</span>
                        <span id="keteranganWajib" class="text-danger fw-normal" style="display:none;">
                            * wajib diisi jika menolak
                        </span>
                    </label>
                    <textarea name="keterangan" id="keteranganInput"
                        class="form-control" rows="3"
                        style="font-size:0.85rem;"
                        placeholder="Tambahkan keterangan..."></textarea>
                    <div id="keteranganError"
                        style="display:none;color:#B71C1C;font-size:0.78rem;margin-top:0.3rem;">
                        <i class="fas fa-exclamation-circle me-1"></i>
                        Keterangan wajib diisi jika laporan ditolak!
                    </div>
                </div>

                <button type="submit" class="btn-update" id="btnSimpanStatus">
                    <i class="fas fa-save me-1"></i> Simpan Status
                </button>
            </div>
                </form>

                @if($laporan->status === 'selesai')
                    <a href="{{ route('admin.hasil.create', $laporan->id_laporan) }}" class="btn-hasil">
                        <i class="fas fa-plus me-1"></i>
                        {{ $laporan->hasilLaporan->count() > 0 ? 'Tambah Hasil Penyelesaian' : 'Buat Hasil Penyelesaian' }}
                    </a>
                @endif

                <button class="btn-hapus-laporan mt-2"
                        onclick="konfirmasiHapusLaporan({{ $laporan->id_laporan }}, '{{ addslashes($laporan->judul_laporan) }}')">
                    <i class="fas fa-trash me-1"></i> Hapus Laporan
                </button>
            </div>
        </div>

        <div class="detail-card">
            <div class="detail-card-header">
                <i class="fas fa-history"></i> Riwayat Status
            </div>
            <div class="detail-card-body">
                @if($laporan->logStatus->count() > 0)
                    <div class="timeline">
                        @foreach($laporan->logStatus->sortByDesc('tanggal_update') as $log)
                            <div class="timeline-item">
                                <div class="timeline-dot"></div>
                                <div class="timeline-content">
                                    <div class="timeline-status">{{ ucfirst($log->status) }}</div>
                                    @if($log->keterangan)
                                        <div class="timeline-keterangan">{{ $log->keterangan }}</div>
                                    @endif
                                    <div class="timeline-time">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ \Carbon\Carbon::parse($log->tanggal_update)->locale('id')->isoFormat('D MMM Y, HH:mm') }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center text-muted py-3">
                        <i class="fas fa-history fa-2x mb-2 d-block" style="color:#c8e6c9;"></i>
                        <small>Belum ada riwayat status</small>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>

{{-- CUSTOM MODAL HAPUS LAPORAN --}}
<div class="custom-backdrop" id="backdropShowLaporan"></div>
<div class="custom-modal-wrap" id="modalShowLaporanWrap">
    <div class="custom-modal">
        <div class="custom-modal-header">
            <h6><i class="fas fa-trash me-2 text-danger"></i>Hapus Laporan</h6>
            <button class="custom-modal-close" onclick="tutupModalShowLaporan()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="custom-modal-body">
            <p class="mb-1 small text-muted">Kamu akan menghapus laporan:</p>
            <p class="fw-bold mb-3" id="judulLaporanModal">—</p>
            <div class="alert alert-warning small py-2 mb-0">
                <i class="fas fa-exclamation-triangle me-1"></i>
                Semua data terkait (lampiran, hasil, log status) akan ikut terhapus permanen.
            </div>
        </div>
        <div class="custom-modal-footer">
            <button class="btn-batal" onclick="tutupModalShowLaporan()">Batal</button>
            <form id="formHapusLaporan" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-konfirm-hapus">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>

    const infoMap = {
        'diverifikasi': 'Laporan telah diperiksa dan dinyatakan valid. Admin akan menindaklanjuti laporan ini ke SP4N LAPOR.',
        'diproses'    : 'Laporan sedang dalam proses penanganan dan telah diteruskan ke sistem SP4N LAPOR untuk ditindaklanjuti.',
        'ditolak'     : 'Laporan ditolak karena tidak memenuhi syarat atau tidak valid. Wajib mengisi keterangan alasan penolakan.',
        'selesai'     : 'Laporan telah selesai ditangani. Silakan buat Hasil Penyelesaian dan publikasikan ke feed publik.'
    };

    const infoWarna = {
        'diverifikasi': { bg: '#E3F2FD', border: '#1565C0', text: '#1565C0' },
        'diproses'    : { bg: '#FFF3E0', border: '#E65100', text: '#E65100' },
        'ditolak'     : { bg: '#FFEBEE', border: '#B71C1C', text: '#B71C1C' },
        'selesai'     : { bg: '#E8F5E9', border: '#1B5E20', text: '#1B5E20' }
    };

    document.addEventListener('DOMContentLoaded', function () {
        const radios = document.querySelectorAll('input[name="status"]');

        radios.forEach(function (radio) {
            if (radio.checked) updateInfo(radio.value);

            radio.addEventListener('change', function () {
                updateInfo(this.value);
            });
        });

        document.querySelector('form[action*="status"]').addEventListener('submit', function (e) {
            const selected = document.querySelector('input[name="status"]:checked');
            const keterangan = document.getElementById('keteranganInput').value.trim();
            const errorEl = document.getElementById('keteranganError');

            if (selected && selected.value === 'ditolak' && keterangan === '') {
                e.preventDefault();
                errorEl.style.display = 'block';
                document.getElementById('keteranganInput').style.borderColor = '#B71C1C';
                document.getElementById('keteranganInput').focus();
            } else {
                errorEl.style.display = 'none';
                document.getElementById('keteranganInput').style.borderColor = '';
            }
        });

        document.getElementById('keteranganInput').addEventListener('input', function () {
            document.getElementById('keteranganError').style.display = 'none';
            this.style.borderColor = '';
        });
    });

    function updateInfo(status) {
        const infoBox  = document.getElementById('infoStatus');
        const infoText = document.getElementById('infoStatusText');
        const labelOpsional = document.getElementById('keteranganLabel');
        const labelWajib    = document.getElementById('keteranganWajib');
        const textarea      = document.getElementById('keteranganInput');
        const warna = infoWarna[status];

        infoBox.style.display  = 'block';
        infoBox.style.background   = warna.bg;
        infoBox.style.borderColor  = warna.border;
        infoBox.style.color        = warna.text;
        infoText.textContent       = infoMap[status];

        if (status === 'ditolak') {
            labelOpsional.style.display = 'none';
            labelWajib.style.display    = 'inline';
            textarea.placeholder = 'Wajib isi alasan penolakan laporan...';
            textarea.style.borderColor  = '#B71C1C';
        } else {
            labelOpsional.style.display = 'inline';
            labelWajib.style.display    = 'none';
            textarea.placeholder = 'Tambahkan keterangan... (opsional)';
            textarea.style.borderColor  = '';
            document.getElementById('keteranganError').style.display = 'none';
        }
    }

    function konfirmasiHapusLaporan(id, judul) {
        document.getElementById('judulLaporanModal').textContent = judul;
        document.getElementById('formHapusLaporan').action = '{{ url("admin/laporan") }}/' + id;
        document.getElementById('backdropShowLaporan').style.display = 'block';
        document.getElementById('modalShowLaporanWrap').classList.add('show');
    }

    function tutupModalShowLaporan() {
        document.getElementById('backdropShowLaporan').style.display = 'none';
        document.getElementById('modalShowLaporanWrap').classList.remove('show');
    }

    document.getElementById('backdropShowLaporan').addEventListener('click', tutupModalShowLaporan);
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') tutupModalShowLaporan();
    });
</script>
@endpush
