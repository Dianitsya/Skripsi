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
    ->with([
        'questionnaireResult' => function ($query) {
            $query->select('user_id', 'minat');
        },
        'learningStyleResult' => function ($query) {
            $query->select('user_id', 'dominant_style');
        }
    ])
    ->paginate(10)
    ->withQueryString();


    return view('user.index', compact('users'));
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
