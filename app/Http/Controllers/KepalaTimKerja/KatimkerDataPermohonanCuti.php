<?php

namespace App\Http\Controllers\KepalaTimKerja;

use App\Models\User;
use App\Models\AnggotaTim;
use Illuminate\Http\Request;
use App\Models\CtStatusUserAdmin;
use App\Models\PengajuanCutiUmum;
use App\Http\Controllers\Controller;
use App\Models\PengajuanCutiTahunan;
use App\Models\StatusCutiTahunan; // Added import for StatusCutiTahunan
use Illuminate\Support\Facades\Auth;
use App\Models\CtStatusAdminKatimker;

class KatimkerDataPermohonanCuti extends Controller
    {
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        // Coba ambil kepala tim, bisa null
        $timKepala = AnggotaTim::where('user_id', $user->id)
                    ->where('role', 'Ketua')
                    ->first();

        // Jika bukan kepala tim, tetap kirim view tapi kosongkan data permohonan
        if (!$timKepala) {
            return view('dashboard.kepalatimkerja.permohonancuti-katimker', [
                'pendingApplications' => collect([]),
                'completedApplications' => collect([]),
                'timKepala' => null
            ]);
        }

        // Jika kepala tim ditemukan, jalankan query
        $baseQuery = CtStatusUserAdmin::select(
            'users.name',
            'users.nip',
            'users.jabatan',
            'pengajuan_cuti_tahunans.tgl_pengajuan',
            'pengajuan_cuti_tahunans.tgl_mulai',
            'pengajuan_cuti_tahunans.tgl_selesai',
            'pengajuan_cuti_tahunans.lama_cuti',
            'pengajuan_cuti_tahunans.alasan', 
            'ct_status_user_admins.id',
            'ct_status_admin_katimkers.status as status_katimker',
            'status_cuti_tahunans.status as status_pengajuan'
        )
        ->leftJoin('pengajuan_cuti_tahunans', 'ct_status_user_admins.id_pengajuan_cuti_tahunan', '=', 'pengajuan_cuti_tahunans.id')
        ->leftJoin('users', 'pengajuan_cuti_tahunans.user_id', '=', 'users.id')
        ->join('anggota_tims', 'users.id', '=', 'anggota_tims.user_id')
        ->leftJoin('ct_status_admin_katimkers', 'ct_status_admin_katimkers.id_ct_status_user_admin', '=', 'ct_status_user_admins.id')
        ->leftJoin('status_cuti_tahunans', 'status_cuti_tahunans.id_cuti_tahunan', '=', 'pengajuan_cuti_tahunans.id')
        ->where('ct_status_user_admins.status', 'disetujui')
        ->where('anggota_tims.tim_id', $timKepala->tim_id)
        ->where('pengajuan_cuti_tahunans.is_katimker', false)
        ->where('pengajuan_cuti_tahunans.is_kabag', false);

        $pendingApplications = (clone $baseQuery)
            ->where(function($query) {
                $query->where('status_cuti_tahunans.status', 'diajukan')
                    ->where(function($subquery) {
                        $subquery->whereNull('ct_status_admin_katimkers.status')
                                ->orWhere('ct_status_admin_katimkers.status', 'menunggu');
                    });
            })
            ->get();

        $completedApplications = (clone $baseQuery)
            ->whereIn('ct_status_admin_katimkers.status', ['disetujui', 'ditolak', 'perubahan', 'ditangguhkan'])
            ->where('status_cuti_tahunans.status', 'diajukan')
            ->get();

        return view('dashboard.kepalatimkerja.permohonancuti-katimker', compact(
            'pendingApplications',
            'completedApplications',
            'timKepala'
        ));
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
    // Ambil data pengajuan cuti berdasarkan ID beserta data user
    $statuscuti = CtStatusUserAdmin::findOrFail($id);
    $ctstatususeradmin = CtStatusUserAdmin::where('ct_status_user_admins.id', $statuscuti->id)->select(
        'users.name',
        'users.nip',
        'users.jabatan',
        'pengajuan_cuti_tahunans.tgl_pengajuan',
        'pengajuan_cuti_tahunans.tgl_mulai',
        'pengajuan_cuti_tahunans.tgl_selesai',
        'pengajuan_cuti_tahunans.lama_cuti',
        'pengajuan_cuti_tahunans.alasan',
        'pengajuan_cuti_tahunans.user_id',
        'ct_status_user_admins.id',
        'pengajuan_cuti_tahunans.alamat_saat_cuti',
        'pengajuan_cuti_tahunans.no_hp_cuti',
        'pengajuan_cuti_tahunans.masa_kerja',
        'users.no_hp')
        ->leftjoin('pengajuan_cuti_tahunans', 'ct_status_user_admins.id_pengajuan_cuti_tahunan', '=', 'pengajuan_cuti_tahunans.id')
        ->leftjoin('users', 'pengajuan_cuti_tahunans.user_id', '=', 'users.id')
        ->join('anggota_tims', 'users.id', '=', 'anggota_tims.user_id')->first();
    
    // Variabel fallback untuk ketua
    $ketuaNama = 'Tidak ditemukan';
    $ketuaNIP = '-';

    // Mencari anggota tim yang mengajukan cuti
    $anggotaTim = AnggotaTim::where('user_id', $ctstatususeradmin->user_id)->first();

    // Jika anggota tim ditemukan, cari ketua tim
    if ($anggotaTim) {
        // Cari ketua tim berdasarkan tim_id yang sama
        $ketuaTim = AnggotaTim::where('tim_id', $anggotaTim->tim_id)
            ->where('role', 'Ketua') // Pastikan role adalah 'Ketua'
            ->with('user') // Mengambil data user yang terkait
            ->first();
        
        // Jika ketua tim ditemukan
        if ($ketuaTim) {
            $ketuaNama = $ketuaTim->user->name ?? 'Tidak ada nama';
            $ketuaNIP = $ketuaTim->user->nip ?? '-';
            $ketuaJabatan = $ketuaTim->user->jabatan ?? '-';
        }
    }

    // Ambil Kepala Bagian Umum berdasarkan role di tabel users
    $kepalaBagianUmum = User::where('role', 'kepalabagian')->first();
    $kepalabalai = User::where('role', 'kepalabalai')->first();

    $checkverifikasi = CtStatusAdminKatimker::where('id_ct_status_user_admin', $statuscuti->id)->first();

    // Kirim data ke view
    return view('dashboard.kepalatimkerja.detailpermohonancuti-katimker', compact('ctstatususeradmin','ketuaNama', 'ketuaNIP', 'ketuaJabatan', 'kepalaBagianUmum','kepalabalai', 'checkverifikasi'));
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
