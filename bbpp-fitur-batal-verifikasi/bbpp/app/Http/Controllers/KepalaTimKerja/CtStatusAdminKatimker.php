<?php

namespace App\Http\Controllers\KepalaTimKerja;

use App\Http\Controllers\Controller;
use App\Models\CtStatusAdminKatimker as ModelsCtStatusAdminKatimker;
use App\Models\PengajuanCutiTahunan;
use App\Models\KuotaCutiTahunan;
use App\Models\CtStatusUserAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CtStatusAdminKatimker extends Controller
{
    // Other methods...

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required',
        ]);

        $status = $request->input('status');
        $adminStatusId = $request->input('id_ct_status_user_admin');

        // Debug logging
        Log::info('Katimker status update', [
            'admin_status_id' => $adminStatusId,
            'status' => $status
        ]);

        // Simpan ke database
        ModelsCtStatusAdminKatimker::create([
            'status' => $status,
            'id_ct_status_user_admin' => $adminStatusId,
            'catatan' => $request->input('catatan'),
        ]);

        // Jika status 'ditolak' atau 'ditangguhkan', kembalikan kuota cuti
        if (strtolower($status) == 'ditolak' || strtolower($status) == 'ditangguhkan') {
            Log::info('Attempting to restore leave quota for admin status ID: ' . $adminStatusId);
            $this->restoreLeaveQuota($adminStatusId);
        }

        return redirect()->route('katimkerdatapermohonancuti.index')->with('success', 'Pengajuan Cuti Berhasil Diverifikasi.');
    }

    /**
     * Restore leave quota when application is rejected by Katimker
     */
    private function restoreLeaveQuota($adminStatusId)
    {
        try {
            // Ambil data status admin
            $adminStatus = CtStatusUserAdmin::findOrFail($adminStatusId);
            Log::info('Admin status found', ['admin_status' => $adminStatus]);
            
            // Ambil data pengajuan cuti
            $pengajuanId = $adminStatus->id_pengajuan_cuti_tahunan;
            $pengajuan = PengajuanCutiTahunan::findOrFail($pengajuanId);
            $userId = $pengajuan->user_id;
            $lamaCuti = $pengajuan->lama_cuti;
            
            Log::info('Leave application found', [
                'pengajuan_id' => $pengajuanId,
                'user_id' => $userId,
                'lama_cuti' => $lamaCuti
            ]);

            // Ambil data kuota cuti
            $kuotaCuti = KuotaCutiTahunan::where('user_id', $userId)->first();

            if ($kuotaCuti) {
                Log::info('Found leave quota', [
                    'before_update' => [
                        'kuota_n' => $kuotaCuti->kuota_n,
                        'kuota_n1' => $kuotaCuti->kuota_n1,
                        'kuota_n2' => $kuotaCuti->kuota_n2
                    ]
                ]);
                
                // Logika untuk mengembalikan kuota
                // Prioritas: N terlebih dahulu, kemudian N1, lalu N2
                $sisaKuota = $lamaCuti;
                $kuotaN = $kuotaCuti->kuota_n;
                $kuotaN1 = $kuotaCuti->kuota_n1;
                $kuotaN2 = $kuotaCuti->kuota_n2;

                // Kembalikan kuota sesuai prioritas
                if ($sisaKuota > 0) {
                    $tambahN = min($sisaKuota, 12 - $kuotaN);
                    $kuotaN += $tambahN;
                    $sisaKuota -= $tambahN;
                    Log::info('Added to N quota', ['amount' => $tambahN, 'new_n' => $kuotaN]);
                }

                if ($sisaKuota > 0) {
                    $tambahN1 = min($sisaKuota, 3 - $kuotaN1);
                    $kuotaN1 += $tambahN1;
                    $sisaKuota -= $tambahN1;
                    Log::info('Added to N1 quota', ['amount' => $tambahN1, 'new_n1' => $kuotaN1]);
                }

                if ($sisaKuota > 0) {
                    $tambahN2 = min($sisaKuota, 3 - $kuotaN2);
                    $kuotaN2 += $tambahN2;
                    Log::info('Added to N2 quota', ['amount' => $tambahN2, 'new_n2' => $kuotaN2]);
                }

                // Set catatan
                $catatan = $kuotaCuti->catatan ?? '';
                $catatan .= "\nKuota cuti dikembalikan karena pengajuan ditolak/ditangguhkan oleh Ketua Tim Kerja pada " . now()->format('d-m-Y H:i:s');

                // Update kuota cuti
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
            Log::error('Error restoring leave quota', [
                'admin_status_id' => $adminStatusId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    // Other methods...
}