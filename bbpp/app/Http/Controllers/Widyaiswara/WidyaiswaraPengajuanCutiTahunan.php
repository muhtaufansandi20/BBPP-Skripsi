<?php

namespace App\Http\Controllers\Widyaiswara;

use App\Models\User;
use App\Models\MasaKerja;
use Illuminate\Http\Request;
use App\Models\KuotaCutiTahunan;
use App\Models\StatusCutiTahunan;
use App\Http\Controllers\Controller;
use App\Models\PengajuanCutiTahunan;
use Illuminate\Support\Facades\Auth;

class WidyaiswaraPengajuanCutiTahunan extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $userId = Auth::user()->id;
        $hasWorkPeriod = MasaKerja::where('user_id', $userId)->exists();
        $admin = User::where('role', 'admin')->first();
        
        
        $pengajuancutitahunan = PengajuanCutiTahunan::with([
            'ctStatusUserAdmin',
            'ctStatusUserAdmin.ctStatusAdminKabal' // Direct relationship for Kabag to Kabal
        ])
        ->where('user_id', $userId)
        ->where('is_kabag', true)
        ->orderBy('created_at', 'desc')
        ->get();
        
        // Cek verifikasi kuota cuti
        $checkVerifikasi = KuotaCutiTahunan::where('user_id', $userId)->first();
        
        // Ambil informasi status approval untuk tiap pengajuan
        foreach ($pengajuancutitahunan as $cuti) {
            // Status default
            $cuti->adminStatus = 'Belum diproses';
            $cuti->kabalStatus = 'Belum diproses';
            
            // Ambil status admin jika ada
            if ($cuti->ctStatusUserAdmin) {
                $cuti->adminStatus = $cuti->ctStatusUserAdmin->status;
                
                // Untuk kepala bagian, langsung cek approval kabal
                if ($cuti->ctStatusUserAdmin->ctStatusAdminKabal) {
                    $cuti->kabalStatus = $cuti->ctStatusUserAdmin->ctStatusAdminKabal->status;
                }
            }
        }
        
        return view('dashboard.widyaiswara.datapengajuancutitahunan-widyaiswara', compact('pengajuancutitahunan', 'checkVerifikasi', 'hasWorkPeriod', 'admin', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $userId = Auth::user()->id;
        $checkUser = MasaKerja::where('user_id', $userId)->exists();
        $masakerja = MasaKerja::where('user_id', $userId)->first();

        // Ambil data kuota cuti tahunan
        $kuotaCuti = KuotaCutiTahunan::where('user_id', $userId)->first();

        return view('dashboard.widyaiswara.createpengajuancutitahunan-widyaiswara', compact('checkUser', 'user', 'masakerja', 'kuotaCuti'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) 
    {
        // Validasi input
        $request->validate([
            'user_id' => 'required',
            'tgl_pengajuan' => 'required|date',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
            'lama_cuti' => 'required|numeric|min:1',
            'alasan' => 'required|string',
            'alamat_saat_cuti' => 'required|string',
            'no_hp_cuti' => 'required|string',
            'masa_kerja' => 'required'
        ]); 
        
        // Simpan data pengajuan cuti dengan flag is_kabag = true
        $pengajuanCuti = PengajuanCutiTahunan::create([
            'user_id' => $request->input('user_id'),
            'tgl_pengajuan' => $request->input('tgl_pengajuan'),
            'tgl_mulai' => $request->input('tgl_mulai'),
            'tgl_selesai' => $request->input('tgl_selesai'),
            'lama_cuti' => $request->input('lama_cuti'),
            'alasan' => $request->input('alasan'),
            'alamat_saat_cuti' => $request->input('alamat_saat_cuti'),
            'no_hp_cuti' => $request->input('no_hp_cuti'),
            'masa_kerja' => $request->input('masa_kerja'),
            'is_kabag' => true, 
        ]);
        
        // Tambahkan status pengajuan cuti dengan ID yang baru dibuat
        StatusCutiTahunan::create([
            'id_cuti_tahunan' => $pengajuanCuti->id,
            'status' => 'diajukan',
            'catatan' => null
        ]);

        // Ambil data user & lama cuti
        $userId = $request->input('user_id');
        $lamaCuti = (int) $request->input('lama_cuti');

        // Ambil kuota cuti user
        $kalkulasi_kuota_cuti_tahunan = KuotaCutiTahunan::where('user_id', $userId)->first();

        if (!$kalkulasi_kuota_cuti_tahunan) {
            return redirect()->back()->with('error', 'Kuota cuti tahunan tidak ditemukan.');
        }

        $n2 = (int) $kalkulasi_kuota_cuti_tahunan->kuota_n2;
        $n1 = (int) $kalkulasi_kuota_cuti_tahunan->kuota_n1;
        $n = (int) $kalkulasi_kuota_cuti_tahunan->kuota_n;

        // Proses pengurangan cuti
        if ($lamaCuti > 0) {
            // Gunakan n2 dulu
            if ($n2 > 0) {
                $dikurangkan = min($lamaCuti, $n2);
                $n2 -= $dikurangkan;
                $lamaCuti -= $dikurangkan;
            }

            // Gunakan n1 jika masih ada sisa cuti
            if ($lamaCuti > 0 && $n1 > 0) {
                $dikurangkan = min($lamaCuti, $n1);
                $n1 -= $dikurangkan;
                $lamaCuti -= $dikurangkan;
            }

            // Gunakan n jika masih ada sisa cuti
            if ($lamaCuti > 0 && $n > 0) {
                $dikurangkan = min($lamaCuti, $n);
                $n -= $dikurangkan;
                $lamaCuti -= $dikurangkan;
            }
        }

        // Update kuota cuti di database
        $kalkulasi_kuota_cuti_tahunan->update([
            'kuota_n2' => $n2,
            'kuota_n1' => $n1,
            'kuota_n' => $n
        ]);

        return redirect()->route('widyaiswarapengajuancutitahunan.index')->with('success', 'Pengajuan Cuti berhasil diajukan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pengajuancutitahunan = PengajuanCutiTahunan::with([
            'user',
            'ctStatusUserAdmin',
            'ctStatusUserAdmin.ctStatusAdminKabal' // Direct relationship for Kabag to Kabal
        ])->where('id', $id)->firstOrFail();

            // Cek status pembatalan
            $statusPembatalan = 'Belum dibatalkan';
            $catatanPembatalan = 'Tidak ada catatan';
            
            if ($pengajuancutitahunan->statusCutiTahunan) {
                $statusPembatalan = $pengajuancutitahunan->statusCutiTahunan->status;
                $catatanPembatalan = $pengajuancutitahunan->statusCutiTahunan->catatan ?? 'Tidak ada catatan';
            }

    
        // Default nilai untuk pejabat terkait
        $kepalaBalaiNama = 'Tidak ditemukan';
        $kepalaBalaiNIP = '-';
        $kepalaBalaiJabatan = '-';
    
        // Default status dan catatan
        $statusAdmin = 'Belum diproses';
        $statusKabal = 'Belum diproses';
    
        $catatanAdmin = 'Tidak ada catatan';
        $catatanKabal = 'Tidak ada catatan';
    
        // Mencari Kepala Balai
        $kepalaBalai = User::where('role', 'Kepalabalai')->first();
        if ($kepalaBalai) {
            $kepalaBalaiNama = $kepalaBalai->name;
            $kepalaBalaiNIP = $kepalaBalai->nip;
            $kepalaBalaiJabatan = $kepalaBalai->jabatan;
        }
    
        // Mengambil status & catatan pengajuan cuti di berbagai level persetujuan 
        if ($pengajuancutitahunan->ctStatusUserAdmin) {
            $statusAdmin = $pengajuancutitahunan->ctStatusUserAdmin->status ?? 'Belum diproses';
            $catatanAdmin = $pengajuancutitahunan->ctStatusUserAdmin->catatan ?? 'Tidak ada catatan';
            
            // Untuk kepala bagian, langsung cek approval kabal
            if ($pengajuancutitahunan->ctStatusUserAdmin->ctStatusAdminKabal) {
                $statusKabal = $pengajuancutitahunan->ctStatusUserAdmin->ctStatusAdminKabal->status ?? 'Belum diproses';
                $catatanKabal = $pengajuancutitahunan->ctStatusUserAdmin->ctStatusAdminKabal->catatan ?? 'Tidak ada catatan';
            }
        }
    
        return view('dashboard.widyaiswara.detailpengajuancutitahunan-widyaiswara', compact(
            'pengajuancutitahunan',
            'kepalaBalaiNama',
            'kepalaBalaiNIP',
            'kepalaBalaiJabatan',
            'statusAdmin',
            'statusKabal',
            'catatanAdmin',
            'catatanKabal',
            'statusPembatalan',
            'catatanPembatalan'
        ));
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

    public function destroy(string $id)
    {
        try {
            $user = Auth::user(); // Dapatkan user yang sedang login
            
            // Cek apakah pengajuan cuti ada dan milik user yang login
            $pengajuanCuti = PengajuanCutiTahunan::where('id', $id)
                ->where('user_id', $user->id)
                ->where('is_kabag', true) // Pastikan ini pengajuan kepala bagian
                ->first();
                
            if (!$pengajuanCuti) {
                return redirect()->route('widyaiswarapengajuancutitahunan.index')
                    ->with('error', "❌ Error: Pengajuan cuti dengan ID $id tidak ditemukan atau bukan milik Anda.");
            }
            
            // Cek apakah sudah disetujui oleh Admin
            $isApprovedByAdmin = false;
            if ($pengajuanCuti->ctStatusUserAdmin && $pengajuanCuti->ctStatusUserAdmin->status == 'disetujui') {
                $isApprovedByAdmin = true;
            }
            
            // Jika sudah disetujui oleh Admin, cegah penghapusan
            if ($isApprovedByAdmin) {
                return redirect()->route('widyaiswarapengajuancutitahunan.index')
                    ->with('error', "❌ Error: Pengajuan cuti yang sudah disetujui oleh Admin tidak dapat dihapus.");
            }
            
            // Cek apakah sudah dibatalkan
            $isCanceled = false;
            if ($pengajuanCuti->statusCutiTahunan && $pengajuanCuti->statusCutiTahunan->status == 'dibatalkan') {
                $isCanceled = true;
            }
            
            // Jika sudah dibatalkan, cegah penghapusan
            if ($isCanceled) {
                return redirect()->route('widyaiswarapengajuancutitahunan.index')
                    ->with('error', "❌ Error: Pengajuan cuti yang sudah dibatalkan tidak dapat dihapus.");
            }
            
            // Kembalikan kuota cuti
            $this->restoreLeaveQuota($id);
            
            // Hapus status cuti terkait jika ada
            StatusCutiTahunan::where('id_cuti_tahunan', $id)->delete();
            
            // Hapus pengajuan cuti
            $pengajuanCuti->delete();
            
            return redirect()->route('widyaiswarapengajuancutitahunan.index')
                ->with('success', "✅ Pengajuan cuti dengan ID $id berhasil dihapus dan kuota cuti telah dikembalikan.");
                
        } catch (\Exception $e) {
            // Log error
            \Illuminate\Support\Facades\Log::error("Error menghapus pengajuan cuti: " . $e->getMessage());
            
            // Kembalikan dengan pesan error
            return redirect()->route('widyaiswarapengajuancutitahunan.index')
                ->with('error', "❌ Terjadi kesalahan saat menghapus pengajuan cuti. Silakan hubungi administrator.");
        }
    }

    public function cancel($id)
    {
        try {
            $user = Auth::user(); // Get current logged in user

            // Check if the leave application exists and belongs to the current user
            $pengajuancutitahunan = PengajuanCutiTahunan::where('id', $id)
                ->where('user_id', $user->id)
                ->where('is_kabag', true) // Make sure it's a kepala bagian application
                ->first();

            if (!$pengajuancutitahunan) {
                return redirect()->route('widyaiswarapengajuancutitahunan.index')
                    ->with('error', "❌ Error: Pengajuan cuti dengan ID $id tidak ditemukan atau bukan milik Anda.");
            }

            // Check if the leave application has already been canceled
            if ($pengajuancutitahunan->statusCutiTahunan && $pengajuancutitahunan->statusCutiTahunan->status == 'dibatalkan') {
                return redirect()->route('widyaiswarapengajuancutitahunan.index')
                    ->with('info', "ℹ️ Pengajuan cuti dengan ID $id sudah dibatalkan sebelumnya.");
            }

            // Check if already approved by Kepala Balai
            $isApprovedByKabal = false;
            if ($pengajuancutitahunan->ctStatusUserAdmin && 
                $pengajuancutitahunan->ctStatusUserAdmin->ctStatusAdminKabal && 
                $pengajuancutitahunan->ctStatusUserAdmin->ctStatusAdminKabal->status == 'disetujui') {
                $isApprovedByKabal = true;
            }

            // If approved by Kepala Balai, prevent cancellation
            if ($isApprovedByKabal) {
                return redirect()->route('widyaiswarapengajuancutitahunan.index')
                    ->with('error', "❌ Error: Pengajuan cuti yang sudah disetujui oleh Kepala Balai tidak dapat dibatalkan.");
            }

            // Restore leave quota using the proper priority logic
            $this->restoreLeaveQuota($id);

            // Update or create status record to mark as canceled
            StatusCutiTahunan::updateOrCreate(
                ['id_cuti_tahunan' => $id],
                [
                    'status' => 'dibatalkan',
                    'catatan' => 'Dibatalkan oleh kepala bagian pada ' . now()->format('d-m-Y H:i:s')
                ]
            );

            return redirect()->route('widyaiswarapengajuancutitahunan.index')
                ->with('success', "✅ Pengajuan cuti dengan ID $id berhasil dibatalkan dan kuota cuti telah dikembalikan.");
        } catch (\Exception $e) {
            // Log the error
            \Illuminate\Support\Facades\Log::error("Error canceling leave application: " . $e->getMessage());
            
            // Return with error message
            return redirect()->route('widyaiswarapengajuancutitahunan.index')
                ->with('error', "❌ Terjadi kesalahan saat membatalkan pengajuan cuti. Silakan hubungi administrator.");
        }
    }

    /**
     * Restore leave quota with proper prioritization
     * 
     * @param int $pengajuanId The ID of the leave application
     * @return void
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
                'catatan' => $kuotaCuti->catatan . "\nKuota cuti dikembalikan karena pengajuan dibatalkan pada " . now()->format('d-m-Y H:i:s')
            ]);
        }
    }
}
