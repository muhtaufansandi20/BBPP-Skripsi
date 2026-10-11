<?php

namespace App\Http\Controllers\KepalaBalai;

use App\Models\User;
use App\Models\AnggotaTim;
use Illuminate\Http\Request;
use App\Models\CtStatusUserAdmin;
use App\Models\CtStatusAdminKabal;
use App\Models\CtStatusKabagKabal;
use Illuminate\Support\Facades\DB; 
use App\Http\Controllers\Controller;
use App\Models\PengajuanCutiTahunan;
use App\Models\StatusCutiTahunan; // Added import for StatusCutiTahunan
use App\Models\CtStatusAdminKatimker;
use App\Models\CtStatusKatimkerKabag;

class KepalaBalaiDataPermohonanCuti extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Data cuti reguler yang disetujui katimker & kabag
        // dan belum dibatalkan oleh user
        $cutiRegular = CtStatusKatimkerKabag::with([
            'statusAdminKatimker.statusUserAdmin.pengajuanCutiTahunan.user',
            'statusAdminKatimker.statusUserAdmin.pengajuanCutiTahunan.statusCutiTahunan',
            'ctStatusKabagKabal'
        ])
        ->where('status', 'disetujui')
        ->whereHas('statusAdminKatimker.statusUserAdmin.pengajuanCutiTahunan.statusCutiTahunan', function($query) {
            $query->where('status', 'diajukan');
        })
        ->get();
        
        // Split regular requests into pending and verified
        $regularRequestsPending = $cutiRegular->filter(function($item) {
            return !$item->ctStatusKabagKabal || $item->ctStatusKabagKabal->status === 'belum disetujui';
        });
        
        $regularRequestsVerified = $cutiRegular->filter(function($item) {
            return $item->ctStatusKabagKabal && $item->ctStatusKabagKabal->status !== 'belum disetujui';
        });
        
        // Data cuti kabag yang disetujui admin
        // dan belum dibatalkan oleh user 
        $cutiKabag = CtStatusUserAdmin::with([
            'pengajuanCutiTahunan.user',
            'pengajuanCutiTahunan.statusCutiTahunan',
            'ctStatusAdminKabal'
        ])
        ->whereHas('pengajuanCutiTahunan', function($query) {
            $query->where('is_kabag', true);
        })
        ->whereHas('pengajuanCutiTahunan.statusCutiTahunan', function($query) {
            $query->where('status', 'diajukan');
        })
        ->where('status', 'disetujui')
        ->get();
        
        // Split kabag requests into pending and verified
        $kabagRequestsPending = $cutiKabag->filter(function($item) {
            return !$item->ctStatusAdminKabal || $item->ctStatusAdminKabal->status === 'belum disetujui';
        });
        
        $kabagRequestsVerified = $cutiKabag->filter(function($item) {
            return $item->ctStatusAdminKabal && $item->ctStatusAdminKabal->status !== 'belum disetujui';
        });
        
        // Prepare data for view
        $viewData = [
            'regularRequestsPending' => $regularRequestsPending,
            'regularRequestsVerified' => $regularRequestsVerified,
            'kabagRequestsPending' => $kabagRequestsPending,
            'kabagRequestsVerified' => $kabagRequestsVerified
        ];
        
        return view('dashboard.kepalabalai.permohonancuti-kabalai', compact('viewData'));
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
    public function show(Request $request, string $id)
    {
        // Get the request type from query parameter
        $requestType = $request->query('type');
        $isKabagRequest = ($requestType === 'kabag');
        $checkverifikasi = null;
        
        if ($isKabagRequest) {
            // This is a kabag request - use the ID directly with CtStatusUserAdmin
            $statusCutiAdmin = CtStatusUserAdmin::findOrFail($id);
            
            // For kabag requests, we need to handle the different flow
            // Instead of looking for CtStatusKabagKabal directly, we need to use CtStatusAdminKabal
            $checkverifikasi = CtStatusAdminKabal::where('id_ct_status_user_admin', $statusCutiAdmin->id)->first();
            
            // Get details from leave application and user
            $ctstatuskatimkerkabag = DB::table('ct_status_user_admins')
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
                    'ct_status_user_admins.id', // Use this as the ID
                    'pengajuan_cuti_tahunans.alamat_saat_cuti',
                    'pengajuan_cuti_tahunans.no_hp_cuti',
                    'pengajuan_cuti_tahunans.masa_kerja',
                    'users.no_hp',
                    'pengajuan_cuti_tahunans.is_kabag',
                    'ct_status_user_admins.catatan',
                    'ct_status_user_admins.status'
                )
                ->join('pengajuan_cuti_tahunans', 'ct_status_user_admins.id_pengajuan_cuti_tahunan', '=', 'pengajuan_cuti_tahunans.id')
                ->join('users', 'pengajuan_cuti_tahunans.user_id', '=', 'users.id')
                ->where('ct_status_user_admins.id', $statusCutiAdmin->id)
                ->first();
                
            // For kabag requests, admin is the first approver (no katimker approval needed)
            $statuskatimker = null;
            $catatankatimker = null;
            
            // No team leader for kabag
            $ketuaNama = 'N/A (Pengajuan Kabag)';
            $ketuaNIP = '-';
            $ketuaJabatan = '-';
            
            // Get bureau head
            $kepalaBagianUmum = User::where('role', 'kepalabagian')->first();
            $kepalaBalai = User::where('role', 'kepalabalai')->first();
            
            // Default status if not approved yet
            $status = $checkverifikasi->status ?? 'belum disetujui';
            $catatan = $checkverifikasi->catatan ?? '';
        } else {
            // This is a regular staff request
            $statuscuti = CtStatusKatimkerKabag::findOrFail($id);
            
            // Check if already verified
            $checkverifikasi = CtStatusKabagKabal::where('id_ct_status_katimker_kabag', $statuscuti->id)->first();
    
            // Ambil detail permohonan cuti beserta user terkait
            $ctstatuskatimkerkabag = CtStatusKatimkerKabag::where('ct_status_katimker_kabags.id', $statuscuti->id)
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
                    'ct_status_katimker_kabags.id',
                    'pengajuan_cuti_tahunans.alamat_saat_cuti',
                    'pengajuan_cuti_tahunans.no_hp_cuti',
                    'pengajuan_cuti_tahunans.masa_kerja',
                    'users.no_hp',
                    'pengajuan_cuti_tahunans.is_kabag'
                )
                ->leftJoin('ct_status_admin_katimkers', 'ct_status_katimker_kabags.id_ct_status_admin_katimker', '=', 'ct_status_admin_katimkers.id')
                ->leftJoin('ct_status_user_admins', 'ct_status_admin_katimkers.id_ct_status_user_admin', '=', 'ct_status_user_admins.id')
                ->leftJoin('pengajuan_cuti_tahunans', 'ct_status_user_admins.id_pengajuan_cuti_tahunan', '=', 'pengajuan_cuti_tahunans.id')
                ->leftJoin('users', 'pengajuan_cuti_tahunans.user_id', '=', 'users.id')
                ->join('anggota_tims', 'users.id', '=', 'anggota_tims.user_id')
                ->first();
    
            // Status from team leader
            $statuskatimker = null;
            $catatankatimker = null;
            
            $adminKatimkerData = DB::table('ct_status_admin_katimkers')
                ->where('id', $statuscuti->id_ct_status_admin_katimker)
                ->first();
            
            if ($adminKatimkerData) {
                $statuskatimker = $adminKatimkerData->status;
                $catatankatimker = $adminKatimkerData->catatan;
            }
    
            // Variabel default
            $ketuaNama = 'Tidak ditemukan';
            $ketuaNIP = '-';
            $ketuaJabatan = 'Jabatan Tidak Ditemukan';
    
            // Cari anggota tim berdasarkan user_id pemohon cuti
            $anggotaTim = AnggotaTim::where('user_id', $ctstatuskatimkerkabag->user_id)->first();
    
            if ($anggotaTim) {
                // Cari Ketua Tim dari tim yang sama
                $ketuaTim = AnggotaTim::where('tim_id', $anggotaTim->tim_id)
                    ->where('role', 'Ketua')
                    ->with('user') // Mengambil informasi user
                    ->first();
    
                if ($ketuaTim) {
                    $ketuaNama = $ketuaTim->user->name ?? 'Tidak ada nama';
                    $ketuaNIP = $ketuaTim->user->nip ?? '-';
                    $ketuaJabatan = $ketuaTim->user->jabatan ?? 'Jabatan Tidak Ditemukan';
                }
            }
    
            // Ambil Kepala Bagian Umum berdasarkan role di tabel users
            $kepalaBagianUmum = User::where('role', 'kepalabagian')->first();
    
            // Ambil Kepala Bagian Umum berdasarkan role di tabel users
            $kepalaBalai = User::where('role', 'kepalabalai')->first();
    
            // Jika status belum ada, set default "belum disetujui"
            $status = $checkverifikasi->status ?? 'belum disetujui';
            $catatan = $checkverifikasi->catatan ?? '';
        }
    
        // Kirim data ke view dengan flag untuk jenis pengajuan
        return view('dashboard.kepalabalai.detailpermohonancuti-kabalai', compact(
            'ctstatuskatimkerkabag', 
            'statuskatimker', 
            'catatankatimker', 
            'status', 
            'catatan',
            'ketuaNama', 
            'ketuaNIP',
            'ketuaJabatan',
            'kepalaBagianUmum', 
            'kepalaBalai', 
            'checkverifikasi',
            'isKabagRequest' // Add this flag for the view
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
