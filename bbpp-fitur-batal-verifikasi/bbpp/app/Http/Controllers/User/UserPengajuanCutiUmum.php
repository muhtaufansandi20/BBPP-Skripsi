<?php

namespace App\Http\Controllers\User;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Lampiran;
use App\Models\JenisCuti;
use App\Models\MasaKerja;
use App\Models\AnggotaTim;
use Illuminate\Http\Request;
use App\Models\StatusCutiUmum;
use App\Models\RiwayatCutiUmum;
use App\Models\KuotaCutiTahunan;
use App\Models\PengajuanCutiUmum;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class UserPengajuanCutiUmum extends Controller
{
    /**
     * Display a listing of the cuti applications.
     *
     * @return \Illuminate\Http\Response
     */ 
    // public function index()
    // {
    //     $user = Auth::user();
        
    //     $pengajuans = PengajuanCutiUmum::with('jenisCuti')
    //         ->where('user_id', $user->id)
    //         ->orderBy('created_at', 'desc')
    //         ->paginate(10); // Ubah get() menjadi paginate() dengan jumlah item per halaman
    
    //     return view('dashboard.user.datapengajuancutiumum-user', compact('pengajuans'));
    // }

    public function index()
    {
        $user = Auth::user();
        $userId = $user->id;
        $hasTeam = AnggotaTim::where('user_id', $userId)->exists();
        $checkVerifikasi = KuotaCutiTahunan::where('user_id', $userId)->first();
        $admin = User::where('role', 'admin')->first();
        $hasWorkPeriod = MasaKerja::where('user_id', $userId)->exists();
        
        // Load pengajuan cuti umum with all its status relations
        $pengajuans = PengajuanCutiUmum::with([
            'jenisCuti',
            'cuStatusUserAdmin.cuStatusAdminKatimker.cuStatusKatimkerKabag.cuStatusKabagKabal',
            'StatusCutiUmum'
        ])
        ->where('user_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('dashboard.user.datapengajuancutiumum-user', compact(
            'pengajuans', 
            'checkVerifikasi', 
            'hasTeam',
            'user',
            'admin',
            'hasWorkPeriod'
        ));
    }


    /**
     * Show the form for creating a new cuti application.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {    
        // $user = Auth::user(); 
        $userId = Auth::user()->id;
        // $userId = $user->id;

        $jenisCuti = JenisCuti::all();
        $checkUser = MasaKerja::where('user_id', $userId)->exists(); 
        $masakerja = MasaKerja::where('user_id', $userId)->first(); 
        $no_hp_cuti = User::where('id', $userId)->value('no_hp');

        return view('dashboard.user.createpengajuancutiumum-user', compact('jenisCuti', 'no_hp_cuti', 'checkUser', 'masakerja'));
    }

    /**
     * Store a newly created cuti application in storage. 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // Validasi data
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
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
            
            // Simpan data pengajuan cuti dengan Eloquent untuk konsistensi
            $pengajuanCuti = PengajuanCutiUmum::create([
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
            ]);

            // Buat status cuti
            StatusCutiUmum::create([
                'id_cuti_umum' => $pengajuanCuti->id,
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
                    'id_pengajuan_cuti' => $pengajuanCuti->id,
                    'nama_doc' => $originalName,
                    'file_path' => $filePath,
                    'description' => 'Lampiran pengajuan cuti ' . $namaJenisCuti . ' ' . $namaUser,
                ]);
                                
                Log::info('Lampiran berhasil disimpan: ' . $filePath);
            }
            
            return redirect()->route('userpengajuancutiumum.index')
                ->with('success', 'Pengajuan cuti berhasil disimpan.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error saat menyimpan pengajuan cuti: ' . $e->getMessage());
            return redirect()->back()->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan: ' . $e->getMessage());
        }
    }
    /**
     * Display the specified cuti application.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pengajuan = PengajuanCutiUmum::with([
            'user',
            'cuStatusUserAdmin.cuStatusAdminKatimker.cuStatusKatimkerKabag.cuStatusKabagKabal',
            'statusCutiUmum' // Sesuaikan dengan nama relasi yang benar
        ])->where('id', $id)->firstOrFail();

        // Get lampiran data
        $lampiran = Lampiran::where('id_pengajuan_cuti', $id)->first();

        // Default nilai jika tidak ditemukan
        $ketuaNama = 'Tidak ditemukan';
        $ketuaNIP = '-';
        $ketuaJabatan = '-';
        $kepalaBagianNama = 'Tidak ditemukan';
        $kepalaBagianNIP = '-';
        $kepalaBagianJabatan = '-';
        $kepalaBalaiNama = 'Tidak ditemukan';
        $kepalaBalaiNIP = '-';
        $kepalaBalaiJabatan = '-';

        // Default status dan catatan
        $statusAdmin = 'Belum diproses';
        $statusKatimker = 'Belum diproses';
        $statusKabag = 'Belum diproses';
        $statusKabal = 'Belum diproses';

        $catatanAdmin = 'Tidak ada catatan';
        $catatanKatimker = 'Tidak ada catatan';
        $catatanKabag = 'Tidak ada catatan';
        $catatanKabal = 'Tidak ada catatan';

        // Cek status pembatalan
        $statusPembatalan = 'Belum dibatalkan';
        $catatanPembatalan = 'Tidak ada catatan';
        
        // Perbaikan untuk akses statusCutiUmum
        if ($pengajuan->statusCutiUmum) {
            $statusPembatalan = $pengajuan->statusCutiUmum->status;
            $catatanPembatalan = $pengajuan->statusCutiUmum->catatan ?? 'Tidak ada catatan';
        }

        // Mencari anggota tim yang mengajukan cuti
        $anggotaTim = AnggotaTim::where('user_id', $pengajuan->user_id)->first();

        // Jika anggota tim ditemukan, cari ketua tim
        if ($anggotaTim) {
            $ketuaTim = AnggotaTim::where('tim_id', $anggotaTim->tim_id)
                ->where('role', 'Ketua')
                ->with('user')
                ->first();

            if ($ketuaTim) {
                $ketuaNama = $ketuaTim->user->name ?? 'Tidak ada nama';
                $ketuaNIP = $ketuaTim->user->nip ?? '-';
                $ketuaJabatan = $ketuaTim->user->jabatan ?? '-';
            }
        }

        // Mencari Kepala Bagian
        $kepalaBagian = User::where('role', 'Kepalabagian')->first();
        if ($kepalaBagian) {
            $kepalaBagianNama = $kepalaBagian->name;
            $kepalaBagianNIP = $kepalaBagian->nip;
            $kepalaBagianJabatan = $kepalaBagian->jabatan;
        }

        // Mencari Kepala Balai
        $kepalaBalai = User::where('role', 'Kepalabalai')->first();
        if ($kepalaBalai) {
            $kepalaBalaiNama = $kepalaBalai->name;
            $kepalaBalaiNIP = $kepalaBalai->nip;
            $kepalaBalaiJabatan = $kepalaBalai->jabatan;
        }

        // Mengambil status & catatan pengajuan cuti umum di berbagai level persetujuan
        $statusAdmin = $pengajuan->cuStatusUserAdmin->status ?? 'Belum diproses';
        $statusKatimker = $pengajuan->cuStatusUserAdmin->cuStatusAdminKatimker->status ?? 'Belum diproses';
        $statusKabag = $pengajuan->cuStatusUserAdmin->cuStatusAdminKatimker->cuStatusKatimkerKabag->status ?? 'Belum diproses';
        $statusKabal = $pengajuan->cuStatusUserAdmin->cuStatusAdminKatimker->cuStatusKatimkerKabag->cuStatusKabagKabal->status ?? 'Belum diproses';

        // Menambahkan catatan dari tiap level
        $catatanAdmin = $pengajuan->cuStatusUserAdmin->catatan ?? 'Tidak ada catatan';
        $catatanKatimker = $pengajuan->cuStatusUserAdmin->cuStatusAdminKatimker->catatan ?? 'Tidak ada catatan';
        $catatanKabag = $pengajuan->cuStatusUserAdmin->cuStatusAdminKatimker->cuStatusKatimkerKabag->catatan ?? 'Tidak ada catatan';
        $catatanKabal = $pengajuan->cuStatusUserAdmin->cuStatusAdminKatimker->cuStatusKatimkerKabag->cuStatusKabagKabal->catatan ?? 'Tidak ada catatan';

        return view('dashboard.user.detailpengajuancutiumum-user', compact(
            'pengajuan',
            'ketuaNama', 
            'ketuaNIP', 
            'ketuaJabatan', 
            'kepalaBagianNama', 
            'kepalaBagianNIP', 
            'kepalaBagianJabatan',
            'kepalaBalaiNama', 
            'kepalaBalaiNIP', 
            'kepalaBalaiJabatan',
            'statusAdmin',
            'statusKatimker',
            'statusKabag',
            'statusKabal',
            'catatanAdmin',
            'catatanKatimker',
            'catatanKabag',
            'catatanKabal',
            'lampiran',
            'statusPembatalan',
            'catatanPembatalan'
        ));
    }


    /**
     * Show the form for editing the specified cuti application.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // tes
    }

    /**
     * Update the specified cuti application in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pengajuanCuti = PengajuanCutiUmum::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'Pending')
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
            'mk_tahun' => 'required|integer',
            'mk_bulan' => 'required|integer',
            'catatan' => 'nullable|string',
            'lampiran' => 'nullable|file|max:2048', // Opsional, maksimal 2MB
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
        
        // Validasi tambahan berdasarkan jenis cuti
        if ($jenisCuti->nama_cuti == 'Cuti Besar' && $jumlahHari > 90) {
            return redirect()->back()->withInput()->withErrors(['tgl_selesai' => 'Durasi cuti tidak boleh lebih dari 90 hari.']);
        }
        
        // Proses file lampiran jika ada
        if ($request->hasFile('lampiran')) {
            // Hapus lampiran lama jika ada
            if ($pengajuanCuti->lampiran) {
                Storage::disk('public')->delete($pengajuanCuti->lampiran);
            }
            
            $lampiran = $request->file('lampiran');
            $namaFile = time() . '_' . $lampiran->getClientOriginalName();
            $pathLampiran = $lampiran->storeAs('lampiran_cuti', $namaFile, 'public');
            $pengajuanCuti->lampiran = $pathLampiran;
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
        $pengajuanCuti->mk_tahun = $request->mk_tahun;
        $pengajuanCuti->mk_bulan = $request->mk_bulan;
        $pengajuanCuti->save();
        
        return redirect()->route('userpengajuancutiumum.index')
            ->with('success', 'Pengajuan cuti berhasil diperbarui.');
    }

    /**
     * Cancel the specified general leave application.
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
                ->first();

            if (!$pengajuanCutiUmum) {
                return redirect()->route('userpengajuancutiumum.index')
                    ->with('error', "❌ Error: Pengajuan cuti dengan ID $id tidak ditemukan atau bukan milik Anda.");
            }

            // Check if the leave application has already been canceled
            // Check in status_cuti_umums table - use the correct foreign key (likely id_cuti_umum)
            $statusCutiUmum = DB::table('status_cuti_umums')
                ->where('id_cuti_umum', $id) // Use the actual column name as in your database
                ->first();
                
            if ($statusCutiUmum && $statusCutiUmum->status == 'dibatalkan') {
                return redirect()->route('userpengajuancutiumum.index')
                    ->with('info', "ℹ️ Pengajuan cuti dengan ID $id sudah dibatalkan sebelumnya.");
            }
            
            // Also check in administrative approval chain
            if ($pengajuanCutiUmum->statusCutiUmum && 
                $pengajuanCutiUmum->statusCutiUmum->status == 'dibatalkan') {
                return redirect()->route('userpengajuancutiumum.index')
                    ->with('info', "ℹ️ Pengajuan cuti dengan ID $id sudah dibatalkan sebelumnya.");
            }

            // Check if already approved by Kepala Balai
            $isApprovedByKabal = false;
            if ($pengajuanCutiUmum->cuStatusUserAdmin && 
                $pengajuanCutiUmum->cuStatusUserAdmin->cuStatusAdminKatimker && 
                $pengajuanCutiUmum->cuStatusUserAdmin->cuStatusAdminKatimker->cuStatusKatimkerKabag && 
                $pengajuanCutiUmum->cuStatusUserAdmin->cuStatusAdminKatimker->cuStatusKatimkerKabag->cuStatusKabagKabal && 
                $pengajuanCutiUmum->cuStatusUserAdmin->cuStatusAdminKatimker->cuStatusKatimkerKabag->cuStatusKabagKabal->status == 'disetujui') {
                $isApprovedByKabal = true;
            }

            // If approved by Kepala Balai, prevent cancellation
            if ($isApprovedByKabal) {
                return redirect()->route('userpengajuancutiumum.index')
                    ->with('error', "❌ Error: Pengajuan cuti yang sudah disetujui oleh Kepala Balai tidak dapat dibatalkan.");
            }

            // Update or create status in status_cuti_umums table
            DB::table('status_cuti_umums')->updateOrInsert(
                ['id_cuti_umum' => $id], // Use the actual column name as in your database
                [
                    'status' => 'dibatalkan',
                    'catatan' => 'Dibatalkan oleh user pada ' . now()->format('d-m-Y H:i:s'),
                    'updated_at' => now(),
                    'created_at' => now()
                ]
            );

            return redirect()->route('userpengajuancutiumum.index')
                ->with('success', '✅ Permohonan cuti Anda telah berhasil dibatalkan.');
        } catch (\Exception $e) {
            // Log the error
            Log::error("Error canceling leave application: " . $e->getMessage());
            
            // Return with error message
            return redirect()->route('userpengajuancutiumum.index')
                ->with('error', "❌ Terjadi kesalahan saat membatalkan pengajuan cuti: " . $e->getMessage());
        }
    }

    /**
     * Remove the specified general leave application from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     public function destroy($id)
     {
         try {
             $user = Auth::user();
             
             // 1. Ambil data pengajuan
             $pengajuanCutiUmum = PengajuanCutiUmum::with([
                 'cuStatusUserAdmin.cuStatusAdminKatimker.cuStatusKatimkerKabag.cuStatusKabagKabal'
             ])
             ->where('id', $id)
             ->where('user_id', $user->id)
             ->first();
             
             if (!$pengajuanCutiUmum) {
                 return redirect()->route('userpengajuancutiumum.index')
                     ->with('error', "❌ Error: Pengajuan cuti tidak ditemukan.");
             }
             
             // 2. Cek status (Guard Clause)
             if ($pengajuanCutiUmum->cuStatusUserAdmin && 
                 isset($pengajuanCutiUmum->cuStatusUserAdmin->status) && 
                 $pengajuanCutiUmum->cuStatusUserAdmin->status == 'disetujui') {
                 return redirect()->route('userpengajuancutiumum.index')
                     ->with('error', "❌ Error: Pengajuan yang sudah disetujui tidak dapat dihapus.");
             }
 
             // --- MULAI PERBAIKAN LOGIKA HAPUS FILE ---
             $lampiran = Lampiran::where('id_pengajuan_cuti', $id)->first();
             
             if ($lampiran && $lampiran->file_path) {
                 // KOREKSI UTAMA DISINI:
                 // Gunakan langsung value dari database karena formatnya sudah "lampiran/namafile.pdf"
                 $filePath = $lampiran->file_path; 
 
                 // Debugging (Opsional: Cek di Log apakah path sudah benar)
                 Log::info('Mencoba menghapus file di path: ' . $filePath);
 
                 // Cek dan Hapus menggunakan Storage Disk Public
                 if (Storage::disk('public')->exists($filePath)) {
                     Storage::disk('public')->delete($filePath);
                     Log::info('✅ File fisik berhasil dihapus.');
                 } else {
                     Log::warning('⚠️ File fisik tidak ditemukan di path: ' . $filePath);
                 }
                 
                 // Hapus record lampiran di database
                 $lampiran->delete();
             }
             // --- SELESAI LOGIKA HAPUS FILE ---
             
             // 3. Hapus relasi status (Cascading manual jika perlu)
             if ($pengajuanCutiUmum->cuStatusUserAdmin) {
                 if ($pengajuanCutiUmum->cuStatusUserAdmin->cuStatusAdminKatimker) {
                     if ($pengajuanCutiUmum->cuStatusUserAdmin->cuStatusAdminKatimker->cuStatusKatimkerKabag) {
                         if ($pengajuanCutiUmum->cuStatusUserAdmin->cuStatusAdminKatimker->cuStatusKatimkerKabag->cuStatusKabagKabal) {
                             $pengajuanCutiUmum->cuStatusUserAdmin->cuStatusAdminKatimker->cuStatusKatimkerKabag->cuStatusKabagKabal->delete();
                         }
                         $pengajuanCutiUmum->cuStatusUserAdmin->cuStatusAdminKatimker->cuStatusKatimkerKabag->delete();
                     }
                     $pengajuanCutiUmum->cuStatusUserAdmin->cuStatusAdminKatimker->delete();
                 }
                 $pengajuanCutiUmum->cuStatusUserAdmin->delete();
             }
             
             // 4. Hapus data utama
             $pengajuanCutiUmum->delete();
             
             return redirect()->route('userpengajuancutiumum.index')
                 ->with('success', "✅ Pengajuan cuti dan lampirannya berhasil dihapus.");
                 
         } catch (\Exception $e) {
             Log::error("Error deleting leave application: " . $e->getMessage());
             return redirect()->route('userpengajuancutiumum.index')
                 ->with('error', "❌ Terjadi kesalahan: " . $e->getMessage());
         }
     }

    
    /**
     * Get the history of cuti applications.
     *
     * @return \Illuminate\Http\Response
     */
    public function history()
    {
        $user = Auth::user();
        $pengajuanCuti = PengajuanCutiUmum::with('jenisCuti')
            ->where('user_id', $user->id)
            ->whereIn('status', ['Disetujui', 'Ditolak', 'Dibatalkan'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard.user.pengajuan-cuti.history', compact('pengajuanCuti'));
    }
    

    /**
     * Menghitung jumlah hari kerja antara dua tanggal (tidak termasuk hari libur).
     *
     * @param  \Carbon\Carbon  $start
     * @param  \Carbon\Carbon  $end
     * @return int
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
     * Menghitung jumlah hari cuti normal via AJAX.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
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
     * Menghitung tanggal selesai dan jumlah hari untuk cuti melahirkan via AJAX.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */

     public function hitungCutiMelahirkan(Request $request)
     {
         $tglMulai = Carbon::parse($request->tgl_mulai);
         $tglSelesai = $tglMulai->addMonths(3); 
     
         return response()->json([
             'jumlah_hari' => 3, 
             'tgl_selesai' => $tglSelesai->format('Y-m-d')
         ]);
     }     
     


    

}