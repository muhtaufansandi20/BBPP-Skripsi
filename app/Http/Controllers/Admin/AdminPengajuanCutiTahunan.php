<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;
use App\Models\AnggotaTim;
use Illuminate\Http\Request;
use App\Models\PengajuanCutiTahunan;
use App\Http\Controllers\Controller;
use App\Models\CtStatusUserAdmin;
use App\Models\KuotaCutiTahunan;

class AdminPengajuanCutiTahunan extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil permohonan yang belum diverifikasi (status 'belum disetujui' atau belum memiliki status)
        // dan belum dibatalkan oleh user
        $belumVerifikasi = PengajuanCutiTahunan::with(['user', 'statusAdmin', 'statusCutiTahunan'])
            ->where(function($query) {
                $query->whereHas('statusAdmin', function($q) {
                    $q->where('status', 'belum disetujui')
                        ->orWhere('status', 'perubahan');
                })
                ->orWhereDoesntHave('statusAdmin');
            })
            ->whereHas('statusCutiTahunan', function($query) {
                $query->where('status', 'diajukan');
            })
            ->orderBy('tgl_pengajuan', 'desc')
            ->get();
        
        // Mengambil permohonan yang sudah diverifikasi (status 'disetujui', 'ditangguhkan', atau 'ditolak')
        // dan belum dibatalkan oleh user
        $sudahVerifikasi = PengajuanCutiTahunan::with(['user', 'statusAdmin', 'statusCutiTahunan'])
            ->whereHas('statusAdmin', function($query) {
                $query->whereIn('status', ['disetujui', 'ditangguhkan', 'ditolak']);
            })
            ->whereHas('statusCutiTahunan', function($query) {
                $query->where('status', 'diajukan');
            })
            ->orderBy('tgl_pengajuan', 'desc')
            ->get();

        return view('dashboard.admin.pengajuancutitahunan-admin', compact('belumVerifikasi', 'sudahVerifikasi'));
    }
    
    /** 
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all(); // Ambil semua user untuk dipilih oleh admin
        return view('dashboard.admin.createpengajuancutiuser-admin', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tgl_pengajuan' => 'required|date',
            'tgl_mulai' => 'required|date|after_or_equal:tgl_pengajuan',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
            'lama_cuti' => 'required|integer|min:1',
            'alasan' => 'required|string',
            'alamat_saat_cuti' => 'required|string',
            'no_hp_cuti' => 'required|string',
        ]);
    
        PengajuanCutiTahunan::create($request->all());
    
        return redirect()->route('adminpengajuancutitahunan.index')->with('success', 'Pengajuan cuti berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pengajuan = PengajuanCutiTahunan::with('user')->findOrFail($id);
        $user = $pengajuan->user;

        // Inisialisasi data default
        $data = [
            'pengajuan' => $pengajuan,
            'user' => $user,
            'ketuaNama' => 'Tidak ditemukan',
            'ketuaNIP' => '-',
            'kepalaBagian' => null, // Ubah menjadi satu variabel saja
            'kepalaBalai' => null,
            'checkverifikasi' => CtStatusUserAdmin::where('id_pengajuan_cuti_tahunan', $pengajuan->id)->first(),
            'kuotaCuti' => KuotaCutiTahunan::where('user_id', $user->id)->first() ?? new KuotaCutiTahunan([
                'kuota_n' => 12,
                'kuota_n1' => 0,
                'kuota_n2' => 0
            ])
        ];

        // 1. Handle Ketua Tim Kerja (untuk user biasa)
        if ($user->role == 'user') {
            $anggotaTim = AnggotaTim::where('user_id', $user->id)->first();
            
            if ($anggotaTim) {
                $ketuaTim = AnggotaTim::where('tim_id', $anggotaTim->tim_id)
                    ->where('role', 'Ketua')
                    ->with('user')
                    ->first();
                
                if ($ketuaTim) {
                    $data['ketuaNama'] = $ketuaTim->user->name ?? 'Tidak ada nama';
                    $data['ketuaNIP'] = $ketuaTim->user->nip ?? '-';
                }
            }
        }

        // 2. Handle Kepala Bagian (untuk semua role)
        if (in_array($user->role, ['user', 'kepalatimkerja', 'widyaiswara', 'kepalabagian'])) {
            // Untuk semua role, ambil kepala bagian yang sama
            $data['kepalaBagian'] = User::where('role', 'kepalabagian')->first();
        }

        // 3. Handle Kepala Balai
        $data['kepalaBalai'] = User::where('role', 'kepalabalai')->first();

        return view('dashboard.admin.detailpengajuancutitahunan-admin', $data);
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
        $request->validate([
            'lama_cuti' => 'required|integer|min:1',
        ]);

        $pengajuan = PengajuanCutiTahunan::findOrFail($id);
        $pengajuan->update([
            'lama_cuti' => $request->lama_cuti,
        ]);

        return redirect()->back()->with('success', 'Lama cuti berhasil diperbarui.');
    }

 
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
} 
