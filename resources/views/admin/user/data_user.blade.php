@extends('layouts.admin')

@section('title', 'Data User')

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

    .stats-grid-3 {
        display: grid;
        grid-template-columns: repeat(3, minmax(0,1fr));
        gap: 12px;
        margin-bottom: 1.2rem;
    }
    .stat-card-sm {
        background: white; border: 1px solid #f0f0f0;
        border-radius: 12px; padding: 14px 18px;
        display: flex; align-items: center; gap: 14px;
        transition: border-color .15s, box-shadow .15s;
    }
    .stat-card-sm:hover { border-color: #e0e0e0; box-shadow: 0 2px 8px rgba(0,0,0,.05); }
    .stat-icon-sm { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .stat-val-sm  { font-size: 22px; font-weight: 600; line-height: 1; }
    .stat-lbl-sm  { font-size: 12px; color: #9e9e9e; margin-top: 2px; }
    .s-purple .stat-icon-sm { background: #EEEDFE; } .s-purple .stat-val-sm { color: #3C3489; }
    .s-green  .stat-icon-sm { background: #EAF3DE; } .s-green  .stat-val-sm { color: #3B6D11; }
    .s-amber  .stat-icon-sm { background: #FAEEDA; } .s-amber  .stat-val-sm { color: #854F0B; }

    .filter-bar {
        background: white; border-radius: 12px;
        padding: 0.9rem 1.2rem; margin-bottom: 1.2rem;
        box-shadow: 0 2px 8px rgba(0,0,0,.06);
        display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;
    }
    .filter-bar .form-control,
    .filter-bar .form-select {
        border: 1.5px solid #e0e0e0; border-radius: 8px;
        font-size: 0.85rem; padding: 0.45rem 0.75rem;
    }
    .filter-bar .form-control { max-width: 260px; }
    .filter-bar .form-select  { max-width: 200px; }
    .filter-bar .form-control:focus,
    .filter-bar .form-select:focus { border-color: #2E7D32; box-shadow: 0 0 0 3px rgba(46,125,50,.1); }

    .table-card { background: white; border-radius: 14px; box-shadow: 0 2px 8px rgba(0,0,0,.06); overflow: hidden; }
    .table thead th {
        background: #f5f5f5; font-size: 0.78rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.5px; color: #757575;
        border: none; padding: 0.85rem 1rem;
    }
    .table tbody td {
        font-size: 0.85rem; color: #424242;
        padding: 0.85rem 1rem; vertical-align: middle; border-color: #f5f5f5;
    }
    .table tbody tr:hover { background: #fafafa; }

    .user-avatar {
        width: 36px; height: 36px; border-radius: 50%;
        background: linear-gradient(135deg, #1B5E20, #2E7D32);
        display: flex; align-items: center; justify-content: center;
        color: white; font-weight: 700; font-size: 0.85rem; flex-shrink: 0;
    }
    .user-nama  { font-weight: 600; color: #212121; font-size: 0.875rem; }
    .user-email { font-size: 0.78rem; color: #9e9e9e; }

    .badge-count {
        background: #E8F5E9; color: #1B5E20; font-size: 0.75rem; font-weight: 600;
        padding: 0.25rem 0.65rem; border-radius: 20px;
        display: inline-flex; align-items: center; gap: 4px;
    }
    .badge-count.zero { background: #f5f5f5; color: #9e9e9e; }

    .btn-detail {
        background: #E8F5E9; color: #1B5E20; border: none;
        border-radius: 7px; padding: 0.3rem 0.85rem;
        font-size: 0.78rem; font-weight: 600; text-decoration: none; transition: all .2s;
    }
    .btn-detail:hover { background: #1B5E20; color: white; }

    .btn-hapus {
        background: #FFEBEE; color: #B71C1C; border: none;
        border-radius: 7px; padding: 0.3rem 0.65rem;
        font-size: 0.78rem; font-weight: 600; cursor: pointer; transition: all .2s;
    }
    .btn-hapus:hover { background: #B71C1C; color: white; }

    .sort-link {
        color: #757575; text-decoration: none;
        display: inline-flex; align-items: center; gap: 5px;
        font-size: 0.78rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.5px;
    }
    .sort-link:hover { color: #2E7D32; }
    .sort-link.active { color: #1B5E20; }
    .sort-link .sort-icon { font-size: 0.65rem; }

    .empty-state { text-align: center; padding: 3rem; color: #9e9e9e; }

    .pagination .page-link { border-radius: 8px !important; margin: 0 2px; border: 1.5px solid #e0e0e0; color: #2E7D32; font-size: 0.85rem; }
    .pagination .page-item.active .page-link { background-color: #2E7D32; border-color: #2E7D32; color: white; }
    .pagination .page-link:hover { background-color: #E8F5E9; border-color: #2E7D32; color: #1B5E20; }

    /* ── CUSTOM MODAL ── */
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
    .btn-konfirm-hapus:hover    { background: #B71C1C; }
    .btn-konfirm-hapus:disabled { background: #e0e0e0; color: #9e9e9e; cursor: not-allowed; }
</style>
@endpush

@section('content')

<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h6><i class="fas fa-users me-2"></i>Data User</h6>
            <p>Daftar pengguna yang terdaftar di sistem</p>
        </div>
        <span class="badge bg-light text-success fw-bold" style="position:relative;z-index:1;">
            {{ $totalUser }} User
        </span>
    </div>
</div>

<div class="stats-grid-3">
    <div class="stat-card-sm s-purple">
        <div class="stat-icon-sm">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="#534AB7">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>
        <div><div class="stat-val-sm">{{ $totalUser }}</div><div class="stat-lbl-sm">Total user</div></div>
    </div>
    <div class="stat-card-sm s-green">
        <div class="stat-icon-sm">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="#3B6D11">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div><div class="stat-val-sm">{{ $userAktif }}</div><div class="stat-lbl-sm">Sudah pernah lapor</div></div>
    </div>
    <div class="stat-card-sm s-amber">
        <div class="stat-icon-sm">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="#854F0B">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div><div class="stat-val-sm">{{ $userBelumLaporan }}</div><div class="stat-lbl-sm">Belum pernah lapor</div></div>
    </div>
</div>

<div class="filter-bar">
    <form method="GET" action="{{ route('admin.user.index') }}"
          class="d-flex align-items-center gap-2 flex-wrap w-100" id="filterForm">
        <span class="small fw-bold text-muted">Cari:</span>
        <input type="text" name="search" class="form-control"
               placeholder="Cari nama, email, atau no. HP..."
               value="{{ $search }}">
        <select name="sort" class="form-select" onchange="document.getElementById('filterForm').submit()">
            <option value="terbaru"    {{ $sort == 'terbaru'    ? 'selected' : '' }}>Terbaru daftar</option>
            <option value="terlama"    {{ $sort == 'terlama'    ? 'selected' : '' }}>Terlama daftar</option>
            <option value="terbanyak"  {{ $sort == 'terbanyak'  ? 'selected' : '' }}>Laporan terbanyak</option>
            <option value="tersedikit" {{ $sort == 'tersedikit' ? 'selected' : '' }}>Laporan tersedikit</option>
            <option value="abjad_az"   {{ $sort == 'abjad_az'   ? 'selected' : '' }}>Nama A → Z</option>
            <option value="abjad_za"   {{ $sort == 'abjad_za'   ? 'selected' : '' }}>Nama Z → A</option>
        </select>
        <button type="submit" class="btn btn-sm btn-success px-3"><i class="fas fa-search"></i></button>
        @if($search || $sort != 'terbaru')
            <a href="{{ route('admin.user.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-times"></i> Reset
            </a>
        @endif
        <span class="ms-auto small text-muted">Total: <strong>{{ $users->total() }}</strong> user</span>
    </form>
</div>

<div class="table-card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th style="width:50px">#</th>
                    <th>
                        @php $nextSortNama = $sort === 'abjad_az' ? 'abjad_za' : 'abjad_az';
                             $ikonNama = match($sort) { 'abjad_az' => 'fa-arrow-up', 'abjad_za' => 'fa-arrow-down', default => 'fa-arrows-up-down' }; @endphp
                        <a href="{{ route('admin.user.index', ['search' => $search, 'sort' => $nextSortNama]) }}"
                           class="sort-link {{ in_array($sort, ['abjad_az','abjad_za']) ? 'active' : '' }}">
                            Nama <i class="fas {{ $ikonNama }} sort-icon"></i>
                        </a>
                    </th>
                    <th>No. HP</th>
                    <th style="width:140px">
                        @php $nextSortTgl = $sort === 'terbaru' ? 'terlama' : 'terbaru';
                             $ikonTgl = match($sort) { 'terbaru' => 'fa-arrow-down', 'terlama' => 'fa-arrow-up', default => 'fa-arrows-up-down' }; @endphp
                        <a href="{{ route('admin.user.index', ['search' => $search, 'sort' => $nextSortTgl]) }}"
                           class="sort-link {{ in_array($sort, ['terbaru','terlama']) ? 'active' : '' }}">
                            Terdaftar <i class="fas {{ $ikonTgl }} sort-icon"></i>
                        </a>
                    </th>
                    <th style="width:140px">
                        @php $nextSortLaporan = $sort === 'terbanyak' ? 'tersedikit' : 'terbanyak';
                             $ikonLaporan = match($sort) { 'terbanyak' => 'fa-arrow-down', 'tersedikit' => 'fa-arrow-up', default => 'fa-arrows-up-down' }; @endphp
                        <a href="{{ route('admin.user.index', ['search' => $search, 'sort' => $nextSortLaporan]) }}"
                           class="sort-link {{ in_array($sort, ['terbanyak','tersedikit']) ? 'active' : '' }}">
                            Jumlah Laporan <i class="fas {{ $ikonLaporan }} sort-icon"></i>
                        </a>
                    </th>
                    <th style="width:120px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if($users->count() > 0)
                    @foreach($users as $i => $user)
                        @php
                            $laporanAktif = $user->laporan()
                                ->whereIn('status', ['menunggu','diverifikasi','diproses'])
                                ->count();
                        @endphp
                        <tr>
                            <td class="text-muted small">{{ $users->firstItem() + $i }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="user-avatar">{{ strtoupper(substr($user->nama, 0, 1)) }}</div>
                                    <div>
                                        <div class="user-nama">{{ $user->nama }}</div>
                                        <div class="user-email">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="small text-muted">{{ $user->no_hp ?? '—' }}</td>
                            <td class="small text-muted">
                                {{ \Carbon\Carbon::parse($user->created_at)->locale('id')->isoFormat('D MMM Y') }}
                            </td>
                            <td>
                                <span class="badge-count {{ $user->laporan_count == 0 ? 'zero' : '' }}">
                                    <i class="fas fa-file-alt"></i> {{ $user->laporan_count }} laporan
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.user.show', $user->id_user) }}" class="btn-detail">
                                        <i class="fas fa-eye me-1"></i>Detail
                                    </a>
                                    <button class="btn-hapus"
                                            onclick="bukaModalHapusUser({{ $user->id_user }}, '{{ addslashes($user->nama) }}', {{ $laporanAktif }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="fas fa-users fa-3x mb-3 d-block" style="color:#c8e6c9;"></i>
                                <p class="fw-bold mb-1">{{ $search ? 'User tidak ditemukan' : 'Belum ada user terdaftar' }}</p>
                                <small>{{ $search ? 'Coba kata kunci lain' : 'User yang mendaftar akan muncul di sini' }}</small>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

@if($users->hasPages())
    <div class="d-flex justify-content-center mt-3">{{ $users->onEachSide(1)->links() }}</div>
@endif

{{-- CUSTOM MODAL HAPUS USER --}}
<div class="custom-backdrop" id="backdropUser"></div>
<div class="custom-modal-wrap" id="modalHapusUserWrap">
    <div class="custom-modal">
        <div class="custom-modal-header">
            <h6><i class="fas fa-trash me-2 text-danger"></i>Hapus User</h6>
            <button class="custom-modal-close" onclick="tutupModalUser()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="custom-modal-body">
            <p class="mb-1 small text-muted">Kamu akan menghapus user:</p>
            <p class="fw-bold mb-3" id="namaUserModal">—</p>
            <div id="pesanAktifUser" class="alert alert-warning small py-2 d-none">
                <i class="fas fa-exclamation-triangle me-1"></i>
                User ini masih memiliki <strong id="jumlahAktifUser">0</strong> laporan
                yang sedang aktif dan tidak bisa dihapus.
            </div>
            <p id="pesanKonfirmasiUser" class="small text-muted mb-0">
                Tindakan ini tidak bisa dibatalkan.
            </p>
        </div>
        <div class="custom-modal-footer">
            <button class="btn-batal" onclick="tutupModalUser()">Batal</button>
            <form id="formHapusUser" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" id="btnKonfirmHapusUser" class="btn-konfirm-hapus">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function bukaModalHapusUser(id, nama, laporanAktif) {
    document.getElementById('namaUserModal').textContent = nama;
    document.getElementById('formHapusUser').action = '{{ url("admin/user") }}/' + id;

    const pesanAktif      = document.getElementById('pesanAktifUser');
    const pesanKonfirmasi = document.getElementById('pesanKonfirmasiUser');
    const btnHapus        = document.getElementById('btnKonfirmHapusUser');

    if (laporanAktif > 0) {
        document.getElementById('jumlahAktifUser').textContent = laporanAktif;
        pesanAktif.classList.remove('d-none');
        pesanKonfirmasi.style.display = 'none';
        btnHapus.disabled = true;
    } else {
        pesanAktif.classList.add('d-none');
        pesanKonfirmasi.style.display = 'block';
        btnHapus.disabled = false;
    }

    document.getElementById('backdropUser').style.display = 'block';
    document.getElementById('modalHapusUserWrap').classList.add('show');
}

function tutupModalUser() {
    document.getElementById('backdropUser').style.display = 'none';
    document.getElementById('modalHapusUserWrap').classList.remove('show');
}

document.getElementById('backdropUser').addEventListener('click', tutupModalUser);
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') tutupModalUser();
});
</script>
@endpush
