<?php

namespace App\Http\Controllers\KepalaBagian;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Lampiran;
use App\Models\JenisCuti;
use App\Models\MasaKerja;
use App\Models\AnggotaTim;
use Illuminate\Http\Request;
use App\Models\StatusCutiUmum;
use App\Models\RiwayatCutiUmum;
use App\Models\PengajuanCutiUmum;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KabagPengajuanCutiUmum extends Controller
{
    /** 
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $userId = Auth::user()->id;
        $hasWorkPeriod = MasaKerja::where('user_id', $userId)->exists();
        
        // Load pengajuan cuti umum with all its status relations
        $pengajuans = PengajuanCutiUmum::with([
            'jenisCuti',
            'cuStatusUserAdmin.cuStatusAdminKabal' // Direct relation for Kabag since they skip katimker level
        ])
        ->where('user_id', $user->id)
        ->where('is_kabag', true)
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('dashboard.kepalabagian.datapengajuancutiumum-kabag', compact('user', 'pengajuans', 'hasWorkPeriod'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $userId = Auth::user()->id;

        $jenisCuti = JenisCuti::all();
        $checkUser = MasaKerja::where('user_id', $userId)->exists(); 
        $masakerja = MasaKerja::where('user_id', $userId)->first(); 
        $no_hp_cuti = User::where('id', $userId)->value('no_hp');

        return view('dashboard.kepalabagian.createpengajuancutiumum-kabag', compact('jenisCuti', 'no_hp_cuti', 'checkUser', 'masakerja'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validasi data
            $validated = $request->validate([
                'jeniscuti_id' => 'required|exists:jenis_cuti,id',
                'tgl_pengajuan' => 'required|date',
                'tgl_mulai' => 'required|date',
                'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
                'alasan' => 'required|string',
                'alamat_saat_cuti' => 'required|string',
                'no_hp_cuti' => 'required|string',
                'masa_kerja' => 'nullable|string',
                'catatan' => 'nullable|string',
                'lampiran' => 'nullable|file|max:2048',
            ]);
            
            // Log data untuk debugging
            Log::info('Data request: ' . json_encode($request->all()));
            
            // Tambahkan field jumlah_hari dari input
            $jumlahHari = 0;
            if (isset($request->jumlah_hari) && !empty($request->jumlah_hari)) {
                $jumlahHari = $request->jumlah_hari;
            }
            
            // Simpan data pengajuan cuti dengan query builder
            $pengajuanId = DB::table('pengajuan_cuti_umums')->insertGetId([
                'user_id' => $request->user_id,
                'jeniscuti_id' => $request->jeniscuti_id,
                'tgl_pengajuan' => $request->tgl_pengajuan,
                'tgl_mulai' => $request->tgl_mulai,
                'tgl_selesai' => $request->tgl_selesai,
                'jumlah_hari' => $jumlahHari,
                'alasan' => $request->alasan,
                'catatan' => $request->catatan,
                'alamat_saat_cuti' => $request->alamat_saat_cuti,
                'no_hp_cuti' => $request->no_hp_cuti,
                'masa_kerja' => $request->masa_kerja ?? '0',
                'is_kabag' => true, // Set is_kabag to true for Kabag
                'created_at' => now(),
                'updated_at' => now() 
            ]);
            
            // Buat status cuti
            StatusCutiUmum::create([
                'id_cuti_umum' => $pengajuanId, // Fixed: $pengajuanId is already the ID
                'status' => 'diajukan',
                'catatan' => null
            ]);
            
            
            // Handle file upload jika ada
            if ($request->hasFile('lampiran')) {
                $file = $request->file('lampiran');
                $originalName = $file->getClientOriginalName();
                $filePath = $file->store('lampiran', 'public');
                
                // Ambil data jenis cuti untuk mendapatkan nama jenis cuti
                $jenisCuti = JenisCuti::find($request->jeniscuti_id);
                $namaJenisCuti = $jenisCuti ? $jenisCuti->nama_cuti : 'Unknown';

                // Ambil data user untuk mendapatkan nama user
                $user = User::find($request->user_id);
                $namaUser = $user ? $user->name : 'Unknown';

                // Simpan informasi lampiran ke database dengan deskripsi yang diperbarui
                Lampiran::create([
                    'id_pengajuan_cuti' => $pengajuanId,
                    'nama_doc' => $originalName,
                    'file_path' => $filePath,
                    'description' => 'Lampiran pengajuan cuti ' . $namaJenisCuti . ' ' . $namaUser,
                ]);
                                
                Log::info('Lampiran berhasil disimpan: ' . $filePath);
            }
            
            return redirect()->route('kabagpengajuancutiumum.index')
                ->with('success', 'Pengajuan cuti berhasil disimpan.');
        } catch (\Exception $e) {
            Log::error('Error saat menyimpan pengajuan cuti: ' . $e->getMessage());
            return redirect()->back()->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pengajuan = PengajuanCutiUmum::with([
            'user',
            'cuStatusUserAdmin.cuStatusAdminKabal' // For Kabag process flow
        ])->where('id', $id)->firstOrFail();
    
        // Get lampiran data
        $lampiran = Lampiran::where('id_pengajuan_cuti', $id)->first();
    
        // Default nilai untuk kepala bagian dan kepala balai
        $kepalaBagianNama = 'Tidak ditemukan';
        $kepalaBagianNIP = '-';
        $kepalaBagianJabatan = '-';
        $kepalaBalaiNama = 'Tidak ditemukan';
        $kepalaBalaiNIP = '-';
        $kepalaBalaiJabatan = '-';
    
        // Default status dan catatan
        $statusAdmin = 'Belum diproses';
        $statusKabal = 'Belum diproses';
    
        $catatanAdmin = 'Tidak ada catatan';
        $catatanKabal = 'Tidak ada catatan';
    
    
        // Mencari Kepala Balai
        $kepalaBalai = User::where('role', 'Kepalabalai')->first();
        if ($kepalaBalai) {
            $kepalaBalaiNama = $kepalaBalai->name;
            $kepalaBalaiNIP = $kepalaBalai->nip;
            $kepalaBalaiJabatan = $kepalaBalai->jabatan;
        }
    
        // Mengambil status & catatan pengajuan cuti umum (untuk Kabag, alurnya: admin -> kabal)
        $statusAdmin = $pengajuan->cuStatusUserAdmin->status ?? 'Belum diproses';
        $statusKabal = $pengajuan->cuStatusUserAdmin->cuStatusAdminKabal->status ?? 'Belum diproses';
    
        // Menambahkan catatan dari tiap level
        $catatanAdmin = $pengajuan->cuStatusUserAdmin->catatan ?? 'Tidak ada catatan';
        $catatanKabal = $pengajuan->cuStatusUserAdmin->cuStatusAdminKabal->catatan ?? 'Tidak ada catatan';
    
        return view('dashboard.kepalabagian.detailpengajuancutiumum-kabag', compact(
            'pengajuan',
            'kepalaBalaiNama', 
            'kepalaBalaiNIP', 
            'kepalaBalaiJabatan',
            'statusAdmin',
            'statusKabal',
            'catatanAdmin',
            'catatanKabal',
            'lampiran'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pengajuan = PengajuanCutiUmum::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('is_kabag', true)
            ->firstOrFail();
            
        $jenisCuti = JenisCuti::all();
        $lampiran = Lampiran::where('id_pengajuan_cuti', $id)->first();
        $no_hp_cuti = User::where('id', Auth::id())->value('no_hp');
        $checkUser = MasaKerja::where('user_id', Auth::id())->exists();
        $masakerja = MasaKerja::where('user_id', Auth::id())->first();
        
        return view('dashboard.kepalabagian.editpengajuancutiumum-kabag', compact(
            'pengajuan', 
            'jenisCuti', 
            'lampiran', 
            'no_hp_cuti',
            'checkUser',
            'masakerja'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pengajuanCuti = PengajuanCutiUmum::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('is_kabag', true)
            ->firstOrFail();
            
        // Validasi data dasar
        $validated = $request->validate([
            'jeniscuti_id' => 'required|exists:jenis_cuti,id',
            'tgl_pengajuan' => 'required|date',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
            'alasan' => 'required|string',
            'alamat_saat_cuti' => 'required|string',
            'no_hp_cuti' => 'required|string',
            'masa_kerja' => 'nullable|string',
            'catatan' => 'nullable|string',
            'lampiran' => 'nullable|file|max:2048',
        ]);

        // Handle file upload if new lampiran is provided
        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');
            $originalName = $file->getClientOriginalName();
            $filePath = $file->store('lampiran', 'public');
            
            // Check if lampiran already exists
            $existingLampiran = Lampiran::where('id_pengajuan_cuti', $id)->first();
            
            if ($existingLampiran) {
                // Delete old file if exists
                if (Storage::disk('public')->exists($existingLampiran->file_path)) {
                    Storage::disk('public')->delete($existingLampiran->file_path);
                }
                
                // Update existing lampiran
                $existingLampiran->update([
                    'nama_doc' => $originalName,
                    'file_path' => $filePath,
                    'uploaded_at' => now()
                ]);
            } else {
                // Create new lampiran
                Lampiran::create([
                    'id_pengajuan_cuti' => $id,
                    'nama_doc' => $originalName,
                    'file_path' => $filePath,
                    'description' => 'Lampiran untuk pengajuan cuti'
                ]);
            }
        }

        // Ambil jenis cuti yang dipilih
        $jenisCuti = JenisCuti::find($request->jeniscuti_id);
        
        // Hitung jumlah hari
        $tglMulai = Carbon::parse($request->tgl_mulai);
        $tglSelesai = Carbon::parse($request->tgl_selesai);
        
        // Cek jenis cuti
        if ($jenisCuti->nama_cuti == 'Cuti Melahirkan') {
            // Tetapkan durasi 90 hari untuk cuti melahirkan
            $tglSelesai = (clone $tglMulai)->addDays(90 - 1); // -1 karena hari pertama sudah dihitung
            $jumlahHari = 90;
        } else {
            // Hitung jumlah hari kerja
            $jumlahHari = $this->hitungHariKerja($tglMulai, $tglSelesai);
        }
        
        // Update pengajuan cuti
        $pengajuanCuti->jeniscuti_id = $request->jeniscuti_id;
        $pengajuanCuti->tgl_pengajuan = $request->tgl_pengajuan;
        $pengajuanCuti->tgl_mulai = $tglMulai->toDateString();
        $pengajuanCuti->tgl_selesai = $tglSelesai->toDateString();
        $pengajuanCuti->jumlah_hari = $jumlahHari;
        $pengajuanCuti->alasan = $request->alasan;
        $pengajuanCuti->catatan = $request->catatan;
        $pengajuanCuti->alamat_saat_cuti = $request->alamat_saat_cuti;
        $pengajuanCuti->no_hp_cuti = $request->no_hp_cuti;
        $pengajuanCuti->masa_kerja = $request->masa_kerja;
        $pengajuanCuti->is_kabag = true; // Ensure is_kabag remains true
        $pengajuanCuti->save();
        
        return redirect()->route('kabagpengajuancutiumum.index')
            ->with('success', 'Pengajuan cuti berhasil diperbarui.');
    }


    public function destroy(string $id)
    {
        try {
            $user = Auth::user();
    
            // 1. Ambil data dengan eager loading relasi untuk pengecekan status
            $pengajuan = PengajuanCutiUmum::with([
                'cuStatusUserAdmin.cuStatusAdminKatimker.cuStatusKatimkerKabag.cuStatusKabagKabal'
            ])
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->where('is_kabag', true) // Filter khusus Kabag
            ->first();
    
            if (!$pengajuan) {
                return redirect()->route('kabagpengajuancutiumum.index')
                    ->with('error', "❌ Error: Pengajuan cuti tidak ditemukan atau bukan milik Anda.");
            }
    
            // 2. Cek apakah sudah disetujui Admin (Guard Clause)
            // Jika sudah disetujui admin, data tidak boleh dihapus sembarangan
            if ($pengajuan->cuStatusUserAdmin && 
                isset($pengajuan->cuStatusUserAdmin->status) && 
                $pengajuan->cuStatusUserAdmin->status == 'disetujui') {
                return redirect()->route('kabagpengajuancutiumum.index')
                    ->with('error', "❌ Error: Pengajuan cuti tidak dapat dihapus karena sudah disetujui Admin.");
            }
    
            // --- MULAI LOGIKA HAPUS FILE ---
            $lampiran = Lampiran::where('id_pengajuan_cuti', $id)->first();
            
            if ($lampiran && $lampiran->file_path) {
                // Path file di database (misal: lampiran/namafile.pdf)
                $filePath = $lampiran->file_path;
    
                // Cek file fisik di storage/app/public dan hapus
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                    Log::info("✅ File lampiran Kabag dihapus: " . $filePath);
                } else {
                    Log::warning("⚠️ File fisik tidak ditemukan: " . $filePath);
                }
    
                // Hapus record lampiran
                $lampiran->delete();
            }
            // --- SELESAI LOGIKA HAPUS FILE ---
    
            // 3. Hapus relasi status berjenjang (Manual Cascade Cleaning)
            // Ini memastikan tidak ada data sampah di tabel status
            if ($pengajuan->cuStatusUserAdmin) {
                if ($pengajuan->cuStatusUserAdmin->cuStatusAdminKatimker) {
                    if ($pengajuan->cuStatusUserAdmin->cuStatusAdminKatimker->cuStatusKatimkerKabag) {
                        if ($pengajuan->cuStatusUserAdmin->cuStatusAdminKatimker->cuStatusKatimkerKabag->cuStatusKabagKabal) {
                            $pengajuan->cuStatusUserAdmin->cuStatusAdminKatimker->cuStatusKatimkerKabag->cuStatusKabagKabal->delete();
                        }
                        $pengajuan->cuStatusUserAdmin->cuStatusAdminKatimker->cuStatusKatimkerKabag->delete();
                    }
                    $pengajuan->cuStatusUserAdmin->cuStatusAdminKatimker->delete();
                }
                $pengajuan->cuStatusUserAdmin->delete();
            }
    
            // 4. Hapus data utama pengajuan cuti
            $pengajuan->delete();
    
            return redirect()->route('kabagpengajuancutiumum.index')
                ->with('success', "✅ Pengajuan cuti dengan ID $id berhasil dihapus beserta lampirannya.");
    
        } catch (\Exception $e) {
            Log::error("Error deleting Kabag leave: " . $e->getMessage());
            
            return redirect()->route('kabagpengajuancutiumum.index')
                ->with('error', "❌ Terjadi kesalahan saat menghapus: " . $e->getMessage());
        }
    }

    /**
     * Cancel the specified cuti application.
     */
    /**
 * Cancel the specified cuti application for Kabag.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
    public function cancel($id)
    {
        try {
            $user = Auth::user(); // Get current logged in user

            // Check if the leave application exists and belongs to the current user
            $pengajuanCutiUmum = PengajuanCutiUmum::where('id', $id)
                ->where('user_id', $user->id)
                ->where('is_kabag', true)
                ->first();

            if (!$pengajuanCutiUmum) {
                return redirect()->route('kabagpengajuancutiumum.index')
                    ->with('error', "❌ Error: Pengajuan cuti dengan ID $id tidak ditemukan atau bukan milik Anda.");
            }

            // Check if the leave application has already been canceled
            $statusCutiUmum = DB::table('status_cuti_umums')
                ->where('id_cuti_umum', $id)
                ->first();
                
            if ($statusCutiUmum && $statusCutiUmum->status == 'dibatalkan') {
                return redirect()->route('kabagpengajuancutiumum.index')
                    ->with('info', "ℹ️ Pengajuan cuti dengan ID $id sudah dibatalkan sebelumnya.");
            }
            
            // Also check in relationship
            if ($pengajuanCutiUmum->statusCutiUmum && 
                $pengajuanCutiUmum->statusCutiUmum->status == 'dibatalkan') {
                return redirect()->route('kabagpengajuancutiumum.index')
                    ->with('info', "ℹ️ Pengajuan cuti dengan ID $id sudah dibatalkan sebelumnya.");
            }

            // Check if already approved by Kepala Balai
            $isApprovedByKabal = false;
            if ($pengajuanCutiUmum->cuStatusUserAdmin && 
                $pengajuanCutiUmum->cuStatusUserAdmin->cuStatusAdminKabal && 
                $pengajuanCutiUmum->cuStatusUserAdmin->cuStatusAdminKabal->status == 'disetujui') {
                $isApprovedByKabal = true;
            }

            // If approved by Kepala Balai, prevent cancellation
            if ($isApprovedByKabal) {
                return redirect()->route('kabagpengajuancutiumum.index')
                    ->with('error', "❌ Error: Pengajuan cuti yang sudah disetujui oleh Kepala Balai tidak dapat dibatalkan.");
            }

            // Update or create status in status_cuti_umums table
            DB::table('status_cuti_umums')->updateOrInsert(
                ['id_cuti_umum' => $id],
                [
                    'status' => 'dibatalkan',
                    'catatan' => 'Dibatalkan oleh kabag pada ' . now()->format('d-m-Y H:i:s'),
                    'updated_at' => now(),
                    'created_at' => now()
                ]
            );

            // Log keberhasilan
            Log::info("Pengajuan cuti kabag dengan ID $id berhasil dibatalkan oleh user ID: $user->id");

            return redirect()->route('kabagpengajuancutiumum.index')
                ->with('success', '✅ Permohonan cuti Anda telah berhasil dibatalkan.');
        } catch (\Exception $e) {
            // Log the error
            Log::error("Error canceling leave application for kabag: " . $e->getMessage());
            
            // Return with error message
            return redirect()->route('kabagpengajuancutiumum.index')
                ->with('error', "❌ Terjadi kesalahan saat membatalkan pengajuan cuti: " . $e->getMessage());
        }
    }

    /**
     * Get the history of cuti applications.
     */
    public function history()
    {
        $user = Auth::user();
        $pengajuanCuti = PengajuanCutiUmum::with('jenisCuti')
            ->where('user_id', $user->id)
            ->where('is_kabag', true)
            ->whereIn('status', ['Disetujui', 'Ditolak', 'Dibatalkan'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard.kepalabagian.pengajuan-cuti.history', compact('pengajuanCuti'));
    }

    /**
     * Delete lampiran for a cuti application.
     */
    public function deleteLampiran($id)
    {
        try {
            $lampiran = Lampiran::where('id_pengajuan_cuti', $id)
                ->where(function ($query) {
                    $query->whereHas('pengajuanCuti', function ($q) {
                        $q->where('user_id', Auth::id())
                          ->where('is_kabag', true);
                    });
                })
                ->firstOrFail();
            
            // Delete the actual file
            if (Storage::disk('public')->exists($lampiran->file_path)) {
                Storage::disk('public')->delete($lampiran->file_path);
            }
            
            // Delete the database record
            $lampiran->delete();
            
            return redirect()->back()->with('success', 'Lampiran berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus lampiran: ' . $e->getMessage());
        }
    }

    /**
     * Calculate working days between two dates (excluding holidays).
     */
    private function hitungHariKerja(Carbon $start, Carbon $end)
    {
        // Pastikan tanggal mulai tidak lebih besar dari tanggal selesai
        if ($start->gt($end)) {
            return 0;
        }
        
        $days = 0;
        $current = clone $start;
        
        while ($current->lte($end)) {
            // Periksa apakah hari kerja (bukan Sabtu atau Minggu)
            if ($current->isWeekday()) {
                $days++;
            }
            $current->addDay();
        }
        
        return $days;
    }

    /**
     * Calculate normal leave duration via AJAX.
     */
    public function hitungDurasiCuti(Request $request)
    {
        $request->validate([
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date',
            'jenis_cuti' => 'required|exists:jenis_cuti,id'
        ]);
        
        $tglMulai = Carbon::parse($request->tgl_mulai);
        $tglSelesai = Carbon::parse($request->tgl_selesai);
        
        // Cek jenis cuti
        $jenisCuti = JenisCuti::find($request->jenis_cuti);
        
        // Hitung jumlah hari kerja
        $jumlahHari = $this->hitungHariKerja($tglMulai, $tglSelesai);
        
        return response()->json(['jumlah_hari' => $jumlahHari]);
    }
    
    /**
     * Calculate maternity leave end date and duration via AJAX.
     */
    public function hitungCutiMelahirkan(Request $request)
    {
        $tglMulai = Carbon::parse($request->tgl_mulai);
        $tglSelesai = $tglMulai->addMonths(3); 
    
        return response()->json([
            'jumlah_hari' => 90, 
            'tgl_selesai' => $tglSelesai->format('Y-m-d')
        ]);
    }
}