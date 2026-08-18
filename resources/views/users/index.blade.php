<x-app-layout>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; }
body { font-family: 'Inter', sans-serif; background: #eef3f9; }
.app-layout { display: flex; min-height: 100vh; }

.main-content { flex: 1; padding: 28px 28px 28px 24px; min-width: 0; }

/* Page header */
.page-header {
    background: linear-gradient(135deg, #12283a 0%, #12283a 100%);
    border-radius: 18px; padding: 28px 32px; color: white;
    margin-bottom: 24px; position: relative; overflow: hidden;
    display: flex; align-items: center; justify-content: space-between;
}
.page-header::before { content:''; position:absolute; right:-50px; top:-50px; width:180px; height:180px; background:rgba(255,255,255,.08); border-radius:50%; }
.page-header::after  { content:''; position:absolute; right:80px; bottom:-60px; width:140px; height:140px; background:rgba(255,255,255,.06); border-radius:50%; }
.page-header-text { position: relative; z-index: 1; }
.page-title { font-size: 22px; font-weight: 800; color: white; margin: 0 0 4px 0; }
.page-subtitle { font-size: 13px; color: rgba(255,255,255,.85); margin: 0; }
.btn-primary { position: relative; z-index: 1; background: white; color: #12283a; border: none; padding: 11px 22px; border-radius: 25px; font-size: 13px; font-weight: 800; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; white-space: nowrap; box-shadow: 0 4px 15px rgba(0,0,0,.15); transition: transform .15s, box-shadow .15s; }
.btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,.2); color: #12283a; }

/* User cards */
.role-section { margin-bottom: 32px; }
.role-section-title { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: #888; margin-bottom: 12px; display: flex; align-items: center; gap: 8px; }
.role-badge { display: inline-block; padding: 2px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; }

.users-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 16px; }
.user-card { background: white; border-radius: 16px; padding: 20px; box-shadow: 0 2px 12px rgba(0,0,0,.06); display: flex; align-items: center; gap: 16px; transition: transform .2s, box-shadow .2s; }
.user-card:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(0,0,0,.1); }
.user-avatar { width: 48px; height: 48px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 800; color: white; flex-shrink: 0; }
.user-info { flex: 1; min-width: 0; }
.user-name { font-size: 14px; font-weight: 700; color: #333; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.user-email { font-size: 11px; color: #aab; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-top: 2px; }
.user-role { font-size: 10px; font-weight: 700; padding: 2px 8px; border-radius: 20px; display: inline-block; margin-top: 4px; }
.user-actions { display: flex; gap: 6px; }
.btn-icon { width: 32px; height: 32px; border-radius: 8px; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 12px; transition: all .15s; }
.btn-edit { background: rgba(18,40,58,0.06); color: #12283a; }
.btn-edit:hover { background: #12283a; color: white; }
.btn-delete { background: #fff0f0; color: #e05252; }
.btn-delete:hover { background: #e05252; color: white; }

/* Flash messages */
.flash-success { background: #f0fff4; border: 1px solid #c6f6d5; color: #276749; padding: 12px 18px; border-radius: 12px; margin-bottom: 20px; font-size: 13px; font-weight: 600; display: flex; align-items: center; gap: 8px; }
.flash-error { background: #fff0f0; border: 1px solid #fed7d7; color: #c53030; padding: 12px 18px; border-radius: 12px; margin-bottom: 20px; font-size: 13px; font-weight: 600; display: flex; align-items: center; gap: 8px; }

/* Empty state */
.empty-state { text-align: center; padding: 48px; color: #bbb; }
.empty-state i { font-size: 40px; display: block; margin-bottom: 12px; }
.empty-state p { font-size: 14px; margin: 0; }
</style>

<div class="app-layout">
    <!-- SIDEBAR -->
    <x-sidebar active="users" />

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="page-header">
            <div class="page-header-text">
                <h1 class="page-title"><i class="fas fa-user-shield" style="margin-right:10px;"></i>Manajemen Akun</h1>
                <p class="page-subtitle">Kelola akun Taruna, Pengasuh, dan Admin</p>
            </div>
            <a href="{{ route('users.create') }}" class="btn-primary">
                <i class="fas fa-plus"></i> Tambah Akun
            </a>
        </div>

        @if(session('success'))
        <div class="flash-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="flash-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
        @endif

        @php
            $roleGroups = [
                'admin' => ['label' => 'Admin', 'color' => '#12283a', 'bg' => 'rgba(18,40,58,0.06)', 'icon' => 'fa-crown'],
                'pengasuh'      => ['label' => 'Pengasuh',      'color' => '#12283a', 'bg' => '#ebf4ff', 'icon' => 'fa-chalkboard-teacher'],
                'taruna'        => ['label' => 'Taruna',         'color' => '#38a169', 'bg' => '#f0fff4', 'icon' => 'fa-user-graduate'],
            ];
            $avatarColors = ['#12283a','#12283a','#fdbb11','#dc2626','#38a169','#e07020','#12283a','#d53f8c'];
        @endphp

        @foreach($roleGroups as $roleKey => $roleInfo)
        @php $groupUsers = $users->where('role', $roleKey); @endphp
        @if($groupUsers->isNotEmpty())
        <div class="role-section">
            <div class="role-section-title">
                <i class="fas {{ $roleInfo['icon'] }}" style="color:{{ $roleInfo['color'] }};"></i>
                {{ $roleInfo['label'] }}
                <span class="role-badge" style="background:{{ $roleInfo['bg'] }}; color:{{ $roleInfo['color'] }};">
                    {{ $groupUsers->count() }} akun
                </span>
            </div>
            <div class="users-grid">
                @foreach($groupUsers as $i => $user)
                <div class="user-card">
                    <div class="user-avatar" style="background: {{ $avatarColors[$i % count($avatarColors)] }};">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                    <div class="user-info">
                        <div class="user-name">{{ $user->name }}</div>
                        <div class="user-email">{{ $user->email }}</div>
                        <span class="user-role" style="background:{{ $roleInfo['bg'] }}; color:{{ $roleInfo['color'] }};">
                            {{ $roleInfo['label'] }}
                        </span>
                        @if($user->prodi)
                        <span class="user-role" style="background:#eef3f9; color:#555; margin-left:4px;">
                            {{ $user->prodi }}
                        </span>
                        @endif
                    </div>
                    <div class="user-actions">
                        <a href="{{ route('users.edit', $user) }}" class="btn-icon btn-edit" title="Edit">
                            <i class="fas fa-pen"></i>
                        </a>
                        @if($user->id !== auth()->id())
                        <button type="button" class="btn-icon btn-delete js-delete-user" title="Hapus"
                                data-delete-url="{{ route('users.destroy', $user) }}"
                                data-user-name="{{ $user->name }}">
                            <i class="fas fa-trash"></i>
                        </button>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        @endforeach

        @if($users->isEmpty())
        <div class="empty-state">
            <i class="fas fa-users"></i>
            <p>Belum ada akun terdaftar.</p>
        </div>
        @endif
    </div>
</div>
</x-app-layout>

