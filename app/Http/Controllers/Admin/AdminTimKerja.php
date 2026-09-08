<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\TimKerja;
use App\Models\User;
use Illuminate\Http\Request;

class AdminTimKerja extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $timkerjas = TimKerja::all();
        return view ('dashboard.admin.timkerja-admin', compact('timkerjas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // [UBAH BAGIAN INI] Ambil 2 orang yang punya role kepalatimkerja
        $calonKetua = User::where('role', 'kepalatimkerja')->get();
        
        // Kirim datanya ke view
        return view ('dashboard.admin.createtimkerja-admin', compact('calonKetua'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_tim' => 'required|string|max:255|unique:tim_kerjas,nama_tim',
        ]);

        // Simpan ke database
        TimKerja::create([
            'nama_tim' => $request->nama_tim,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('admintimkerja.index')->with('success', 'Tim kerja berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $timKerja = TimKerja::findOrFail($id);
        
        // [UBAH BAGIAN INI] Ambil datanya juga untuk halaman edit
        $calonKetua = User::where('role', 'kepalatimkerja')->get();

        return view('dashboard.admin.edittimkerja', compact('timKerja', 'calonKetua'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_tim' => 'required|string|max:255',
        ]);

        $timKerja = TimKerja::findOrFail($id);
        $timKerja->nama_tim = $request->nama_tim;
        $timKerja->save();

        return redirect()->route('admintimkerja.index')->with('success', 'Tim kerja berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $timKerja = TimKerja::findOrFail($id);
        $timKerja->delete();

        return redirect()->route('admintimkerja.index')->with('success', 'Tim kerja berhasil dihapus!');
    }
}
