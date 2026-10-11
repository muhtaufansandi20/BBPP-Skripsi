<?php

namespace App\Http\Controllers\KepalaBagian;

use App\Models\AnggotaTim;
use Illuminate\Http\Request;
use App\Models\CtStatusUserAdmin;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use App\Models\CtStatusAdminKatimker;
use App\Models\CtStatusKatimkerKabag;
use App\Models\StatusCutiTahunan; // Added import for StatusCutiTahunan
use App\Models\PengajuanCutiTahunan; // Added import for PengajuanCutiTahunan
use view;

class KabagDataPermohonanCuti extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
    { 
        // Get regular applications (already in ct_status_admin_katimkers)
        $regularApplications = CtStatusAdminKatimker::with([
            'statusUserAdmin.pengajuanCutiTahunan.user',
            'statusUserAdmin.pengajuanCutiTahunan.statusCutiTahunan', // Include status
            'ctStatusKatimkerKabag'
        ])
        ->where('status', 'disetujui')
        ->whereHas('statusUserAdmin.pengajuanCutiTahunan.statusCutiTahunan', function($query) {
            $query->where('status', 'diajukan'); // Only include active applications
        })
        ->get();
        
        // Get katimker applications that have been approved by admin
        // but might not have an entry in ct_status_admin_katimkers yet
        $katimkerApprovedByAdmin = CtStatusUserAdmin::with([
            'pengajuanCutiTahunan.user',
            'pengajuanCutiTahunan.statusCutiTahunan' // Include status
        ])
        ->where('status', 'disetujui')
        ->whereHas('pengajuanCutiTahunan', function($query) {
            $query->where('is_katimker', true);
        })
        ->whereHas('pengajuanCutiTahunan.statusCutiTahunan', function($query) {
            $query->where('status', 'diajukan'); // Only include active applications
        })
        ->whereDoesntHave('ctStatusAdminKatimker')
        ->get();
        
        // Process each katimker application approved by admin
        foreach ($katimkerApprovedByAdmin as $adminStatus) {
            // Create entry in ct_status_admin_katimkers to represent "automatic" katimker approval
            CtStatusAdminKatimker::create([
                'id_ct_status_user_admin' => $adminStatus->id,
                'status' => 'disetujui',  // Auto-approved because applicant is the katimker
                'catatan' => 'Disetujui otomatis (pemohon adalah Kepala Tim)'
            ]);
        }
        
        // Refresh the regular applications query to include newly created records
        // and filter out canceled applications
        $ctStatusAdminKatimker = CtStatusAdminKatimker::with([
            'statusUserAdmin.pengajuanCutiTahunan.user',
            'statusUserAdmin.pengajuanCutiTahunan.statusCutiTahunan', // Include status
            'ctStatusKatimkerKabag'
        ])
        ->where('status', 'disetujui')
        ->whereHas('statusUserAdmin', function($query) {
            $query->where('status', 'disetujui');
        })
        ->whereHas('statusUserAdmin.pengajuanCutiTahunan.statusCutiTahunan', function($query) {
            $query->where('status', 'diajukan'); // Only include active applications
        })
        ->get();
        
        // Count for the tab indicators
        $pendingCount = $ctStatusAdminKatimker->whereNull('ctStatusKatimkerKabag')->count();
        $verifiedCount = $ctStatusAdminKatimker->whereNotNull('ctStatusKatimkerKabag')->count();
        
        return view('dashboard.kepalabagian.permohonancuti-kabag', compact(
            'ctStatusAdminKatimker',
            'pendingCount',
            'verifiedCount'
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
        $statuscuti = CtStatusAdminKatimker::findOrFail($id);

        $ctstatusadminkatimker = CtStatusAdminKatimker::where('ct_status_admin_katimkers.id', $statuscuti->id)
            ->select(
                'users.name',
                'users.nip',
                'users.jabatan',
                'pengajuan_cuti_tahunans.tgl_pengajuan',
                'pengajuan_cuti_tahunans.tgl_mulai',
                'pengajuan_cuti_tahunans.tgl_selesai',
                'pengajuan_cuti_tahunans.lama_cuti',
                'pengajuan_cuti_tahunans.alasan',
                'pengajuan_cuti_tahunans.user_id',
                'ct_status_admin_katimkers.id',
                'ct_status_admin_katimkers.status', 
                'pengajuan_cuti_tahunans.alamat_saat_cuti',
                'pengajuan_cuti_tahunans.no_hp_cuti',
                'pengajuan_cuti_tahunans.masa_kerja',
                'users.no_hp',
                'pengajuan_cuti_tahunans.is_katimker'
            )
            ->leftJoin('ct_status_user_admins', 'ct_status_admin_katimkers.id_ct_status_user_admin', '=', 'ct_status_user_admins.id')
            ->leftJoin('pengajuan_cuti_tahunans', 'ct_status_user_admins.id_pengajuan_cuti_tahunan', '=', 'pengajuan_cuti_tahunans.id')
            ->leftJoin('users', 'pengajuan_cuti_tahunans.user_id', '=', 'users.id')
            ->join('anggota_tims', 'users.id', '=', 'anggota_tims.user_id')
            ->first();


        // Variabel default
        $ketuaNama = 'Tidak ditemukan';
        $ketuaNIP = '-';
        $ketuaJabatan = 'Jabatan Tidak Ditemukan';

        // Cari anggota tim berdasarkan user_id pemohon cuti
        $anggotaTim = AnggotaTim::where('user_id', $ctstatusadminkatimker->user_id)->first();

        if ($anggotaTim) {
            // Cari Ketua Tim dari tim yang sama
            $ketuaTim = AnggotaTim::where('tim_id', $anggotaTim->tim_id)
                ->where('role', 'Ketua')
                ->with('user') // Mengambil informasi user
                ->first();

            if ($ketuaTim) {
                $ketuaNama = $ketuaTim->user->name ?? 'Tidak ada nama';
                $ketuaNIP = $ketuaTim->user->nip ?? '-';
                $ketuaJabatan = $ketuaTim->user->jabatan ?? 'Jabatan Tidak Ditemukan'; // Tambahkan jabatan
            }
        }


        // Ambil Kepala Bagian Umum berdasarkan role di tabel users
        $kepalaBagianUmum = User::where('role', 'kepalabagian')->first();
        $kepalaBalai = User::where('role', 'kepalabalai')->first();

        $checkverifikasi = CtStatusKatimkerKabag::where('id_ct_status_admin_katimker', $statuscuti->id)->first();

        // Kirim data ke view
        return view('dashboard.kepalabagian.detailpermohonancuti-kabag', compact('ctstatusadminkatimker', 'ketuaNama', 'ketuaNIP','ketuaJabatan', 'kepalaBagianUmum', 'kepalaBalai', 'checkverifikasi'));
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
