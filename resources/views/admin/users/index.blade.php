@extends('layouts.admin')
@section('title', 'Manajemen Pengguna')
@section('page-title', 'Pengguna')

@section('content')
<div class="page-header" style="display:flex; justify-content:space-between; align-items:center;">
    <div>
        <h1>Manajemen Pengguna & Ranger</h1>
        <p>Kelola data pelanggan, mitra B2B, dan verifikasi relawan Ranger.</p>
    </div>
    
    <form action="{{ route('admin.users.index') }}" method="GET" style="display:flex; gap:10px;">
        <select name="role" class="form-control" style="padding:8px 12px; border-radius:8px; border:1px solid #d8d4c8;" onchange="this.form.submit()">
            <option value="">Semua Peran</option>
            <option value="ranger" {{ request('role') == 'ranger' ? 'selected' : '' }}>Hanya Ranger</option>
            <option value="b2c" {{ request('role') == 'b2c' ? 'selected' : '' }}>Hanya B2C (Konsumen)</option>
            <option value="b2b" {{ request('role') == 'b2b' ? 'selected' : '' }}>Hanya B2B (Mitra)</option>
        </select>
    </form>
</div>

<div class="card">
    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>Nama & Email</th>
                    <th>Peran (Role)</th>
                    <th>Poin</th>
                    <th>Status Akun</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div style="font-weight:600; color:#2d3a1e;">{{ $user->name }}</div>
                        <div style="font-size:13px; color:#6b6b5a;">{{ $user->email }}</div>
                    </td>
                    <td>
                        @if($user->role == 'admin')
                            <span style="background:#fdf0dc; color:#8b6914; padding:4px 10px; border-radius:99px; font-size:12px; font-weight:600;">Admin</span>
                        @elseif($user->role == 'ranger')
                            <span style="background:#e8f5f0; color:#2d6a4f; padding:4px 10px; border-radius:99px; font-size:12px; font-weight:600;">🏕️ Ranger</span>
                        @elseif($user->role == 'b2b')
                            <span style="background:#e8eef8; color:#1e3a8a; padding:4px 10px; border-radius:99px; font-size:12px; font-weight:600;">🏢 Mitra B2B</span>
                        @else
                            <span style="background:#faf9f6; color:#6b6b5a; padding:4px 10px; border-radius:99px; font-size:12px; font-weight:600; border:1px solid #d8d4c8;">👤 Member B2C</span>
                        @endif
                    </td>
                    <td>
                        <div style="font-weight:600; color:#c9a85c;">{{ number_format($user->points) }}</div>
                    </td>
                    <td>
                        @if($user->is_verified)
                            <span style="color:#2d6a4f; font-size:13px; font-weight:600;">✅ Aktif</span>
                        @else
                            <span style="color:#c0392b; font-size:13px; font-weight:600;">⏳ Menunggu Verifikasi</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex; gap:10px; align-items:center;">
                            @if(!$user->is_verified)
                                <form action="{{ route('admin.users.verify', $user->id) }}" method="POST" style="margin:0;">
                                    @csrf @method('PATCH')
                                    <button type="submit" style="background:#2d3a1e; color:white; padding:6px 12px; border-radius:6px; font-size:12px; font-weight:600; border:none; cursor:pointer;">
                                        Verifikasi
                                    </button>
                                </form>
                            @endif

                            @if($user->role !== 'admin')
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Peringatan: Yakin ingin menghapus pengguna ini secara permanen?');" style="margin:0;">
                                    @csrf @method('DELETE')
                                    <button type="submit" style="color:#c0392b; font-weight:600; background:none; border:none; cursor:pointer; font-size:13px;">Hapus</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="empty-state" style="text-align:center; padding:30px; color:#9a9988;">Belum ada data pengguna.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div style="margin-top: 20px;">
    {{ $users->links('pagination::bootstrap-4') }}
</div>
@endsection