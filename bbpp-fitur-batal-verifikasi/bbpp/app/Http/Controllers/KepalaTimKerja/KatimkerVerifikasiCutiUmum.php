<?php

namespace App\Http\Controllers\KepalaTimKerja;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\CuStatusAdminKatimker;

class KatimkerVerifikasiCutiUmum extends Controller
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
    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required',
        ]);
    
        $status = $request->input('status');
        $adminStatusId = $request->input('cu_status_user_admin_id');
    
        // Debug logging
        Log::info('Katimker status update untuk cuti umum', [
            'admin_status_id' => $adminStatusId,
            'status' => $status
        ]);
    
        // Simpan ke database
        CuStatusAdminKatimker::create([
            'status' => $status,
            'cu_status_user_admin_id' => $adminStatusId,
            'catatan' => $request->input('catatan'),
        ]);
        
        return redirect()->route('katimkerdatapermohonancutiumum.index')->with('success', 'Pengajuan Cuti Umum Berhasil Diverifikasi.');
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
