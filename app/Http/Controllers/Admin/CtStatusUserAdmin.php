<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CtStatusUserAdmin as ModelsCtStatusUserAdmin;
use App\Models\PengajuanCutiTahunan;
use App\Models\KuotaCutiTahunan;
use Illuminate\Http\Request;

class CtStatusUserAdmin extends Controller
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

        $pengajuanId = $request->input('id_pengajuan_cuti_tahunan');
        $status = $request->input('status');
        
        // Simpan ke database
        ModelsCtStatusUserAdmin::create([
            'status' => $status,
            'id_pengajuan_cuti_tahunan' => $pengajuanId,
            'catatan' => $request->input('catatan'),
        ]);

        // Jika status 'Ditolak' atau 'Ditangguhkan', kembalikan kuota cuti
        if ($status === 'Ditolak' || $status === 'Ditangguhkan') {
            $this->restoreLeaveQuota($pengajuanId);
        }

        // Redirect dengan pesan sukses
        return redirect()->route('adminpengajuancutitahunan.index')->with('success', 'Status pengajuan cuti berhasil diperbarui.');
    }

    /**
     * Restore leave quota when application is rejected
     */
    private function restoreLeaveQuota($pengajuanId)
    {
        // Ambil data pengajuan cuti
        $pengajuan = PengajuanCutiTahunan::findOrFail($pengajuanId);
        $userId = $pengajuan->user_id;
        $lamaCuti = $pengajuan->lama_cuti;

        // Ambil data kuota cuti
        $kuotaCuti = KuotaCutiTahunan::where('user_id', $userId)->first();

        if ($kuotaCuti) {
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
            }

            if ($sisaKuota > 0) {
                $tambahN1 = min($sisaKuota, 3 - $kuotaN1);
                $kuotaN1 += $tambahN1;
                $sisaKuota -= $tambahN1;
            }

            if ($sisaKuota > 0) {
                $tambahN2 = min($sisaKuota, 3 - $kuotaN2);
                $kuotaN2 += $tambahN2;
            }

            // Update kuota cuti
            $kuotaCuti->update([
                'kuota_n' => $kuotaN,
                'kuota_n1' => $kuotaN1,
                'kuota_n2' => $kuotaN2,
                'catatan' => $kuotaCuti->catatan . "\nKuota cuti dikembalikan karena pengajuan ditolak/ditangguhkan pada " . now()->format('d-m-Y H:i:s')
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
}