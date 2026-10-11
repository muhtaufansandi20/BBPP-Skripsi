<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanCutiUmum;
use App\Models\PengajuanCutiTahunan;
use App\Models\User;
use App\Models\JenisCuti;
use Illuminate\Support\Carbon;

class AdminAlurVerfikasiCuti extends Controller
{
    /**
     * Display a listing of the leave applications with verification flow status.
     */
    public function index()
    {
        // Get all general leave applications with their status
        $cutiUmums = PengajuanCutiUmum::with([
            'user',
            'jenisCuti',
            'cuStatusUserAdmin',
            'cuStatusUserAdmin.cuStatusAdminKatimker',
            'cuStatusUserAdmin.cuStatusAdminKatimker.cuStatusKatimkerKabag',
            'cuStatusUserAdmin.cuStatusAdminKatimker.cuStatusKatimkerKabag.cuStatusKabagKabal',
            'cuStatusUserAdmin.cuStatusAdminKabal',
            'StatusCutiUmum'
        ])->get();

        // Get all annual leave applications with their status
        $cutiTahunans = PengajuanCutiTahunan::with([
            'user',
            'ctStatusUserAdmin',
            'ctStatusUserAdmin.ctStatusAdminKatimker',
            'ctStatusUserAdmin.ctStatusAdminKatimker.ctStatusKatimkerKabag',
            'ctStatusUserAdmin.ctStatusAdminKatimker.ctStatusKatimkerKabag.ctStatusKabagKabal',
            'ctStatusUserAdmin.ctStatusAdminKabal',
            'StatusCutiTahunan'
        ])->get();

        return view('dashboard.admin.alurverifikasicuti-admin', compact('cutiUmums', 'cutiTahunans'));
    }

    /**
     * Show details of a specific leave application
     */
    public function show(string $id, Request $request)
    {
        $type = $request->input('type', 'umum');
        
        if ($type === 'umum') {
            $cuti = PengajuanCutiUmum::with([
                'user',
                'jenisCuti',
                'cuStatusUserAdmin',
                'cuStatusUserAdmin.cuStatusAdminKatimker',
                'cuStatusUserAdmin.cuStatusAdminKatimker.cuStatusKatimkerKabag',
                'cuStatusUserAdmin.cuStatusAdminKatimker.cuStatusKatimkerKabag.cuStatusKabagKabal',
                'cuStatusUserAdmin.cuStatusAdminKabal'
            ])->findOrFail($id);
        } else {
            $cuti = PengajuanCutiTahunan::with([
                'user',
                'ctStatusUserAdmin',
                'ctStatusUserAdmin.ctStatusAdminKatimker',
                'ctStatusUserAdmin.ctStatusAdminKatimker.ctStatusKatimkerKabag',
                'ctStatusUserAdmin.ctStatusAdminKatimker.ctStatusKatimkerKabag.ctStatusKabagKabal',
                'ctStatusUserAdmin.ctStatusAdminKabal'
            ])->findOrFail($id);
        }

        return view('dashboard.admin.alurverifikasicuti-detail', compact('cuti', 'type'));
    }

    /**
     * Export verification flow data to Excel/PDF
     */
    public function export(Request $request)
    {
        $type = $request->input('type', 'umum');
        
        if ($type === 'umum') {
            $cutiData = PengajuanCutiUmum::with([
                'user',
                'jenisCuti',
                'cuStatusUserAdmin',
                'cuStatusUserAdmin.cuStatusAdminKatimker',
                'cuStatusUserAdmin.cuStatusAdminKatimker.cuStatusKatimkerKabag',
                'cuStatusUserAdmin.cuStatusAdminKatimker.cuStatusKatimkerKabag.cuStatusKabagKabal',
                'cuStatusUserAdmin.cuStatusAdminKabal'
            ])->get();
        } else {
            $cutiData = PengajuanCutiTahunan::with([
                'user',
                'ctStatusUserAdmin',
                'ctStatusUserAdmin.ctStatusAdminKatimker',
                'ctStatusUserAdmin.ctStatusAdminKatimker.ctStatusKatimkerKabag',
                'ctStatusUserAdmin.ctStatusAdminKatimker.ctStatusKatimkerKabag.ctStatusKabagKabal',
                'ctStatusUserAdmin.ctStatusAdminKabal'
            ])->get();
        }
        
        // You would implement the actual export logic here
        // For example, using Laravel Excel:
        // return Excel::download(new AlurVerifikasiCutiExport($cutiData, $type), "alur_verifikasi_cuti_{$type}.xlsx");
        
        return back()->with('info', 'Export functionality will be implemented in the future.');
    }
}