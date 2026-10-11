<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Lampiran;
use App\Models\AnggotaTim;
use Illuminate\Http\Request;
use App\Models\CuStatusUserAdmin;
use App\Models\PengajuanCutiUmum;
use App\Http\Controllers\Controller;

class AdminPengajuanCutiUmum extends Controller
{ 
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil permohonan dengan status "diajukan" di statusCutiUmum
        $pengajuanDiajukan = PengajuanCutiUmum::with(['user', 'statusCutiUmum', 'jenisCuti'])
            ->whereHas('statusCutiUmum', function($query) {
                $query->where('status', 'diajukan');
            })
            ->orderBy('tgl_pengajuan', 'desc')
            ->get();
        
        // Kode untuk belumVerifikasi
        $belumVerifikasi = PengajuanCutiUmum::with(['user', 'StatusAdminUmum', 'jenisCuti'])
            ->whereHas('StatusAdminUmum', function($query) {
                $query->where('status', 'belum disetujui')
                    ->orWhere('status', 'perubahan');
            })
            ->orWhereDoesntHave('StatusAdminUmum')
            ->orderBy('tgl_pengajuan', 'desc')
            ->get();
        
        // Kode untuk sudahVerifikasi
        $sudahVerifikasi = PengajuanCutiUmum::with(['user', 'StatusAdminUmum', 'jenisCuti'])
            ->whereHas('StatusAdminUmum', function($query) {
                $query->whereIn('status', ['disetujui', 'ditangguhkan', 'ditolak']);
            })
            ->orderBy('tgl_pengajuan', 'desc')
            ->get();

        return view('dashboard.admin.pengajuancutiumum-admin', compact('pengajuanDiajukan', 'belumVerifikasi', 'sudahVerifikasi'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pengajuanumum = PengajuanCutiUmum::with('user', 'jenisCuti', 'StatusAdminUmum', 'statusCutiUmum')->findOrFail($id);
        $user = $pengajuanumum->user;

        // 1. Ambil data lampiran
        $lampiran = Lampiran::where('id_pengajuan_cuti', $id)->first();

        // 2. Data Admin (Ambil user dengan role admin)
        $adminUser = User::where('role', 'admin')->first();
        $adminNama = $adminUser->name ?? '-';
        $adminNIP  = $adminUser->nip ?? '-';
        
        // Ambil status admin jika ada relasinya
        $statusAdminModel = $pengajuanumum->StatusAdminUmum ?? null; 
        $statusAdmin = $statusAdminModel->status ?? 'Belum Memverifikasi';

        // 3. Data Ketua Tim Kerja
        $ketuaNama = 'Tidak ditemukan';
        $ketuaNIP = '-';
        $statusKatimker = 'Menunggu';
        $catatanKatimker = null;

        $anggotaTim = AnggotaTim::where('user_id', $user->id)->first();
        if ($anggotaTim) {
            $ketuaTim = AnggotaTim::where('tim_id', $anggotaTim->tim_id)
                ->where('role', 'Ketua')
                ->with('user')
                ->first();
            
            if ($ketuaTim && $ketuaTim->user) {
                $ketuaNama = $ketuaTim->user->name;
                $ketuaNIP  = $ketuaTim->user->nip;
            }
        }

        // 4. Data Kepala Bagian Umum
        $kabagUser = User::where('role', 'kepalabagian')->first();
        $kabagNama = $kabagUser->name ?? '-';
        $kabagNIP  = $kabagUser->nip ?? '-';
        $statusKabag = 'Menunggu';
        $catatanKabag = null;

        // 5. Data Kepala Balai
        $kabalaiUser = User::where('role', 'kepalabalai')->first();
        $kabalaiNama = $kabalaiUser->name ?? '-';
        $kabalaiNIP  = $kabalaiUser->nip ?? '-';
        $statusKabalai = 'Menunggu';
        $catatanKabalai = null;

        // Status Verifikasi Akhir / Admin
        $checkverifikasicutiumum = CuStatusUserAdmin::where('id_pengajuan_cuti_umum', $pengajuanumum->id)->first();

        return view('dashboard.admin.detailpengajuancutiumum-admin', compact(
            'pengajuanumum', 
            'lampiran', 
            'checkverifikasicutiumum',
            'adminNama', 'adminNIP', 'statusAdmin',
            'ketuaNama', 'ketuaNIP', 'statusKatimker', 'catatanKatimker',
            'kabagNama', 'kabagNIP', 'statusKabag', 'catatanKabag',
            'kabalaiNama', 'kabalaiNIP', 'statusKabalai', 'catatanKabalai'
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
        $request->validate([
            'jumlah_hari' => 'required|integer|min:1',
        ]);

        $pengajuan = PengajuanCutiUmum::findOrFail($id);
        $pengajuan->update([
            'jumlah_hari' => $request->jumlah_hari,
        ]);

        return redirect()->back()->with('success', 'Lama cuti berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}