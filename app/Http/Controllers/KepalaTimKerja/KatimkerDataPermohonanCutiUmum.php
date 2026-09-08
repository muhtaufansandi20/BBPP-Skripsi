<?php

namespace App\Http\Controllers\KepalaTimKerja;

use App\Models\User;
use App\Models\Lampiran;
use App\Models\AnggotaTim;
use Illuminate\Http\Request;
use App\Models\CuStatusUserAdmin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\CuStatusAdminKatimker;

class KatimkerDataPermohonanCutiUmum extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        // Ambil data kepala tim
        $timKepala = AnggotaTim::where('user_id', $user->id)
                        ->where('role', 'Ketua')
                        ->first();

        // Jika bukan kepala tim, tetap kirim ke view tapi kosongkan datanya
        if (!$timKepala) {
            return view('dashboard.kepalatimkerja.datapermohonancutiumum-katimker', [
                'pendingApplications' => collect([]),
                'completedApplications' => collect([]),
                'timKepala' => null
            ]);
        }

        // Query dasar
        $baseQuery = CuStatusUserAdmin::select(
            'users.name',
            'users.nip',
            'users.jabatan',
            'jenis_cuti.nama_cuti',
            'pengajuan_cuti_umums.tgl_pengajuan',
            'pengajuan_cuti_umums.tgl_mulai',
            'pengajuan_cuti_umums.tgl_selesai', 
            'pengajuan_cuti_umums.jumlah_hari',
            'pengajuan_cuti_umums.alasan',
            'cu_status_user_admins.id',
            'cu_status_admin_katimkers.status as status_katimker',
            'status_cuti_umums.status as status_cuti'
        )
        ->leftJoin('pengajuan_cuti_umums', 'cu_status_user_admins.id_pengajuan_cuti_umum', '=', 'pengajuan_cuti_umums.id')
        ->leftJoin('users', 'pengajuan_cuti_umums.user_id', '=', 'users.id')
        ->leftJoin('jenis_cuti', 'pengajuan_cuti_umums.jeniscuti_id', '=', 'jenis_cuti.id')
        ->join('anggota_tims', 'users.id', '=', 'anggota_tims.user_id')
        ->leftJoin('cu_status_admin_katimkers', 'cu_status_admin_katimkers.cu_status_user_admin_id', '=', 'cu_status_user_admins.id')
        ->leftJoin('status_cuti_umums', 'status_cuti_umums.id_cuti_umum', '=', 'pengajuan_cuti_umums.id')
        ->where('cu_status_user_admins.status', 'disetujui')
        ->where('anggota_tims.tim_id', $timKepala->tim_id)
        ->where('pengajuan_cuti_umums.is_katimker', false)
        ->where('pengajuan_cuti_umums.is_kabag', false);

        // Aplikasi yang menunggu persetujuan
        $pendingApplications = (clone $baseQuery)
            ->where(function ($query) {
                $query->where('status_cuti_umums.status', 'diajukan')
                    ->where(function ($sub) {
                        $sub->whereNull('cu_status_admin_katimkers.status')
                            ->orWhere('cu_status_admin_katimkers.status', 'menunggu');
                    });
            })
            ->get();

        // Aplikasi yang sudah diproses
        $completedApplications = (clone $baseQuery)
            ->whereIn('cu_status_admin_katimkers.status', ['disetujui', 'ditolak', 'perubahan', 'ditangguhkan'])
            ->where('status_cuti_umums.status', 'diajukan')
            ->get();

        return view('dashboard.kepalatimkerja.datapermohonancutiumum-katimker', compact(
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
        // Ambil data pengajuan cuti berdasarkan ID
        $statuscuti = CuStatusUserAdmin::findOrFail($id);
        
        $custatususeradmin = CuStatusUserAdmin::where('cu_status_user_admins.id', $statuscuti->id)
            ->select(
                'users.name',
                'users.nip',
                'users.jabatan',
                'pengajuan_cuti_umums.tgl_pengajuan',
                'pengajuan_cuti_umums.tgl_mulai',
                'pengajuan_cuti_umums.tgl_selesai',
                'pengajuan_cuti_umums.jumlah_hari',
                'pengajuan_cuti_umums.alasan',
                'pengajuan_cuti_umums.user_id',
                'cu_status_user_admins.id',
                'pengajuan_cuti_umums.alamat_saat_cuti',
                'pengajuan_cuti_umums.no_hp_cuti',
                'pengajuan_cuti_umums.masa_kerja',
                'jenis_cuti.nama_cuti',
                'jenis_cuti.id as jeniscuti_id',
                'users.no_hp'
            )
            ->leftJoin('pengajuan_cuti_umums', 'cu_status_user_admins.id_pengajuan_cuti_umum', '=', 'pengajuan_cuti_umums.id')
            ->leftJoin('users', 'pengajuan_cuti_umums.user_id', '=', 'users.id')
            ->leftJoin('jenis_cuti', 'pengajuan_cuti_umums.jeniscuti_id', '=', 'jenis_cuti.id')
            ->join('anggota_tims', 'users.id', '=', 'anggota_tims.user_id')
            ->first();
        
        // Variabel fallback untuk ketua
        $ketuaNama = 'Tidak ditemukan';
        $ketuaNIP = '-';
        $ketuaJabatan = '-';

        // Di controller atau view

        // PERBAIKAN: Ambil ID pengajuan cuti umum yang benar
        $idPengajuanCuti = $statuscuti->id_pengajuan_cuti_umum;
        
        // Gunakan ID pengajuan cuti umum untuk mencari lampiran
        $lampiran = Lampiran::where('id_pengajuan_cuti', $idPengajuanCuti)->first();
        // dd($lampiran); // Data lampiran yang diambil
        // Mencari anggota tim yang mengajukan cuti
        $anggotaTim = AnggotaTim::where('user_id', $custatususeradmin->user_id)->first();

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

        // Cek apakah sudah diverifikasi oleh katimker
        $checkverifikasi = CuStatusAdminKatimker::where('cu_status_user_admin_id', $statuscuti->id)->first();

        // Kirim data ke view
        return view('dashboard.kepalatimkerja.detailpermohonancutiumum-katimker', compact(
            'custatususeradmin',
            'ketuaNama', 
            'ketuaNIP', 
            'ketuaJabatan',
            'lampiran', 
            'kepalaBagianUmum', 
            'checkverifikasi'
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
