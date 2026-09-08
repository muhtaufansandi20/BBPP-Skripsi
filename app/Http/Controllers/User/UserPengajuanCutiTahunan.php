<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\MasaKerja;
use App\Models\AnggotaTim;
use App\Models\LogEditKct;
use Illuminate\Http\Request;
use App\Models\KuotaCutiTahunan;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\PengajuanCutiTahunan;
use Illuminate\Support\Facades\Auth;
use App\Models\StatusCutiTahunan;

class UserPengajuanCutiTahunan extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $userId = $user->id;
        
        // Check if user has a team
        $hasTeam = AnggotaTim::where('user_id', $userId)->exists();
        
        $pengajuancutitahunan = PengajuanCutiTahunan::with([
            'ctStatusUserAdmin.ctStatusAdminKatimker.ctStatusKatimkerKabag.ctStatusKabagKabal',
            'statusCutiTahunan'
        ])->where('user_id', $userId)->get();
        
        $checkVerifikasi = KuotaCutiTahunan::where('user_id', $userId)->first();
        
        // Get admin user for WhatsApp contact
        $admin = User::where('role', 'admin')->first();
        $hasWorkPeriod = MasaKerja::where('user_id', $userId)->exists();
        
        return view('dashboard.user.datapengajuancutitahunan-user', compact(
            'pengajuancutitahunan', 
            'checkVerifikasi', 
            'hasTeam',
            'user',
            'admin',
            'hasWorkPeriod'
        ));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $userId = $user->id;
        $checkUser = MasaKerja::where('user_id', $userId)->exists();
        $masakerja = MasaKerja::where('user_id', $userId)->first();

        // Ambil data kuota cuti tahunan
        $kuotaCuti = KuotaCutiTahunan::where('user_id', $userId)->first();

        return view('dashboard.user.createpengajuancutitahunan-user', compact('user', 'checkUser', 'masakerja', 'kuotaCuti'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) 
    {
        // Simpan data pengajuan cuti
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
        ]);

        // Tambahkan status pengajuan cuti
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
        $n  = (int) $kalkulasi_kuota_cuti_tahunan->kuota_n;

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
            'kuota_n'  => $n
        ]);

        return redirect()->route('userpengajuancutitahunan.index')->with('success', 'Pengajuan Cuti berhasil diajukan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pengajuancutitahunan = PengajuanCutiTahunan::with([
            'user',
            'ctStatusUserAdmin.ctStatusAdminKatimker.ctStatusKatimkerKabag.ctStatusKabagKabal',
            'statusCutiTahunan'
        ])->where('id', $id)->firstOrFail();

        // Default nilai pejabat jika tidak ditemukan
        $ketuaNama = 'Tidak ditemukan';
        $ketuaNIP = '-';
        $ketuaJabatan = '-';
        $kepalaBagianNama = 'Tidak ditemukan';
        $kepalaBagianNIP = '-';
        $kepalaBagianJabatan = '-';
        $kepalaBalaiNama = 'Tidak ditemukan';
        $kepalaBalaiNIP = '-';
        $kepalaBalaiJabatan = '-';

        // Cek status pembatalan
        $statusPembatalan = 'Belum dibatalkan';
        $catatanPembatalan = 'Tidak ada catatan';
        
        if ($pengajuancutitahunan->statusCutiTahunan) {
            $statusPembatalan = $pengajuancutitahunan->statusCutiTahunan->status;
            $catatanPembatalan = $pengajuancutitahunan->statusCutiTahunan->catatan ?? 'Tidak ada catatan';
        }

        // Mencari anggota tim yang mengajukan cuti
        $anggotaTim = AnggotaTim::where('user_id', $pengajuancutitahunan->user_id)->first();

        if ($anggotaTim) {
            $ketuaTim = AnggotaTim::where('tim_id', $anggotaTim->tim_id)
                ->where('role', 'Ketua')
                ->with('user')
                ->first();

            if ($ketuaTim) {
                $ketuaNama = $ketuaTim->user->name ?? 'Tidak ada nama';
                $ketuaNIP = $ketuaTim->user->nip ?? '-';
                $ketuaJabatan = $ketuaTim->user->jabatan ?? '-';
            }
        }

        // Mencari Kepala Bagian
        $kepalaBagian = User::where('role', 'Kepalabagian')->first();
        if ($kepalaBagian) {
            $kepalaBagianNama = $kepalaBagian->name;
            $kepalaBagianNIP = $kepalaBagian->nip;
            $kepalaBagianJabatan = $kepalaBagian->jabatan;
        }

        // Mencari Kepala Balai
        $kepalaBalai = User::where('role', 'Kepalabalai')->first();
        if ($kepalaBalai) {
            $kepalaBalaiNama = $kepalaBalai->name;
            $kepalaBalaiNIP = $kepalaBalai->nip;
            $kepalaBalaiJabatan = $kepalaBalai->jabatan;
        }

        // Mengambil status & catatan tiap level
        $statusAdmin = $pengajuancutitahunan->ctStatusUserAdmin->status ?? 'Belum diproses';
        $statusKatimker = optional($pengajuancutitahunan->ctStatusUserAdmin)->ctStatusAdminKatimker->status ?? 'Belum diproses';
        $statusKabag = optional(optional($pengajuancutitahunan->ctStatusUserAdmin)->ctStatusAdminKatimker)->ctStatusKatimkerKabag->status ?? 'Belum diproses';
        $statusKabal = optional(optional(optional($pengajuancutitahunan->ctStatusUserAdmin)->ctStatusAdminKatimker)->ctStatusKatimkerKabag)->ctStatusKabagKabal->status ?? 'Belum diproses';

        $catatanAdmin = $pengajuancutitahunan->ctStatusUserAdmin->catatan ?? 'Tidak ada catatan';
        $catatanKatimker = optional($pengajuancutitahunan->ctStatusUserAdmin)->ctStatusAdminKatimker->catatan ?? 'Tidak ada catatan';
        $catatanKabag = optional(optional($pengajuancutitahunan->ctStatusUserAdmin)->ctStatusAdminKatimker)->ctStatusKatimkerKabag->catatan ?? 'Tidak ada catatan';
        $catatanKabal = optional(optional(optional($pengajuancutitahunan->ctStatusUserAdmin)->ctStatusAdminKatimker)->ctStatusKatimkerKabag)->ctStatusKabagKabal->catatan ?? 'Tidak ada catatan';

        return view('dashboard.user.detailpengajuancutitahunan-user', compact(
            'pengajuancutitahunan', 
            'ketuaNama', 
            'ketuaNIP', 
            'ketuaJabatan', 
            'kepalaBagianNama', 
            'kepalaBagianNIP', 
            'kepalaBagianJabatan', 
            'kepalaBalaiNama', 
            'kepalaBalaiNIP', 
            'kepalaBalaiJabatan', 
            'statusAdmin', 
            'statusKatimker', 
            'statusKabag', 
            'statusKabal', 
            'catatanAdmin', 
            'catatanKatimker', 
            'catatanKabag', 
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

    /**
     * Cancel leave application
     */
    public function cancel($id)
    {
        try {
            $user = Auth::user();

            // Ambil data pengajuan milik user yang login
            $pengajuancutitahunan = PengajuanCutiTahunan::where('id', $id)
                ->where('user_id', $user->id)
                ->first();

            if (!$pengajuancutitahunan) {
                return redirect()->route('userpengajuancutitahunan.index')
                    ->with('error', "❌ Error: Pengajuan cuti tidak ditemukan atau bukan milik Anda.");
            }

            // Cek jika statusnya sudah pernah dibatalkan
            if ($pengajuancutitahunan->statusCutiTahunan && strtolower($pengajuancutitahunan->statusCutiTahunan->status) === 'dibatalkan') {
                return redirect()->route('userpengajuancutitahunan.index')
                    ->with('info', "ℹ️ Pengajuan cuti ini sudah dibatalkan sebelumnya.");
            }

            // Kembalikan kuota cuti ke database
            $this->restoreLeaveQuota($id);

            // Perbarui atau buat status 'dibatalkan'
            StatusCutiTahunan::updateOrCreate(
                ['id_cuti_tahunan' => $id],
                [
                    'status'  => 'dibatalkan',
                    'catatan' => 'Dibatalkan oleh user pada ' . now()->format('d-m-Y H:i:s')
                ]
            );

            return redirect()->route('userpengajuancutitahunan.index')
                ->with('success', "✅ Pengajuan cuti berhasil dibatalkan dan kuota cuti telah dikembalikan.");
        } catch (\Exception $e) {
            Log::error("Error canceling leave application: " . $e->getMessage());

            return redirect()->route('userpengajuancutitahunan.index')
                ->with('error', "❌ Terjadi kesalahan saat membatalkan pengajuan cuti: " . $e->getMessage());
        }
    }

    /**
     * Restore leave quota with proper prioritization
     *
     * @param int $pengajuanId
     * @return void
     */
    private function restoreLeaveQuota($pengajuanId)
    {
        $pengajuan = PengajuanCutiTahunan::findOrFail($pengajuanId);
        $userId = $pengajuan->user_id;
        $lamaCuti = (int) $pengajuan->lama_cuti;

        $kuotaCuti = KuotaCutiTahunan::where('user_id', $userId)->first();

        if ($kuotaCuti && $lamaCuti > 0) {
            $sisaKuota = $lamaCuti;
            $kuotaN  = (int) $kuotaCuti->kuota_n;
            $kuotaN1 = (int) $kuotaCuti->kuota_n1;
            $kuotaN2 = (int) $kuotaCuti->kuota_n2;

            // 1. Kembalikan ke N (Maksimal kapasitas 12)
            if ($sisaKuota > 0) {
                $tambahN = min($sisaKuota, max(0, 12 - $kuotaN));
                $kuotaN += $tambahN;
                $sisaKuota -= $tambahN;
            }

            // 2. Kembalikan ke N-1 jika N sudah penuh (Maksimal kapasitas 3)
            if ($sisaKuota > 0) {
                $tambahN1 = min($sisaKuota, max(0, 3 - $kuotaN1));
                $kuotaN1 += $tambahN1;
                $sisaKuota -= $tambahN1;
            }

            // 3. Kembalikan ke N-2 jika N-1 sudah penuh (Maksimal kapasitas 3)
            if ($sisaKuota > 0) {
                $tambahN2 = min($sisaKuota, max(0, 3 - $kuotaN2));
                $kuotaN2 += $tambahN2;
                $sisaKuota -= $tambahN2;
            }

            // Catat log riwayat
            $timestamp = now();
            $catatanBaru = "Kuota cuti dikembalikan {$lamaCuti} hari karena pengajuan cuti (ID: {$pengajuanId}) dibatalkan pada " . $timestamp->format('d-m-Y H:i:s');
            $catatanLengkap = trim(($kuotaCuti->catatan ?? '') . "\n" . $catatanBaru);

            // Simpan perubahan kuota ke database
            $kuotaCuti->update([
                'kuota_n'  => $kuotaN,
                'kuota_n1' => $kuotaN1,
                'kuota_n2' => $kuotaN2,
                'catatan'  => $catatanLengkap
            ]);

            // Catat ke LogEditKct (diisolasi agar bila gagal tidak menggagalkan update kuota)
            try {
                LogEditKct::create([
                    'id_kuota_cuti_tahunan' => $kuotaCuti->id,
                    'date_edit'             => $timestamp->format('Y-m-d'),
                    'time_edit'             => $timestamp->format('H:i:s')
                ]);
            } catch (\Exception $logEx) {
                Log::warning("Gagal mencatat LogEditKct: " . $logEx->getMessage());
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $user = Auth::user();

            $pengajuancutitahunan = PengajuanCutiTahunan::where('id', $id)
                ->where('user_id', $user->id)
                ->first();

            if (!$pengajuancutitahunan) {
                return redirect()->route('userpengajuancutitahunan.index')
                    ->with('error', "❌ Error: Pengajuan cuti dengan ID $id tidak ditemukan atau bukan milik Anda.");
            }

            // Cek apakah sudah diverifikasi admin
            if ($pengajuancutitahunan->ctStatusUserAdmin) {
                return redirect()->route('userpengajuancutitahunan.index')
                    ->with('error', "❌ Error: Pengajuan cuti sudah diverifikasi admin dan tidak dapat dihapus.");
            }

            // Kembalikan kuota cuti jika status belum dibatalkan
            $statusBatal = $pengajuancutitahunan->statusCutiTahunan && strtolower($pengajuancutitahunan->statusCutiTahunan->status) === 'dibatalkan';
            if (!$statusBatal) {
                $this->restoreLeaveQuota($id);
            }

            // Hapus record status jika ada
            if ($pengajuancutitahunan->statusCutiTahunan) {
                $pengajuancutitahunan->statusCutiTahunan->delete();
            }

            // Hapus pengajuan cuti
            $pengajuancutitahunan->delete();

            return redirect()->route('userpengajuancutitahunan.index')
                ->with('success', "✅ Pengajuan cuti berhasil dihapus.");
        } catch (\Exception $e) {
            Log::error("Error deleting leave application: " . $e->getMessage());

            return redirect()->route('userpengajuancutitahunan.index')
                ->with('error', "❌ Terjadi kesalahan saat menghapus pengajuan cuti. Silakan hubungi administrator.");
        }
    }
}