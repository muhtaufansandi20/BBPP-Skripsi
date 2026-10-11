<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\HariLibur;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminKalenderCuti extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         return view('dashboard.admin.kalendercuti-admin');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'tipe'            => 'required|in:libur_nasional,blackout',
            'nama'            => 'required|string|max:255',
            'tanggal_tunggal' => 'nullable|date',
            'tanggal_mulai'   => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
        ], [
            'tipe.required' => 'Tipe hari harus dipilih.',
            'nama.required' => 'Nama hari atau kegiatan harus diisi.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai tidak boleh lebih awal dari tanggal mulai.',
        ]);

        $tipe = $request->tipe;
        $nama = $request->nama;

        // 2. Logika Penyimpanan berdasarkan Mode (Range atau Tunggal)
        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            
            // Mode Range (Rentang Tanggal)
            $start = Carbon::parse($request->tanggal_mulai);
            $end   = Carbon::parse($request->tanggal_selesai);

            // Looping dari tanggal mulai sampai tanggal selesai
            for ($date = $start; $date->lte($end); $date->addDay()) {
                // updateOrCreate akan mencari data berdasarkan 'tanggal'.
                // Jika ada, datanya diupdate. Jika tidak, akan dibuat baru.
                HariLibur::updateOrCreate(
                    ['tanggal' => $date->format('Y-m-d')],
                    [
                        'nama' => $nama,
                        'tipe' => $tipe
                    ]
                );
            }

            $pesan = 'Rentang hari libur berhasil ditambahkan.';

        } elseif ($request->filled('tanggal_tunggal')) {
            
            // Mode Tanggal Tunggal
            HariLibur::updateOrCreate(
                ['tanggal' => $request->tanggal_tunggal],
                [
                    'nama' => $nama,
                    'tipe' => $tipe
                ]
            );

            $pesan = 'Hari libur berhasil ditambahkan.';

        } else {
            // Jika admin tidak mengisi satupun tanggal
            return redirect()->back()->with('error', 'Silakan isi Tanggal Tunggal atau Rentang Tanggal!');
        }

        return redirect()->back()->with('success', $pesan);
    }

    /**
     * Menghapus satu entri hari libur
     */
    public function destroy($id)
    {
        $hariLibur = HariLibur::findOrFail($id);
        $hariLibur->delete();

        return redirect()->back()->with('success', 'Hari libur berhasil dihapus.');
    }

    public function getLiburAPI(Request $request)
    {
        $year = $request->query('year', date('Y'));
        $month = $request->query('month');

        $query = HariLibur::whereYear('tanggal', $year);

        // Jika request menyertakan bulan
        if ($month !== null) {
            $query->whereMonth('tanggal', $month);
        }

        // Ambil data dan sesuaikan nama kolom agar cocok dengan JS yang sudah ada
        $liburs = $query->get(['tanggal as date', 'nama as name', 'tipe as type']);

        return response()->json($liburs);
    }
}
