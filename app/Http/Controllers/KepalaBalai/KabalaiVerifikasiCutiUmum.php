<?php

namespace App\Http\Controllers\KepalaBalai;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\CuStatusKatimkerKabag;
use App\Models\CuStatusKabagKabal;
use App\Models\CuStatusUserAdmin;
use App\Models\CuStatusAdminKabal;
use App\Models\PengajuanCutiUmum;
use App\Models\VerifikasiTtdCutiUmum;

class KabalaiVerifikasiCutiUmum extends Controller
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
        $katimkerKabagId = $request->input('cu_status_katimker_kabag_id');
        
        // Get the relationship to find cu_status_user_admin_id
        $kabagStatus = CuStatusKatimkerKabag::findOrFail($katimkerKabagId);
        $cuStatusUserAdminId = $kabagStatus->cu_status_user_admin_id;
        
        // Debug logging
        Log::info('Kabalai status update untuk cuti umum', [
            'katimker_kabag_id' => $katimkerKabagId,
            'cu_status_user_admin_id' => $cuStatusUserAdminId,
            'status' => $status
        ]);
        
        // Simpan ke database dengan cu_status_user_admin_id
        CuStatusKabagKabal::create([
            'status' => $status,
            'cu_status_katimker_kabag_id' => $katimkerKabagId,
            'cu_status_user_admin_id' => $cuStatusUserAdminId, // Add this foreign key
            'catatan' => $request->input('catatan'),
        ]);
        
        return redirect()->route('kabalaidatapermohonancutiumum.index')->with('success', 'Pengajuan Cuti Umum Berhasil Diverifikasi.');
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
            'cu_status_katimker_kabag_id' => 'required|exists:cu_status_katimker_kabags,id',
        ]);
        
        $cuStatusKatimkerKabagId = $request->input('cu_status_katimker_kabag_id');
        
        // Get the katimker_kabag record to access its cu_status_user_admin_id
        $cuStatusKatimkerKabag = CuStatusKatimkerKabag::findOrFail($cuStatusKatimkerKabagId);
        $cuStatusUserAdminId = $cuStatusKatimkerKabag->cu_status_user_admin_id;
        
        // 1. Simpan status persetujuan ke tabel verifikasi
        CuStatusKabagKabal::create([
            'status' => 'disetujui',
            'cu_status_katimker_kabag_id' => $cuStatusKatimkerKabagId,
            'cu_status_user_admin_id' => $cuStatusUserAdminId,
            'catatan' => 'Disetujui dengan tanda tangan Kepala Balai',
        ]);
        
        // Get user_admin record to access pengajuan_cuti_umum_id
        $cuStatusUserAdmin = CuStatusUserAdmin::findOrFail($cuStatusUserAdminId);
        $pengajuanCutiUmumId = $cuStatusUserAdmin->id_pengajuan_cuti_umum;
        
        // 2. Dapatkan atau buat record di tabel verifikasi_ttd_cuti_umums
        $ttdVerifikasi = VerifikasiTtdCutiUmum::updateOrCreate(
            ['pengajuan_cuti_umum_id' => $pengajuanCutiUmumId],
            [
                'ttd_kabalai' => true,
                'tanggal_ttd_kabalai' => now(),
            ]
        );
        
        // Periksa apakah ini pengajuan dari kabag
        $pengajuan = PengajuanCutiUmum::findOrFail($pengajuanCutiUmumId);
        $sukses = $pengajuan->is_kabag ? 
            'Pengajuan cuti umum dari Kepala Bagian berhasil disetujui dengan tanda tangan Kepala Balai' :
            'Pengajuan cuti umum berhasil disetujui dengan tanda tangan Kepala Balai';
        
        return redirect()->route('kabalaidatapermohonancutiumum.index')
                ->with('success', $sukses);
    }

    /**
     * Store a new verification for Kabag leave application
     */
    public function storeKabag(Request $request)
    {
        $request->validate([
            'status' => 'required',
            'cu_status_user_admin_id' => 'required|exists:cu_status_user_admins,id',
        ]);

        $status = $request->input('status');
        $cuStatusUserAdminId = $request->input('cu_status_user_admin_id');

        // Get the related data
        $adminStatus = CuStatusUserAdmin::findOrFail($cuStatusUserAdminId);
        $pengajuanId = $adminStatus->id_pengajuan_cuti_umum;

        // Debug logging
        Log::info('Kabalai status update untuk cuti umum Kabag', [
            'cu_status_user_admin_id' => $cuStatusUserAdminId,
            'pengajuan_id' => $pengajuanId,
            'status' => $status
        ]);

        // Create verification record in cu_status_admin_kabals table
        CuStatusAdminKabal::create([
            'status' => $status,
            'cu_status_user_admin_id' => $cuStatusUserAdminId,
            'catatan' => $request->input('catatan'),
        ]); 

        return redirect()->route('kabalaidatapermohonancutiumum.index')
            ->with('success', 'Pengajuan Cuti Umum Kepala Bagian Berhasil Diverifikasi');
    }

    /**
     * Approve Kabag leave application with signature
     */
    public function approveKabagWithSignature(Request $request)
    {
        // Validate request
        $request->validate([
            'cu_status_user_admin_id' => 'required|exists:cu_status_user_admins,id',
        ]);
                
        $cuStatusUserAdminId = $request->input('cu_status_user_admin_id');
        
        // Get related data
        $adminStatus = CuStatusUserAdmin::findOrFail($cuStatusUserAdminId);
        $pengajuanCutiUmumId = $adminStatus->id_pengajuan_cuti_umum;
        
        // Debug logging
        Log::info('Kabalai signature approval untuk cuti umum Kabag', [
            'cu_status_user_admin_id' => $cuStatusUserAdminId,
            'pengajuan_id' => $pengajuanCutiUmumId
        ]);
                
        // Save approval status in cu_status_admin_kabals table
        CuStatusAdminKabal::create([
            'status' => 'disetujui',
            'cu_status_user_admin_id' => $cuStatusUserAdminId,
            'catatan' => 'Disetujui dengan tanda tangan Kepala Balai',
        ]);
                
        // Create or update signature record
        $ttdVerifikasi = VerifikasiTtdCutiUmum::updateOrCreate(
            ['pengajuan_cuti_umum_id' => $pengajuanCutiUmumId],
            [
                'ttd_kabalai' => true,
                'tanggal_ttd_kabalai' => now(),
            ]
        );
        
        return redirect()->route('kabalaidatapermohonancutiumum.index')
                ->with('success', 'Pengajuan cuti umum dari Kepala Bagian berhasil disetujui dengan tanda tangan Kepala Balai');
    }
}