<x-app-layout>
<style>
    .us-aksi { display: flex; align-items: center; justify-content: space-between; gap: var(--space-3); flex-wrap: wrap; }
    .us-aksi__teks { font-size: 13px; font-weight: 600; color: var(--ink-700); }
    .us-aksi__teks i { color: var(--accent); margin-right: var(--space-1-5); }
    .us-table td { vertical-align: middle; }
    .us-badges { display: flex; flex-wrap: wrap; gap: var(--space-1); }
    .us-aksi-sel { display: inline-flex; gap: var(--space-1); }
    .us-aksi-sel form { margin: 0; }
</style>

<x-island-navbar />

@php
    // [label, ikon, varian ds-badge / ikon stat]
    $roleInfo = [
        'admin'    => ['Admin', 'fa-crown', 'accent'],
        'pengasuh' => ['Pengasuh', 'fa-chalkboard-user', 'info'],
        'taruna'   => ['Taruna', 'fa-user-graduate', 'success'],
    ];
@endphp

<main class="max-w-7xl mx-auto px-4 sm:px-6 pb-12 pt-2">
    <div class="spatial-workspace-window rounded-3xl bg-white/30 backdrop-blur-2xl border border-white/50 shadow-2xl p-4 sm:p-7 relative overflow-hidden">

        <x-page-banner title="Manajemen Akun" icon="fa-users-gear"
            subtitle="Kelola akun Admin, Pengasuh, dan Taruna yang dapat masuk ke sistem" />

        <div class="ds-card us-aksi mb-4">
            <span class="us-aksi__teks"><i class="fa-solid fa-user-plus"></i>Buat akun baru untuk admin, pengasuh, atau taruna</span>
            <a href="{{ route('users.create') }}" class="ds-btn ds-btn--primary"><i class="fa-solid fa-plus"></i> Tambah Akun</a>
        </div>

        @if(session('success'))
        <x-glass-alert type="success" title="Berhasil">{{ session('success') }}</x-glass-alert>
        @endif
        @if(session('error'))
        <x-glass-alert type="danger" title="Gagal">{{ session('error') }}</x-glass-alert>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5 mb-4">
            @foreach($roleInfo as $role => [$label, $ikon, $varian])
            <x-stat-card :title="$label" :value="$users->where('role', $role)->count()" :icon="'fa-solid ' . $ikon"
                :varian="$varian" badge="akun" :badgeType="$varian" :description="'Akun ber-role ' . strtolower($label)" />
            @endforeach
        </div>

        <div class="ds-card">
            <div class="ds-card__head tbl-head">
                <div>
                    <h3 class="ds-card__title"><i class="fa-solid fa-address-card ds-icon"></i> Daftar Akun</h3>
                    <p class="ds-card__desc">Urut role lalu nama — gunakan kolom cari & filter role di bawah</p>
                </div>
                <span class="ds-badge ds-badge--accent">{{ $users->count() }} akun</span>
            </div>

            @if($users->isEmpty())
            <div class="ds-empty"><i class="fa-solid fa-users-slash ds-icon"></i> Belum ada akun terdaftar.</div>
            @else
            <div class="ds-table-wrap">
                <div class="ds-scroll">
                    <table class="ds-table tbl-table us-table">
                        <thead>
                            <tr>
                                <th>Akun</th>
                                <th data-filter>Role</th>
                                <th>Username</th>
                                <th>Jabatan / Prodi</th>
                                <th class="ds-center" data-no-sort data-no-filter>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            @php [$rLabel, $rIkon, $rVarian] = $roleInfo[$user->role] ?? [ucfirst($user->role), 'fa-user', 'accent']; @endphp
                            <tr>
                                <td>
                                    <div class="ds-cell-person">
                                        <span class="ds-avatar">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                        <div>
                                            <div class="tbl-title">{{ $user->name }} @if($user->id === auth()->id())<span class="ds-badge ds-badge--accent">Anda</span>@endif</div>
                                            <div class="tbl-sub">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="us-badges">
                                        <span class="ds-badge ds-badge--{{ $rVarian }}"><i class="fa-solid {{ $rIkon }}"></i> {{ $rLabel }}</span>
                                        @foreach($user->akses_khusus ?? [] as $ak)
                                        @php $ai = \App\Models\User::DAFTAR_AKSES[$ak] ?? ['label' => $ak, 'ikon' => 'fa-key']; @endphp
                                        <span class="ds-badge ds-badge--warning"><i class="fa-solid {{ $ai['ikon'] }}"></i> {{ $ai['label'] }}</span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="tbl-muted">{{ $user->username ? '@' . $user->username : '—' }}</td>
                                <td>
                                    <div class="tbl-title">{{ $user->jabatan ?: '—' }}</div>
                                    @if($user->prodi)<div class="tbl-sub">{{ $user->prodi }}</div>@endif
                                </td>
                                <td class="ds-center">
                                    <div class="us-aksi-sel">
                                        <a href="{{ route('users.edit', $user) }}" class="ds-btn ds-btn--icon" title="Ubah" aria-label="Ubah akun {{ $user->name }}"><i class="fa-solid fa-pen"></i></a>
                                        @if($user->id !== auth()->id())
                                        <form method="POST" action="{{ route('users.destroy', $user) }}"
                                              data-konfirmasi="Akun {{ $user->name }} ({{ $user->email }}) akan dihapus permanen dan tidak dapat masuk lagi." data-konfirmasi-judul="Hapus Akun?" data-konfirmasi-tombol="Ya, Hapus Akun">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="ds-btn ds-btn--icon ds-btn--danger" title="Hapus" aria-label="Hapus akun {{ $user->name }}"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>

    </div>
</main>

<x-konfirmasi-modal />
</x-app-layout>
