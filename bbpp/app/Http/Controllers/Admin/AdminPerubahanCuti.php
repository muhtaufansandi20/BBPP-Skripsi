<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\PengajuanCutiTahunan;
use App\Models\KuotaCutiTahunan;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AdminPerubahanCuti extends Controller    
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data pengajuan cuti tahunan yang sudah disetujui oleh kabal
        $pengajuancutitahunan = PengajuanCutiTahunan::with(['user', 'statusAdmin', 'ctStatusUserAdmin'])
            ->whereHas('ctStatusUserAdmin', function ($query) {
                $query->whereHas('ctStatusAdminKatimker', function($katimker) {
                    $katimker->whereHas('ctStatusKatimkerKabag', function($katimkerkabag) {
                        $katimkerkabag->whereHas('ctStatusKabagKabal', function($kabagkabal) {
                            $kabagkabal->where('status', 'disetujui');
                        });
                    });
                })
                ->orWhereHas('ctStatusAdminKabal', function ($adminkabal) {
                    $adminkabal->where('status', 'disetujui');
                });
            })
            ->orderBy('created_at', 'desc')
            ->get(); 

        return view('dashboard.admin.dataperubahancuti-admin', compact('pengajuancutitahunan'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pengajuan = PengajuanCutiTahunan::with(['user', 'kuota'])->findOrFail($id);
        $kuotaCuti = $pengajuan->kuota;

        return view('dashboard.admin.editcutitahunan-admin', compact('pengajuan', 'kuotaCuti'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
            'lama_cuti' => 'required|integer|min:1',
            'catatan' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // Ambil data pengajuan cuti
            $pengajuan = PengajuanCutiTahunan::findOrFail($id);
            $lamaCutiLama = $pengajuan->lama_cuti;
            $lamaCutiBaru = $request->lama_cuti;
            $selisihHari = $lamaCutiLama - $lamaCutiBaru;
            
            // Update pengajuan cuti
            $pengajuan->tgl_mulai = $request->tgl_mulai;
            $pengajuan->tgl_selesai = $request->tgl_selesai;
            $pengajuan->lama_cuti = $lamaCutiBaru;
            $pengajuan->catatan = $request->catatan;
            $pengajuan->save();
            
            // Jika ada selisih hari, kembalikan kuota cuti
            if ($selisihHari > 0) {
                $kuotaCuti = KuotaCutiTahunan::where('user_id', $pengajuan->user_id)->first();
                
                // Prioritas pengembalian kuota: N, N1, N2
                $sisa = $selisihHari;
                
                // Kembalikan ke N sampai maksimal 12
                if ($sisa > 0 && $kuotaCuti->kuota_n < 12) {
                    $ruangN = 12 - $kuotaCuti->kuota_n;
                    $tambahN = min($ruangN, $sisa);
                    $kuotaCuti->kuota_n += $tambahN;
                    $sisa -= $tambahN;
                }
                
                // Jika masih ada sisa, kembalikan ke N1 sampai maksimal 3
                if ($sisa > 0 && $kuotaCuti->kuota_n1 < 3) {
                    $ruangN1 = 3 - $kuotaCuti->kuota_n1;
                    $tambahN1 = min($ruangN1, $sisa);
                    $kuotaCuti->kuota_n1 += $tambahN1;
                    $sisa -= $tambahN1;
                }
                
                // Jika masih ada sisa, kembalikan ke N2 sampai maksimal 3
                if ($sisa > 0 && $kuotaCuti->kuota_n2 < 3) {
                    $ruangN2 = 3 - $kuotaCuti->kuota_n2;
                    $tambahN2 = min($ruangN2, $sisa);
                    $kuotaCuti->kuota_n2 += $tambahN2;
                    $sisa -= $tambahN2;
                }
                
                $kuotaCuti->save();
            }
            
            DB::commit();
            return redirect()->route('adminperubahancuti.index')->with('success', 'Perubahan cuti berhasil disimpan dan kuota cuti telah disesuaikan.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }
}