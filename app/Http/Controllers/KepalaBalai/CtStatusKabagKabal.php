<?php

namespace App\Http\Controllers\KepalaBalai;

use Illuminate\Http\Request;
use App\Models\KuotaCutiTahunan;
use App\Models\CtStatusUserAdmin;
use App\Models\CtStatusAdminKabal;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\PengajuanCutiTahunan;
use App\Models\CtStatusAdminKatimker;
use App\Models\CtStatusKatimkerKabag;
use App\Models\VerifikasiTtdCutiTahunan;
use App\Models\CtStatusKabagKabal as ModelsCtStatusKabagKabal;

class CtStatusKabagKabal extends Controller
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
        $kabagStatusId = $request->input('id_ct_status_katimker_kabag');

        // Get the relationship to find id_ct_status_user_admin
        $kabagStatus = CtStatusKatimkerKabag::findOrFail($kabagStatusId);
        $idCtStatusUserAdmin = $kabagStatus->id_ct_status_user_admin;

        // Simpan ke database dengan id_ct_status_user_admin
        ModelsCtStatusKabagKabal::create([
            'status' => $status,
            'id_ct_status_katimker_kabag' => $kabagStatusId,
            'id_ct_status_user_admin' => $idCtStatusUserAdmin, // Tambahkan foreign key ini
            'catatan' => $request->input('catatan'),
        ]);

        // Jika status 'ditolak' atau 'ditangguhkan', kembalikan kuota cuti
        if (strtolower($status) == 'ditolak' || strtolower($status) == 'ditangguhkan') {
            Log::info('Attempting to restore leave quota for Kabal rejection', [
                'kabag_status_id' => $kabagStatusId
            ]);
            $this->restoreLeaveQuota($kabagStatusId);
        }

        return redirect()->route('kepalabalaidatapermohonancuti.index')->with('success', 'Pengajuan Cuti Berhasil Diverifikasi');
    }

    /**
     * Restore leave quota when application is rejected by Kepala Balai
     */
    private function restoreLeaveQuota($kabagStatusId)
    {
        try {
            // Trace back through the relationship chain to get the original leave application
            $kabagStatus = CtStatusKatimkerKabag::findOrFail($kabagStatusId);
            $katimkerStatusId = $kabagStatus->id_ct_status_admin_katimker;
            
            $katimkerStatus = CtStatusAdminKatimker::findOrFail($katimkerStatusId);
            $adminStatusId = $katimkerStatus->id_ct_status_user_admin;
            
            $adminStatus = CtStatusUserAdmin::findOrFail($adminStatusId);
            $pengajuanId = $adminStatus->id_pengajuan_cuti_tahunan;
            
            Log::info('Relationship chain found', [
                'kabag_status_id' => $kabagStatusId,
                'katimker_status_id' => $katimkerStatusId,
                'admin_status_id' => $adminStatusId,
                'pengajuan_id' => $pengajuanId
            ]);
            
            // Get leave application details
            $pengajuan = PengajuanCutiTahunan::findOrFail($pengajuanId);
            $userId = $pengajuan->user_id;
            $lamaCuti = $pengajuan->lama_cuti;
            $isKabag = $pengajuan->is_kabag;
            
            Log::info('Leave application found', [
                'user_id' => $userId,
                'lama_cuti' => $lamaCuti,
                'is_kabag' => $isKabag
            ]);

            // Get leave quota
            $kuotaCuti = KuotaCutiTahunan::where('user_id', $userId)->first();

            if ($kuotaCuti) {
                Log::info('Found leave quota', [
                    'before_update' => [
                        'kuota_n' => $kuotaCuti->kuota_n,
                        'kuota_n1' => $kuotaCuti->kuota_n1,
                        'kuota_n2' => $kuotaCuti->kuota_n2
                    ]
                ]);
                
                // Restore quota with priority: N, then N1, then N2
                $sisaKuota = $lamaCuti;
                $kuotaN = $kuotaCuti->kuota_n;
                $kuotaN1 = $kuotaCuti->kuota_n1;
                $kuotaN2 = $kuotaCuti->kuota_n2;

                // Restore to N quota first
                if ($sisaKuota > 0) {
                    $tambahN = min($sisaKuota, 12 - $kuotaN);
                    $kuotaN += $tambahN;
                    $sisaKuota -= $tambahN;
                    Log::info('Added to N quota', ['amount' => $tambahN, 'new_n' => $kuotaN]);
                }

                // Then restore to N1
                if ($sisaKuota > 0) {
                    $tambahN1 = min($sisaKuota, 3 - $kuotaN1);
                    $kuotaN1 += $tambahN1;
                    $sisaKuota -= $tambahN1;
                    Log::info('Added to N1 quota', ['amount' => $tambahN1, 'new_n1' => $kuotaN1]);
                }

                // Finally restore to N2
                if ($sisaKuota > 0) {
                    $tambahN2 = min($sisaKuota, 3 - $kuotaN2);
                    $kuotaN2 += $tambahN2;
                    Log::info('Added to N2 quota', ['amount' => $tambahN2, 'new_n2' => $kuotaN2]);
                }

                // Set catatan - tambahkan informasi jika pemohon adalah Kabag
                $catatan = $kuotaCuti->catatan ?? '';
                $roleInfo = $isKabag ? " (Pemohon: Kepala Bagian)" : "";
                $catatan .= "\nKuota cuti dikembalikan karena pengajuan ditolak/ditangguhkan oleh Kepala Balai pada " . now()->format('d-m-Y H:i:s') . $roleInfo;

                // Update leave quota
                $kuotaCuti->update([
                    'kuota_n' => $kuotaN,
                    'kuota_n1' => $kuotaN1,
                    'kuota_n2' => $kuotaN2,
                    'catatan' => $catatan
                ]);

                Log::info('Leave quota updated', [
                    'after_update' => [
                        'kuota_n' => $kuotaN,
                        'kuota_n1' => $kuotaN1,
                        'kuota_n2' => $kuotaN2
                    ]
                ]);
            } else {
                Log::warning('No leave quota found for user', ['user_id' => $userId]);
            }
        } catch (\Exception $e) {
            Log::error('Error restoring leave quota in Kabal controller', [
                'kabag_status_id' => $kabagStatusId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
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

    // Approve with signature method
    public function approveWithSignatureKabal(Request $request)
    {
        // Validasi request
        $request->validate([
            'id_ct_status_katimker_kabag' => 'required|exists:ct_status_katimker_kabags,id',
        ]);
                
        $idCtStatusKatimkerKabag = $request->input('id_ct_status_katimker_kabag');
        
        // Dapatkan data relasi untuk id_ct_status_user_admin
        $ctStatusKatimkerKabag = CtStatusKatimkerKabag::findOrFail($idCtStatusKatimkerKabag);
        $idCtStatusUserAdmin = $ctStatusKatimkerKabag->id_ct_status_user_admin;
        $ctStatusUserAdmin = CtStatusUserAdmin::findOrFail($idCtStatusUserAdmin);
        $pengajuanCutiTahunanId = $ctStatusUserAdmin->id_pengajuan_cuti_tahunan;
                
        // 1. Simpan status persetujuan ke tabel verifikasi
        ModelsCtStatusKabagKabal::create([
            'status' => 'disetujui',
            'id_ct_status_katimker_kabag' => $idCtStatusKatimkerKabag,
            'id_ct_status_user_admin' => $idCtStatusUserAdmin, // Tambahkan foreign key ini
            'catatan' => 'Disetujui dengan tanda tangan Kepala Balai',
        ]);
                
        // 2. Dapatkan atau buat record di tabel verifikasi_ttd_cuti_tahunans
        $ttdVerifikasi = VerifikasiTtdCutiTahunan::updateOrCreate(
            ['pengajuan_cuti_tahunan_id' => $pengajuanCutiTahunanId],
            [
                'ttd_kabalai' => true,
                'tanggal_ttd_kabalai' => now(),
            ]
        );
        
        // Periksa apakah ini pengajuan dari kabag
        $pengajuan = PengajuanCutiTahunan::findOrFail($pengajuanCutiTahunanId);
        $sukses = $pengajuan->is_kabag ? 
            'Pengajuan cuti dari Kepala Bagian berhasil disetujui dengan tanda tangan Kepala Balai' :
            'Pengajuan cuti berhasil disetujui dengan tanda tangan Kepala Balai';
                
        return redirect()->route('kepalabalaidatapermohonancuti.index')
                        ->with('success', $sukses);
    }

    /**
     * Store a new verification for Kabag leave application
     */
    public function storeKabag(Request $request)
    {
        $request->validate([
            'status' => 'required',
            'id_ct_status_user_admin' => 'required|exists:ct_status_user_admins,id',
        ]);

        $status = $request->input('status');
        $idCtStatusUserAdmin = $request->input('id_ct_status_user_admin');

        // Get the related data
        $adminStatus = CtStatusUserAdmin::findOrFail($idCtStatusUserAdmin);
        $pengajuanId = $adminStatus->id_pengajuan_cuti_tahunan;

        // Create verification record in ct_status_admin_kabals table
        CtStatusAdminKabal::create([
            'status' => $status,
            'id_ct_status_user_admin' => $idCtStatusUserAdmin,
            'catatan' => $request->input('catatan'),
        ]); 

        // If rejected or postponed, restore leave quota
        if (strtolower($status) == 'ditolak' || strtolower($status) == 'ditangguhkan') {
            Log::info('Attempting to restore leave quota for Kabal rejection of Kabag leave', [
                'admin_status_id' => $idCtStatusUserAdmin
            ]);
            $this->restoreLeaveQuotaForKabag($idCtStatusUserAdmin);
        }

        return redirect()->route('kepalabalaidatapermohonancuti.index')
            ->with('success', 'Pengajuan Cuti Kepala Bagian Berhasil Diverifikasi');
    }

    /**
     * Approve Kabag leave application with signature
     */
    public function approveKabagWithSignature(Request $request)
    {
        // Validate request
        $request->validate([
            'id_ct_status_user_admin' => 'required|exists:ct_status_user_admins,id',
        ]);
                
        $idCtStatusUserAdmin = $request->input('id_ct_status_user_admin');
        
        // Get related data
        $adminStatus = CtStatusUserAdmin::findOrFail($idCtStatusUserAdmin);
        $pengajuanCutiTahunanId = $adminStatus->id_pengajuan_cuti_tahunan;
                
        // Save approval status in ct_status_admin_kabals table
        CtStatusAdminKabal::create([
            'status' => 'disetujui',
            'id_ct_status_user_admin' => $idCtStatusUserAdmin,
            'catatan' => 'Disetujui dengan tanda tangan Kepala Balai',
        ]);
                
        // Create or update signature record
        $ttdVerifikasi = VerifikasiTtdCutiTahunan::updateOrCreate(
            ['pengajuan_cuti_tahunan_id' => $pengajuanCutiTahunanId],
            [
                'ttd_kabalai' => true,
                'tanggal_ttd_kabalai' => now(),
            ]
        );
        
        return redirect()->route('kepalabalaidatapermohonancuti.index')
                        ->with('success', 'Pengajuan cuti dari Kepala Bagian berhasil disetujui dengan tanda tangan Kepala Balai');
    }


    /**
     * Restore leave quota for Kabag when application is rejected
     */
    private function restoreLeaveQuotaForKabag($adminStatusId)
    {
        try {
            // Get admin status
            $adminStatus = CtStatusUserAdmin::findOrFail($adminStatusId);
            $pengajuanId = $adminStatus->id_pengajuan_cuti_tahunan;
            
            Log::info('Restoring quota for Kabag leave application', [
                'admin_status_id' => $adminStatusId,
                'pengajuan_id' => $pengajuanId
            ]);
            
            // Get leave application details
            $pengajuan = PengajuanCutiTahunan::findOrFail($pengajuanId);
            $userId = $pengajuan->user_id;
            $lamaCuti = $pengajuan->lama_cuti;
            
            // Get leave quota
            $kuotaCuti = KuotaCutiTahunan::where('user_id', $userId)->first();

            if ($kuotaCuti) {
                Log::info('Found leave quota for Kabag', [
                    'before_update' => [
                        'kuota_n' => $kuotaCuti->kuota_n,
                        'kuota_n1' => $kuotaCuti->kuota_n1,
                        'kuota_n2' => $kuotaCuti->kuota_n2
                    ]
                ]);
                
                // Restore quota with priority: N, then N1, then N2
                $sisaKuota = $lamaCuti;
                $kuotaN = $kuotaCuti->kuota_n;
                $kuotaN1 = $kuotaCuti->kuota_n1;
                $kuotaN2 = $kuotaCuti->kuota_n2;

                // Restore to N quota first
                if ($sisaKuota > 0) {
                    $tambahN = min($sisaKuota, 12 - $kuotaN);
                    $kuotaN += $tambahN;
                    $sisaKuota -= $tambahN;
                    Log::info('Added to N quota for Kabag', ['amount' => $tambahN, 'new_n' => $kuotaN]);
                }

                // Then restore to N1
                if ($sisaKuota > 0) {
                    $tambahN1 = min($sisaKuota, 3 - $kuotaN1);
                    $kuotaN1 += $tambahN1;
                    $sisaKuota -= $tambahN1;
                    Log::info('Added to N1 quota for Kabag', ['amount' => $tambahN1, 'new_n1' => $kuotaN1]);
                }

                // Finally restore to N2
                if ($sisaKuota > 0) {
                    $tambahN2 = min($sisaKuota, 3 - $kuotaN2);
                    $kuotaN2 += $tambahN2;
                    Log::info('Added to N2 quota for Kabag', ['amount' => $tambahN2, 'new_n2' => $kuotaN2]);
                }

                // Update leave quota with notes
                $catatan = $kuotaCuti->catatan ?? '';
                $catatan .= "\nKuota cuti Kepala Bagian dikembalikan karena pengajuan ditolak/ditangguhkan oleh Kepala Balai pada " . now()->format('d-m-Y H:i:s');

                $kuotaCuti->update([
                    'kuota_n' => $kuotaN,
                    'kuota_n1' => $kuotaN1,
                    'kuota_n2' => $kuotaN2,
                    'catatan' => $catatan
                ]);

                Log::info('Leave quota updated for Kabag', [
                    'after_update' => [
                        'kuota_n' => $kuotaN,
                        'kuota_n1' => $kuotaN1,
                        'kuota_n2' => $kuotaN2
                    ]
                ]);
            } else {
                Log::warning('No leave quota found for Kabag', ['user_id' => $userId]);
            }
        } catch (\Exception $e) {
            Log::error('Error restoring leave quota for Kabag', [
                'admin_status_id' => $adminStatusId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

}