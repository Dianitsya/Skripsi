<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Menampilkan daftar pengguna.
     */
    public function index()
    {
        $search = request('search');

        $users = User::when($search, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
        })
        ->orderBy('name')
        ->where('id', '!=', 1)
        ->paginate(10)
        ->withQueryString();

        // Update perhitungan total berdasarkan kolom yang digunakan
        $totalUsers = User::count();
        $totalAdmins = User::where('is_admin', true)->count();
        // ATAU
        // $totalAdmins = User::where('role', 'admin')->count();
        $totalReguler = $totalUsers - $totalAdmins;
        return view('user.index', compact('users', 'totalUsers', 'totalAdmins', 'totalReguler'));
    }

    public function makeAdmin(User $user)
    {
        $user->update(['is_admin' => true]);
        // ATAU
        // $user->update(['role' => 'admin']);

        return redirect()->back()->with('success', 'User has been promoted to Admin.');
    }

    public function removeAdmin(User $user)
    {
        if ($user->id === 1) {
            return redirect()->back()->with('error', 'Cannot remove Admin rights from Super Admin.');
        }

        $user->update(['is_admin' => false]);
        // ATAU
        // $user->update(['role' => 'user']);

        return redirect()->back()->with('success', 'Admin rights removed from user.');
    }

    /**
     * Menghapus akun pengguna.
     */
    public function destroy(User $user)
    {
        if ($user->id === 1) {
            return redirect()->back()->with('error', 'Cannot delete the Super Admin.');
        }

        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully.');
    }
}
