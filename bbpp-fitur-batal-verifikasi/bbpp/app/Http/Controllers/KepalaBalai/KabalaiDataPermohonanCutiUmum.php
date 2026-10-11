<?php

namespace App\Http\Controllers\KepalaBalai;

use App\Models\User;
use App\Models\Lampiran;
use App\Models\AnggotaTim;
use Illuminate\Http\Request;
use App\Models\CuStatusUserAdmin;
use App\Models\CuStatusAdminKabal;
use App\Models\CuStatusKabagKabal;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\CuStatusKatimkerKabag;

class KabalaiDataPermohonanCutiUmum extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // PENDING REQUESTS
        // 1. Get regular leave requests that have been approved by Kabag and need Kabalai verification
        $pendingCutiRegular = CuStatusKatimkerKabag::with([
            'adminKatimker.userAdmin.pengajuanCutiUmum.user',
            'adminKatimker.userAdmin.pengajuanCutiUmum.jenisCuti',
            'adminKatimker.userAdmin.pengajuanCutiUmum.statusCutiUmum',
            'kabagKabal'
        ])
        ->where('status', 'disetujui')
        ->whereHas('adminKatimker.userAdmin.pengajuanCutiUmum.statusCutiUmum', function($query) {
            $query->where('status', 'diajukan'); // Only include active applications
        })
        ->whereDoesntHave('kabagKabal')
        ->get();
        
        // 2. Get Kabag leave requests that have been approved by Admin and need Kabalai verification
        $pendingCutiKabag = CuStatusUserAdmin::with([
            'pengajuanCutiUmum.user',
            'pengajuanCutiUmum.jenisCuti',
            'pengajuanCutiUmum.statusCutiUmum',
            'cuStatusAdminKabal'
        ])
        ->whereHas('pengajuanCutiUmum', function($query) {
            $query->where('is_kabag', true);
        })
        ->whereHas('pengajuanCutiUmum.statusCutiUmum', function($query) {
            $query->where('status', 'diajukan'); // Only include active applications
        })
        ->where('status', 'disetujui')
        ->whereDoesntHave('cuStatusAdminKabal')
        ->get();
        
        // VERIFIED REQUESTS
        // 1. Get regular leave requests that have been verified by Kabalai
        $verifiedCutiRegular = CuStatusKatimkerKabag::with([
            'adminKatimker.userAdmin.pengajuanCutiUmum.user',
            'adminKatimker.userAdmin.pengajuanCutiUmum.jenisCuti',
            'adminKatimker.userAdmin.pengajuanCutiUmum.statusCutiUmum',
            'kabagKabal'
        ])
        ->whereHas('kabagKabal', function($query) {
            // Include requests where Kabalai has made a decision (approved, rejected, postponed, etc.)
            $query->whereIn('status', ['disetujui', 'ditolak', 'ditangguhkan', 'perubahan']);
        })
        ->get();
        
        // 2. Get Kabag leave requests that have been verified by Kabalai
        $verifiedCutiKabag = CuStatusUserAdmin::with([
            'pengajuanCutiUmum.user',
            'pengajuanCutiUmum.jenisCuti',
            'pengajuanCutiUmum.statusCutiUmum',
            'cuStatusAdminKabal'
        ])
        ->whereHas('pengajuanCutiUmum', function($query) {
            $query->where('is_kabag', true);
        })
        ->whereHas('cuStatusAdminKabal', function($query) {
            // Include requests where Kabalai has made a decision (approved, rejected, postponed, etc.)
            $query->whereIn('status', ['disetujui', 'ditolak', 'ditangguhkan', 'perubahan']);
        })
        ->get();
        
        // Prepare data for view
        $viewData = [
            'pendingRegularRequests' => $pendingCutiRegular,
            'pendingKabagRequests' => $pendingCutiKabag,
            'verifiedRegularRequests' => $verifiedCutiRegular,
            'verifiedKabagRequests' => $verifiedCutiKabag
        ];
        
        return view('dashboard.kepalabalai.datapermohonancutiumum-kabalai', compact('viewData'));
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
            // This is a kabag request - use the ID directly with CuStatusUserAdmin
            $statusCutiAdmin = CuStatusUserAdmin::findOrFail($id);
            
            // For kabag requests, we need to handle the different flow
            // Instead of looking for CuStatusKabagKabal directly, we need to use CuStatusAdminKabal
            $checkverifikasi = CuStatusAdminKabal::where('cu_status_user_admin_id', $statusCutiAdmin->id)->first();
            
            // Get details from leave application and user
            $custatuskatimkerkabag = DB::table('cu_status_user_admins')
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
                    'cu_status_user_admins.id', // Use this as the ID
                    'pengajuan_cuti_umums.alamat_saat_cuti',
                    'pengajuan_cuti_umums.no_hp_cuti',
                    'pengajuan_cuti_umums.masa_kerja',
                    'jenis_cuti.nama_cuti',
                    'jenis_cuti.id as jeniscuti_id',
                    'users.no_hp',
                    'pengajuan_cuti_umums.is_kabag',
                    'cu_status_user_admins.catatan as catatan_user_admin',
                    'cu_status_user_admins.status as status_user_admin',
                    'pengajuan_cuti_umums.id as id_pengajuan_cuti_umum'
                )
                ->join('pengajuan_cuti_umums', 'cu_status_user_admins.id_pengajuan_cuti_umum', '=', 'pengajuan_cuti_umums.id')
                ->join('users', 'pengajuan_cuti_umums.user_id', '=', 'users.id')
                ->leftJoin('jenis_cuti', 'pengajuan_cuti_umums.jeniscuti_id', '=', 'jenis_cuti.id')
                ->where('cu_status_user_admins.id', $statusCutiAdmin->id)
                ->first();
                
            // For kabag requests, admin is the first approver (no katimker approval needed)
            $statusAdminKatimker = null;
            $catatanAdminKatimker = null;
            
            // No team leader for kabag
            $ketuaNama = 'N/A (Pengajuan Kabag)';
            $ketuaNIP = '-';
            $ketuaJabatan = '-';
            
            // Get bureau head
            $kepalaBagian = User::where('role', 'kepalabagian')->first();
            $kepalaBalai = User::where('role', 'kepalabalai')->first();
            
            // Default status if not approved yet
            $status = $checkverifikasi->status ?? 'belum disetujui';
            $catatan = $checkverifikasi->catatan ?? '';
            
            // Get lampiran
            $lampiran = Lampiran::where('id_pengajuan_cuti', $custatuskatimkerkabag->id_pengajuan_cuti_umum)->first();
        } else {
            // This is a regular staff request
            $statuscuti = CuStatusKatimkerKabag::findOrFail($id);
            
            // Check if already verified
            $checkverifikasi = CuStatusKabagKabal::where('cu_status_katimker_kabag_id', $statuscuti->id)->first();
    
            // Get detailed leave application data and related user
            $custatuskatimkerkabag = CuStatusKatimkerKabag::where('cu_status_katimker_kabags.id', $statuscuti->id)
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
                    'cu_status_katimker_kabags.id',
                    'pengajuan_cuti_umums.alamat_saat_cuti',
                    'pengajuan_cuti_umums.no_hp_cuti',
                    'pengajuan_cuti_umums.masa_kerja',
                    'jenis_cuti.nama_cuti',
                    'jenis_cuti.id as jeniscuti_id',
                    'users.no_hp',
                    'cu_status_katimker_kabags.status as status_katimker_kabag',
                    'cu_status_katimker_kabags.catatan as catatan_katimker_kabag',
                    'cu_status_admin_katimkers.status as status_admin_katimker',
                    'cu_status_admin_katimkers.catatan as catatan_admin_katimker',
                    'cu_status_user_admins.status as status_user_admin',
                    'cu_status_user_admins.catatan as catatan_user_admin',
                    'pengajuan_cuti_umums.id as id_pengajuan_cuti_umum'
                )
                ->leftJoin('cu_status_admin_katimkers', 'cu_status_katimker_kabags.cu_status_admin_katimker_id', '=', 'cu_status_admin_katimkers.id')
                ->leftJoin('cu_status_user_admins', 'cu_status_admin_katimkers.cu_status_user_admin_id', '=', 'cu_status_user_admins.id')
                ->leftJoin('pengajuan_cuti_umums', 'cu_status_user_admins.id_pengajuan_cuti_umum', '=', 'pengajuan_cuti_umums.id')
                ->leftJoin('users', 'pengajuan_cuti_umums.user_id', '=', 'users.id')
                ->leftJoin('jenis_cuti', 'pengajuan_cuti_umums.jeniscuti_id', '=', 'jenis_cuti.id')
                ->join('anggota_tims', 'users.id', '=', 'anggota_tims.user_id')
                ->first();
    
            // Status from team leader
            $statusAdminKatimker = $custatuskatimkerkabag->status_admin_katimker ?? null;
            $catatanAdminKatimker = $custatuskatimkerkabag->catatan_admin_katimker ?? null;
    
            // Default variables
            $ketuaNama = 'Tidak ditemukan';
            $ketuaNIP = '-';
            $ketuaJabatan = 'Jabatan Tidak Ditemukan';
    
            // Find team member based on requesting user's ID
            $anggotaTim = AnggotaTim::where('user_id', $custatuskatimkerkabag->user_id)->first();
    
            if ($anggotaTim) {
                // Find the Team Leader from the same team
                $ketuaTim = AnggotaTim::where('tim_id', $anggotaTim->tim_id)
                    ->where('role', 'Ketua')
                    ->with('user') // Get user information
                    ->first();
    
                if ($ketuaTim) {
                    $ketuaNama = $ketuaTim->user->name ?? 'Tidak ada nama';
                    $ketuaNIP = $ketuaTim->user->nip ?? '-';
                    $ketuaJabatan = $ketuaTim->user->jabatan ?? 'Jabatan Tidak Ditemukan';
                }
            }
    
            // Get department head based on role
            $kepalaBagian = User::where('role', 'kepalabagian')->first();
    
            // Get bureau head based on role
            $kepalaBalai = User::where('role', 'kepalabalai')->first();
    
            // Default status if not yet approved
            $status = $checkverifikasi->status ?? 'belum disetujui';
            $catatan = $checkverifikasi->catatan ?? '';
            
            // Get lampiran (attachment)
            $lampiran = Lampiran::where('id_pengajuan_cuti', $custatuskatimkerkabag->id_pengajuan_cuti_umum)->first();
        }
    
        // Send data to view with isKabagRequest flag
        return view('dashboard.kepalabalai.detailpermohonancutiumum2-kabalai', compact(
            'custatuskatimkerkabag', 
            'statusAdminKatimker', 
            'catatanAdminKatimker', 
            'status', 
            'catatan',
            'ketuaNama', 
            'ketuaNIP',
            'ketuaJabatan',
            'kepalaBagian', 
            'kepalaBalai', 
            'lampiran',
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
