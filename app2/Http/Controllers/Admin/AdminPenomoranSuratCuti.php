<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengajuanCutiTahunan;
use App\Models\PengajuanCutiUmum;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class AdminPenomoranSuratCuti extends Controller
{
    public function index(Request $request)
    {
        // Ambil filter tahun (default ke tahun berjalan jika tidak dipilih)
        $tahun = $request->input('tahun', date('Y'));

        // 1. Cuti Tahunan (Regular) yang disetujui Kabalai
        $pengajuancutitahunan_regular = PengajuanCutiTahunan::with([
            'ctStatusUserAdmin.ctStatusAdminKatimker.ctStatusKatimkerKabag.ctStatusKabagKabal',
            'user', 'verifikasiTtd'
        ])
        ->where('is_kabag', false)
        ->whereHas('ctStatusUserAdmin.ctStatusAdminKatimker.ctStatusKatimkerKabag.ctStatusKabagKabal', function ($query) {
            $query->where('status', 'disetujui');
        })
        ->when($tahun, function ($query) use ($tahun) {
            $query->whereYear('tgl_pengajuan', $tahun);
        })
        ->get()
        ->map(function ($item) {
            $item->jenis_cuti = 'Tahunan';
            $item->type = 'tahunan';
            return $item;
        });

        // 2. Cuti Tahunan (Kabag) yang disetujui Kabalai
        $pengajuancutitahunan_kabag = PengajuanCutiTahunan::with([
            'ctStatusUserAdmin.ctStatusAdminKabal',
            'user', 'verifikasiTtd'
        ])
        ->where('is_kabag', true)
        ->whereHas('ctStatusUserAdmin.ctStatusAdminKabal', function ($query) {
            $query->where('status', 'disetujui');
        })
        ->when($tahun, function ($query) use ($tahun) {
            $query->whereYear('tgl_pengajuan', $tahun);
        })
        ->get()
        ->map(function ($item) {
            $item->jenis_cuti = 'Tahunan';
            $item->type = 'tahunan';
            return $item;
        });

        // 3. Cuti Umum yang disetujui Kabalai
        $pengajuancutiumum = PengajuanCutiUmum::with([
            'cuStatusUserAdmin.cuStatusAdminKatimker.cuStatusKatimkerKabag.cuStatusKabagKabal',
            'user', 'jenisCuti', 'verifikasiTtd'
        ])
        ->whereHas('cuStatusUserAdmin.cuStatusAdminKatimker.cuStatusKatimkerKabag.cuStatusKabagKabal', function ($query) {
            $query->where('status', 'disetujui');
        })
        ->when($tahun, function ($query) use ($tahun) {
            $query->whereYear('tgl_pengajuan', $tahun);
        })
        ->get()
        ->map(function ($item) {
            $item->jenis_cuti = 'Umum';
            $item->type = 'umum';
            return $item;
        });

        // 4. Gabungkan seluruh berkas dan urutkan berdasarkan tanggal terbaru
        $allApplications = $pengajuancutitahunan_regular
            ->concat($pengajuancutitahunan_kabag)
            ->concat($pengajuancutiumum)
            ->sortByDesc('tgl_pengajuan');

        // 5. Paginasi manual (10 data per halaman)
        $perPage = 10;
        $arsipCuti = $this->paginateCollection($allApplications, $perPage, 'page');

        // Sesuaikan nama view dengan path file blade Anda
        return view('dashboard.admin.arsipsuratcuti-admin', compact('arsipCuti', 'tahun'));
    }

    /**
     * Helper manual pagination collection dengan append query string
     */
    private function paginateCollection($items, $perPage, $pageName = 'page')
    {
        $page = Paginator::resolveCurrentPage($pageName) ?: 1;
        $items = $items instanceof Collection ? $items : Collection::make($items);

        $paginator = new LengthAwarePaginator(
            $items->forPage($page, $perPage)->values(),
            $items->count(),
            $perPage,
            $page,
            [
                'path' => Paginator::resolveCurrentPath(),
                'pageName' => $pageName,
            ]
        );

        return $paginator->appends(request()->query());
    }

    /**
     * Preview / Stream PDF dokumen cuti
     */
    public function viewPDF($id, $type = 'tahunan')
    {
        if ($type === 'tahunan') {
            $cuti = PengajuanCutiTahunan::with('user', 'verifikasiTtd')->findOrFail($id);
        } else {
            $cuti = PengajuanCutiUmum::with('user', 'jenisCuti', 'verifikasiTtd')->findOrFail($id);
        }

        // Jalankan service / logic generate stream PDF Anda di sini
    }
}