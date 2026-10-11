<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|numeric|unique:users,nip',
            'nama' => 'required|string|max:50',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:user,admin,kepala sub bagian,kepala bagian,kepala balai',
            'no_hp' => 'nullable|numeric',
            'jabatan' => 'nullable|string|max:50',
        ]);

        User::create([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'no_hp' => $request->no_hp,
            'jabatan' => $request->jabatan,
        ]);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'nip' => 'required|numeric|unique:users,nip,' . $user->id,
            'nama' => 'required|string|max:50',
            'role' => 'required|in:user,admin,kepala sub bagian,kepala bagian,kepala balai',
            'no_hp' => 'nullable|numeric',
            'jabatan' => 'nullable|string|max:50',
        ]);

        $user->update($request->all());

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus');
    }
}