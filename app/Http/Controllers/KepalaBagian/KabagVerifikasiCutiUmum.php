<?php

namespace App\Http\Controllers\KepalaBagian;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\CuStatusAdminKatimker;
use App\Models\CuStatusKatimkerKabag;
use App\Models\VerifikasiTtdCutiUmum;

class KabagVerifikasiCutiUmum extends Controller
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
        $adminKatimkerId = $request->input('cu_status_admin_katimker_id');
        
        // Get the CuStatusAdminKatimker record
        $adminKatimker = \App\Models\CuStatusAdminKatimker::find($adminKatimkerId);
        if (!$adminKatimker) {
            return back()->with('error', 'Data pengajuan cuti tidak ditemukan');
        }
        
        // Get the user_admin_id from the relationship
        $userAdminId = $adminKatimker->cu_status_user_admin_id;
        
        // Debug logging
        Log::info('Kabag status update untuk cuti umum', [
            'admin_katimker_id' => $adminKatimkerId,
            'user_admin_id' => $userAdminId,
            'status' => $status
        ]);
        
        // Simpan ke database
        CuStatusKatimkerKabag::create([
            'status' => $status,
            'cu_status_admin_katimker_id' => $adminKatimkerId,
            'cu_status_user_admin_id' => $userAdminId,
            'catatan' => $request->input('catatan'),
        ]);
        
        return redirect()->route('kabagdatapermohonancutiumum.index')
                ->with('success', 'Pengajuan Cuti Umum Berhasil Diverifikasi.');
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

    public function approveWithSignature(Request $request)
    {
        // Validasi request
        $request->validate([
            'cu_status_admin_katimker_id' => 'required|exists:cu_status_admin_katimkers,id',
        ]);
        
        $cuStatusAdminKatimkerId = $request->input('cu_status_admin_katimker_id');
        
        // Get the admin_katimker record to access its user_admin_id
        $cuStatusAdminKatimker = CuStatusAdminKatimker::findOrFail($cuStatusAdminKatimkerId);
        $cuStatusUserAdminId = $cuStatusAdminKatimker->cu_status_user_admin_id;
        
        // 1. Simpan status persetujuan ke tabel verifikasi
        CuStatusKatimkerKabag::create([
            'status' => 'disetujui',
            'cu_status_admin_katimker_id' => $cuStatusAdminKatimkerId,
            'cu_status_user_admin_id' => $cuStatusUserAdminId,
            'catatan' => 'Disetujui dengan tanda tangan',
        ]);
        
        // Get user_admin record to access pengajuan_cuti_umum_id
        $cuStatusUserAdmin = $cuStatusAdminKatimker->userAdmin;
        $pengajuanCutiUmumId = $cuStatusUserAdmin->id_pengajuan_cuti_umum;
        
        // 2. Dapatkan atau buat record di tabel verifikasi_ttd_cuti_umums
        $ttdVerifikasi = VerifikasiTtdCutiUmum::updateOrCreate(
            ['pengajuan_cuti_umum_id' => $pengajuanCutiUmumId],
            [
                'ttd_kabag' => true,
                'tanggal_ttd_kabag' => now(),
            ]
        );
        
        return redirect()->route('kabagdatapermohonancutiumum.index')
                ->with('success', 'Pengajuan cuti umum berhasil disetujui dengan tanda tangan');
    }
}
