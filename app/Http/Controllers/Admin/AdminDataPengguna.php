<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class AdminDataPengguna extends Controller
{
    
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        // Satukan Query: Pencarian + Pagination
        $query = User::query();
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                ->orWhere('nip', 'like', '%' . $search . '%')
                ;
            });
        }

        // Gunakan satu variabel saja ($users) untuk tabel dan links
        // withQueryString() memastikan parameter 'search' tidak hilang saat klik halaman berikutnya
    $users = $query->orderBy('name', 'asc')->paginate(20)->withQueryString();
        
        // Data Statistik (Query terpisah tidak masalah)
        $kepalaBalai = User::where('role', 'kepalabalai')->first();
        $kepalaBagianUmum = User::where('role', 'kepalabagian')->first();
        $jumlahKepalaTim = User::where('role', 'kepalatimkerja')->count();
        $jumlahPegawaiBiasa = User::where('role', 'user')->count();
        $jumlahwidyaiswara = User::where('role', 'widyaiswara')->count();
        $totalUser = User::count();

        return view('dashboard.admin.datapengguna-admin', compact(
            'users', 
            'search',
            'kepalaBalai',
            'kepalaBagianUmum',
            'jumlahKepalaTim',
            'jumlahPegawaiBiasa',
            'jumlahwidyaiswara',
            'totalUser'
        ));
    }

    // Menampilkan form tambah user
    public function create()
    {
        // Cek apakah sudah ada kepala bagian dan kepala balai
        $hasKepalaBagian = User::where('role', 'kepalabagian')->exists();
        $hasKepalaBalai = User::where('role', 'kepalabalai')->exists();
        
        return view('dashboard.admin.createuser-admin', compact('hasKepalaBagian', 'hasKepalaBalai'));
    }

    // Menyimpan user baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'e_mail' => 'nullable|string|email|max:255|unique:users,e_mail', // Tambahkan validasi e_mail
            'nip' => 'required|numeric|unique:users,nip',
            'password' => 'required|string|min:6',
            'role' => 'required|in:user,admin,kepalatimkerja,kepalabagian,kepalabalai',
            'no_hp' => 'nullable|string|max:15',
            'jabatan' => 'nullable|string|max:50',
            'signature' => 'nullable|string',
        ]);
        
        // Periksa apakah role yang diinginkan sudah ada
        if ($request->role === 'kepalabagian' && User::where('role', 'kepalabagian')->exists()) {
            return redirect()->back()->with('error', 'User dengan role Kepala Bagian sudah ada. Tidak dapat menambahkan lagi.')
                            ->withInput();
        }
        
        if ($request->role === 'kepalabalai' && User::where('role', 'kepalabalai')->exists()) {
            return redirect()->back()->with('error', 'User dengan role Kepala Balai sudah ada. Tidak dapat menambahkan lagi.')
                            ->withInput();
        }
    
        $user = User::create([
            'name' => $request->name,
            'e_mail' => $request->e_mail, // Tambahkan e_mail ke create
            'nip' => $request->nip,
            'password' => Hash::make($request->password), // Pastikan password di-hash sebelum disimpan
            'role' => $request->role,
            'no_hp' => $request->no_hp,
            'jabatan' => $request->jabatan,
            'signature' => $request->signature,
        ]);
    
        return redirect()->route('admindatapengguna.index')->with('success', 'Pengguna berhasil ditambahkan');
    }

    // Menampilkan detail user
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    // Menampilkan form edit user
    public function edit($id)
    {
        $user = User::findOrFail($id);
        
        // Cek apakah sudah ada kepala bagian dan kepala balai selain user yang sedang diedit
        $hasKepalaBagian = User::where('role', 'kepalabagian')
                            ->where('id', '!=', $id)
                            ->exists();
        $hasKepalaBalai = User::where('role', 'kepalabalai')
                            ->where('id', '!=', $id)
                            ->exists();
        
        return view('dashboard.admin.editdatapengguna-admin', compact('user', 'hasKepalaBagian', 'hasKepalaBalai'));
    }

    // Update user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $oldRole = $user->role;

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'e_mail' => ['nullable', 'string', 'email', 'max:255', Rule::unique('users', 'e_mail')->ignore($user->id)], // Tambahkan validasi e_mail
            'nip' => ['required', 'numeric', Rule::unique('users')->ignore($user->id)],
            'role' => 'required|in:user,admin,kepalatimkerja,kepalabagian,kepalabalai,widyaiswara',
            'no_hp' => 'nullable|string|max:15',
            'jabatan' => 'nullable|string|max:50',
            'password' => 'nullable|min:6',
        ]);
        
        // Periksa jika ada perubahan role menjadi kepalabagian atau kepalabalai
        if ($request->role !== $oldRole) {
            if ($request->role === 'kepalabagian' && User::where('role', 'kepalabagian')->exists()) {
                return redirect()->back()->with('error', 'User dengan role Kepala Bagian sudah ada. Tidak dapat mengubah role.')
                                ->withInput();
            }
            
            if ($request->role === 'kepalabalai' && User::where('role', 'kepalabalai')->exists()) {
                return redirect()->back()->with('error', 'User dengan role Kepala Balai sudah ada. Tidak dapat mengubah role.')
                                ->withInput();
            }
        }

        // Update data pengguna
        $user->name = $request->name;
        $user->e_mail = $request->e_mail; // Tambahkan update untuk e_mail
        $user->nip = $request->nip;
        $user->role = $request->role;
        $user->no_hp = $request->no_hp;
        $user->jabatan = $request->jabatan;

        // Update password jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admindatapengguna.index')->with('success', 'Data pengguna berhasil diperbarui!');
    }

    // Hapus user
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('admindatapengguna.index')->with('error', 'User tidak ditemukan!');
        }

        $user->delete();
        return redirect()->route('admindatapengguna.index')->with('success', 'Pengguna berhasil dihapus');
    }
}