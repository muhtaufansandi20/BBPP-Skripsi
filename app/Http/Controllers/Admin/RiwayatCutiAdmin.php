<?php

namespace App\Http\Controllers\Admin;

use App\Models\JenisCuti;
use Illuminate\Http\Request;
use App\Models\PengajuanCutiUmum;
use App\Http\Controllers\Controller;
use App\Models\PengajuanCutiTahunan;

class RiwayatCutiAdmin extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->getRiwayatCuti();
        return view('dashboard.admin.riwayatcuti-admin', [
            'riwayatCuti' => $data['riwayatCuti'],
            'jenisCuti' => $data['jenisCutiOptions']
        ]);
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
        //
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

    private function getRiwayatCuti()
    {
        // Get approved annual leave (cuti tahunan) - regular flow
        $cutiTahunanRegular = PengajuanCutiTahunan::with(['user' => function($query) {
                $query->select('id', 'name', 'nip', 'jabatan');
            }, 'verifikasiTtd'])
            ->where('is_kabag', false)
            ->whereHas('ctStatusUserAdmin.ctStatusAdminKatimker.ctStatusKatimkerKabag.ctStatusKabagKabal', function($q) {
                $q->where('status', 'disetujui');
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($item) {
                $item->jenis_cuti = 'Tahunan';
                $item->type = 'tahunan';
                $item->jumlah_hari = $item->lama_cuti;
                return $item;
            });

        // Get approved annual leave (cuti tahunan) - kabag flow
        $cutiTahunanKabag = PengajuanCutiTahunan::with(['user' => function($query) {
                $query->select('id', 'name', 'nip', 'jabatan');
            }, 'verifikasiTtd'])
            ->where('is_kabag', true)
            ->whereHas('ctStatusUserAdmin.ctStatusAdminKabal', function($q) {
                $q->where('status', 'disetujui');
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($item) {
                $item->jenis_cuti = 'Tahunan';
                $item->type = 'tahunan';
                $item->jumlah_hari = $item->lama_cuti;
                return $item;
            });

        // Combine both annual leave collections
        $cutiTahunan = $cutiTahunanRegular->concat($cutiTahunanKabag);

        // Get approved general leave (cuti umum) - regular flow
        $cutiUmumRegular = PengajuanCutiUmum::with(['user' => function($query) {
                $query->select('id', 'name', 'nip', 'jabatan');
            }, 'jeniscuti:id,nama_cuti', 'verifikasiTtd'])
            ->where('is_kabag', false)
            ->whereHas('cuStatusUserAdmin.cuStatusAdminKatimker.cuStatusKatimkerKabag.cuStatusKabagKabal', function($q) {
                $q->where('status', 'disetujui');
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($item) {
                $item->jenis_cuti = $item->jeniscuti->nama_cuti ?? 'Umum';
                $item->type = 'umum';
                $item->jumlah_hari = $item->jumlah_hari;
                return $item;
            });

        // Get approved general leave (cuti umum) - kabag flow
        $cutiUmumKabag = PengajuanCutiUmum::with(['user' => function($query) {
                $query->select('id', 'name', 'nip', 'jabatan');
            }, 'jeniscuti:id,nama_cuti', 'verifikasiTtd'])
            ->where('is_kabag', true)
            ->whereHas('cuStatusUserAdmin.cuStatusAdminKabal', function($q) {
                $q->where('status', 'disetujui');
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($item) {
                $item->jenis_cuti = $item->jeniscuti->nama_cuti ?? 'Umum';
                $item->type = 'umum';
                $item->jumlah_hari = $item->jumlah_hari;
                return $item;
            });

        // Combine both general leave collections
        $cutiUmum = $cutiUmumRegular->concat($cutiUmumKabag);

        // Get jenis cuti options for filter
        $jenisCutiOptions = JenisCuti::all(['id', 'nama_cuti']);

        return [
            'riwayatCuti' => $cutiTahunan->concat($cutiUmum)
                ->sortByDesc('created_at')
                ->take(10),
            'jenisCutiOptions' => $jenisCutiOptions
        ];
    }
}
