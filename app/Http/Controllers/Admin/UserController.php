<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Menampilkan daftar semua pengguna
    public function index(Request $request)
    {
        // Fitur Filter (opsional, jika ingin memfilter berdasarkan role)
        $query = User::query();
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        
        $users = $query->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    // Mengubah is_verified menjadi true
    public function verify(User $user)
    {
        $user->update(['is_verified' => true]);
        return back()->with('success', 'Akun ' . $user->name . ' berhasil diverifikasi dan sekarang dapat login!');
    }

    // Menghapus akun pengguna
    public function destroy(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Peringatan: Anda tidak dapat menghapus akun Admin.');
        }

        $user->delete();
        return back()->with('success', 'Akun pengguna berhasil dihapus dari sistem.');
    }
}