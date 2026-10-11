<?php

namespace App\Http\Controllers\KepalaBagian;

use App\Models\User;
use App\Models\Lampiran;
use App\Models\AnggotaTim;
use Illuminate\Http\Request;
use App\Models\CuStatusUserAdmin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\CuStatusAdminKatimker;
use App\Models\CuStatusKatimkerKabag;

class KabagDataPermohonanCutiUmum extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index()
    { 
        // Get regular applications that have status "diajukan" in status_cuti_umum
        $cuStatusAdminKatimker = CuStatusAdminKatimker::with([
            'userAdmin.pengajuanCutiUmum.user',
            'userAdmin.pengajuanCutiUmum.jenisCuti',
            'userAdmin.pengajuanCutiUmum.statusCutiUmum', // Make sure this relationship exists
            'cuStatusKatimkerKabag'
        ])
        ->where('status', 'disetujui')
        ->whereHas('userAdmin.pengajuanCutiUmum.statusCutiUmum', function($query) {
            $query->where('status', 'diajukan');
        })
        ->get();
        
        // Get katimker applications that have been approved by admin but not by katimker yet
        // and have status "diajukan" in status_cuti_umum
        $katimkerApprovedByAdmin = CuStatusUserAdmin::with([
            'pengajuanCutiUmum.user',
            'pengajuanCutiUmum.statusCutiUmum' // Make sure this relationship exists
        ])
        ->where('status', 'disetujui')
        ->whereHas('pengajuanCutiUmum', function($query) {
            $query->where('is_katimker', true);
        })
        ->whereHas('pengajuanCutiUmum.statusCutiUmum', function($query) {
            $query->where('status', 'diajukan');
        })
        ->whereDoesntHave('cuStatusAdminKatimker')
        ->get();
        
        // Process each katimker application approved by admin
        foreach ($katimkerApprovedByAdmin as $adminStatus) {
            // Create entry in cu_status_admin_katimkers to represent "automatic" katimker approval
            CuStatusAdminKatimker::create([
                'cu_status_user_admin_id' => $adminStatus->id,
                'status' => 'disetujui',  // Auto-approved because applicant is the katimker
                'catatan' => 'Disetujui otomatis (pemohon adalah Kepala Tim)'
            ]);
        }
        // and ensure they have status "diajukan" in status_cuti_umum
        $cuStatusAdminKatimker = CuStatusAdminKatimker::with([
            'userAdmin.pengajuanCutiUmum.user',
            'userAdmin.pengajuanCutiUmum.jenisCuti',
            'userAdmin.pengajuanCutiUmum.statusCutiUmum', // Make sure this relationship exists
            'cuStatusKatimkerKabag'
        ])
        ->where('status', 'disetujui')
        ->whereHas('userAdmin.pengajuanCutiUmum.statusCutiUmum', function($query) {
            $query->where('status', 'diajukan');
        })
        ->get();
        
        // Count for the tab indicators
        $pendingCount = $cuStatusAdminKatimker->whereNull('cuStatusKatimkerKabag')->count();
        $verifiedCount = $cuStatusAdminKatimker->whereNotNull('cuStatusKatimkerKabag')->count();
        
        // Return view with data
        return view('dashboard.kepalabagian.datapermohonancutiumum-kabag', compact('cuStatusAdminKatimker', 'pendingCount', 'verifiedCount'));
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
        $statuscuti = CuStatusAdminKatimker::findOrFail($id);
        
        $custatusadminkatimker = CuStatusAdminKatimker::where('cu_status_admin_katimkers.id', $statuscuti->id)
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
                'cu_status_admin_katimkers.id',
                'pengajuan_cuti_umums.alamat_saat_cuti',
                'pengajuan_cuti_umums.no_hp_cuti',
                'pengajuan_cuti_umums.masa_kerja',
                'jenis_cuti.nama_cuti',
                'jenis_cuti.id as jeniscuti_id',
                'users.no_hp',
                'cu_status_admin_katimkers.status as status_admin_katimker',
                'cu_status_admin_katimkers.catatan as catatan_admin_katimker',
                'cu_status_user_admins.status as status_user_admin',
                'cu_status_user_admins.catatan as catatan_user_admin',
                'pengajuan_cuti_umums.id as id_pengajuan_cuti_umum'
            )
            ->leftJoin('cu_status_user_admins', 'cu_status_admin_katimkers.cu_status_user_admin_id', '=', 'cu_status_user_admins.id')
            ->leftJoin('pengajuan_cuti_umums', 'cu_status_user_admins.id_pengajuan_cuti_umum', '=', 'pengajuan_cuti_umums.id')
            ->leftJoin('users', 'pengajuan_cuti_umums.user_id', '=', 'users.id')
            ->leftJoin('jenis_cuti', 'pengajuan_cuti_umums.jeniscuti_id', '=', 'jenis_cuti.id')
            ->join('anggota_tims', 'users.id', '=', 'anggota_tims.user_id')
            ->first();
        
        // Variabel fallback untuk ketua
        $ketuaNama = 'Tidak ditemukan';
        $ketuaNIP = '-';
        $ketuaJabatan = '-';

        // Mencari anggota tim yang mengajukan cuti
        $anggotaTim = AnggotaTim::where('user_id', $custatusadminkatimker->user_id)->first();
        
        $idPengajuanCuti = $custatusadminkatimker->id_pengajuan_cuti_umum;
        // Gunakan ID pengajuan cuti umum untuk mencari lampiran
        $lampiran = Lampiran::where('id_pengajuan_cuti', $idPengajuanCuti)->first();

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

        // Cek apakah sudah diverifikasi oleh kabag
        $checkverifikasi = CuStatusKatimkerKabag::where('cu_status_admin_katimker_id', $statuscuti->id)->first();

        // Kirim data ke view
        return view('dashboard.kepalabagian.detailpermohonancutiumum-kabag', compact(
            'custatusadminkatimker',
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
