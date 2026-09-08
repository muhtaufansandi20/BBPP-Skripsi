<?php

namespace App\Http\Controllers\KepalaBagian;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\CtStatusAdminKatimker;
use App\Models\CtStatusUserAdmin;
use App\Models\PengajuanCutiTahunan;
use App\Models\KuotaCutiTahunan;
use App\Models\VerifikasiTtdCutiTahunan;
use App\Models\CtStatusKatimkerKabag as ModelsCtStatusKatimkerKabag;

class CtStatusKatimkerKabag extends Controller
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
            'id_ct_status_admin_katimker' => 'required|exists:ct_status_admin_katimkers,id',
        ]);

        $status = strtolower($request->input('status'));
        $katimkerStatusId = $request->input('id_ct_status_admin_katimker');
        $catatan = $request->input('catatan') ?? '';

        // Trace back through the relationship chain to get the original leave application
        $katimkerStatus = CtStatusAdminKatimker::findOrFail($katimkerStatusId);
        $adminStatusId = $katimkerStatus->id_ct_status_user_admin;
        
        $adminStatus = CtStatusUserAdmin::findOrFail($adminStatusId);
        $pengajuanId = $adminStatus->id_pengajuan_cuti_tahunan;
        
        // Get leave application details to check if it's from a katimker
        $pengajuan = PengajuanCutiTahunan::findOrFail($pengajuanId);
        $isKatimker = $pengajuan->is_katimker;

        // Tambahan untuk id_ct_status_user_admin pada tabel ct_status_katimker_kabags
        $createData = [
            'status' => $status,
            'id_ct_status_admin_katimker' => $katimkerStatusId,
            'id_ct_status_user_admin' => $adminStatusId, // Tambahkan foreign key ke ct_status_user_admins
            'catatan' => $catatan,
        ];

        // Simpan ke database
        $statusKabag = ModelsCtStatusKatimkerKabag::create($createData);

        // Jika status 'ditolak' atau 'ditangguhkan', kembalikan kuota cuti
        if ($status == 'ditolak' || $status == 'ditangguhkan') {
            Log::info('Attempting to restore leave quota for Kabag rejection', [
                'katimker_status_id' => $katimkerStatusId,
                'is_katimker' => $isKatimker
            ]);
            $this->restoreLeaveQuota($katimkerStatusId);
        }

        return redirect()->route('kabagdatapermohonancuti.index')->with('success', 'Pengajuan Cuti Berhasil Diverifikasi');
    }

    /**
     * Restore leave quota when application is rejected by Kabag
     */
    private function restoreLeaveQuota($katimkerStatusId)
    {
        try {
            // Trace back through the relationship chain to get the original leave application
            $katimkerStatus = CtStatusAdminKatimker::findOrFail($katimkerStatusId);
            $adminStatusId = $katimkerStatus->id_ct_status_user_admin;
            
            $adminStatus = CtStatusUserAdmin::findOrFail($adminStatusId);
            $pengajuanId = $adminStatus->id_pengajuan_cuti_tahunan;
            
            Log::info('Relationship chain found', [
                'katimker_status_id' => $katimkerStatusId,
                'admin_status_id' => $adminStatusId,
                'pengajuan_id' => $pengajuanId
            ]);
            
            // Get leave application details
            $pengajuan = PengajuanCutiTahunan::findOrFail($pengajuanId);
            $userId = $pengajuan->user_id;
            $lamaCuti = $pengajuan->lama_cuti;
            $isKatimker = $pengajuan->is_katimker;
            
            Log::info('Leave application found', [
                'user_id' => $userId,
                'lama_cuti' => $lamaCuti,
                'is_katimker' => $isKatimker
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

                // Set catatan - tambahkan informasi jika pemohon adalah Katimker
                $catatan = $kuotaCuti->catatan ?? '';
                $roleInfo = $isKatimker ? " (Pemohon: Kepala Tim)" : "";
                $catatan .= "\nKuota cuti dikembalikan karena pengajuan ditolak/ditangguhkan oleh Kepala Bagian pada " . now()->format('d-m-Y H:i:s') . $roleInfo;

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
            Log::error('Error restoring leave quota in Kabag controller', [
                'katimker_status_id' => $katimkerStatusId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    public function approveWithSignature(Request $request)
    {
        // Validasi request
        $request->validate([
            'id_ct_status_admin_katimker' => 'required|exists:ct_status_admin_katimkers,id',
        ]);
        
        $idCtStatusAdminKatimker = $request->input('id_ct_status_admin_katimker');
        
        // Dapatkan data relasi untuk id_ct_status_user_admin
        $ctStatusAdminKatimker = CtStatusAdminKatimker::findOrFail($idCtStatusAdminKatimker);
        $ctStatusUserAdmin = $ctStatusAdminKatimker->statusUserAdmin;
        $idCtStatusUserAdmin = $ctStatusUserAdmin->id;
        $pengajuanCutiTahunanId = $ctStatusUserAdmin->id_pengajuan_cuti_tahunan;
        
        // 1. Simpan status persetujuan ke tabel verifikasi
        ModelsCtStatusKatimkerKabag::create([
            'status' => 'disetujui',
            'id_ct_status_admin_katimker' => $idCtStatusAdminKatimker,
            'id_ct_status_user_admin' => $idCtStatusUserAdmin, // Tambahkan foreign key ini
            'catatan' => 'Disetujui dengan tanda tangan',
        ]);
        
        // 2. Dapatkan atau buat record di tabel verifikasi_ttd_cuti_tahunans
        $ttdVerifikasi = VerifikasiTtdCutiTahunan::updateOrCreate(
            ['pengajuan_cuti_tahunan_id' => $pengajuanCutiTahunanId],
            [
                'ttd_kabag' => true,
                'tanggal_ttd_kabag' => now(),
            ]
        );
        
        // Periksa apakah ini pengajuan dari katimker
        $pengajuan = PengajuanCutiTahunan::findOrFail($pengajuanCutiTahunanId);
        $sukses = $pengajuan->is_katimker ? 
            'Pengajuan cuti dari Kepala Tim berhasil disetujui dengan tanda tangan' :
            'Pengajuan cuti berhasil disetujui dengan tanda tangan';
        
        return redirect()->route('kabagdatapermohonancuti.index')
                        ->with('success', $sukses);
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