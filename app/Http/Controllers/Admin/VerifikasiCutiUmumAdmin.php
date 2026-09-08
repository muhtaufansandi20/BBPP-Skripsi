<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\CuStatusUserAdmin;
use App\Http\Controllers\Controller;

class VerifikasiCutiUmumAdmin extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
/**
 * Store a newly created resource in storage.
 */
    public function store(Request $request)
    {
        $request->validate([
            'status_cuti' => 'required', // Form masih menggunakan nama 'status_cuti'
        ]);

        $pengajuanId = $request->input('id_pengajuan_cuti_umum');
        $status = $request->input('status_cuti');
        
        // Simpan ke database - sesuaikan nama field dengan model
        CuStatusUserAdmin::create([
            'id_pengajuan_cuti_umum' => $pengajuanId,
            'status' => $status, // Gunakan 'status' sesuai model
            'catatan' => $request->input('alasan_penolakan'), // Form menggunakan 'alasan_penolakan'
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('adminpengajuancutiumum.index')->with('success', 'Status pengajuan cuti umum berhasil diperbarui.');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
