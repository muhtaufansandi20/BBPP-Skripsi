<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AnggotaTim;
use App\Models\TandaTangan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\KuotaCutiTahunan;
use App\Models\PengajuanCutiUmum;
use App\Models\PengajuanCutiTahunan;
use App\Models\VerifikasiTtdCutiUmum;
use App\Models\VerifikasiTtdCutiTahunan;
use Illuminate\Support\Facades\Auth;
    

class PdfController extends Controller
{
    public function viewPDF($id)
    {
        // Ambil data pengajuan cuti berdasarkan ID
        $cuti = PengajuanCutiTahunan::with(['user', 'kuota'])->findOrFail($id);

        // Cek otorisasi: Pengguna hanya bisa lihat cuti miliknya sendiri
        // kecuali jika dia adalah admin, kepalabagian, atau kepalabalai
        $currentUser = Auth::user();
        $allowedRoles = ['admin', 'kepalabagian', 'kepalabalai'];
        
        if ($cuti->user_id == $currentUser->id) {
            // User dapat melihat cuti miliknya sendiri
            // Tidak perlu cek lagi
        } elseif (in_array(strtolower($currentUser->role), $allowedRoles)) {
            // Admin, kepalabagian, dan kepalabalai dapat melihat semua cuti
            // Tidak perlu cek lagi
        } elseif (strtolower($currentUser->role) == 'katimker') {
            // Untuk katimker, cek apakah yang mengajukan cuti adalah anggota timnya
            // Cari tim ID dari katimker
            $katimkerTeam = AnggotaTim::where('user_id', $currentUser->id)
                                      ->where('role', 'ketua')
                                      ->first();
            
            if (!$katimkerTeam) {
                abort(403, 'Unauthorized action.');
            }
            
            // Cek apakah user yang mengajukan cuti merupakan anggota tim dari katimker
            $isTeamMember = AnggotaTim::where('user_id', $cuti->user_id)
                                      ->where('tim_id', $katimkerTeam->tim_id)
                                      ->exists();
            
            if (!$isTeamMember) {
                abort(403, 'Unauthorized action.');
            }
        } else {
            // User lainnya tidak diizinkan melihat cuti orang lain
            abort(403, 'Unauthorized action.');
        }

        // Ambil data kuota cuti berdasarkan user_id
        $kuota = KuotaCutiTahunan::where('user_id', $cuti->user_id)->first();
        
        // Ambil data kepala balai (user dengan role kepalabalai)
        $kepalaBalai = User::where('role', 'kepalabalai')->first(); 
        
        // Ambil data kepala bagian (user dengan role kepalabagian)
        $kepalaUmum = User::where('role', 'kepalabagian')->first();

        // Cek status verifikasi tanda tangan
        $verifikasi = VerifikasiTtdCutiTahunan::where('pengajuan_cuti_tahunan_id', $id)->first();
        
        // Ambil path tanda tangan jika sudah diverifikasi
        $ttdKabagPath = null;
        $ttdKabalaiPath = null;
        
        if ($verifikasi && $verifikasi->ttd_kabag) {
            $tandaTanganKabag = TandaTangan::where('role', 'kepalabagian')->first();
            if ($tandaTanganKabag && $tandaTanganKabag->gambar_ttd_path) {
                $ttdKabagPath = $tandaTanganKabag->gambar_ttd_path;
            }
        }
        
        if ($verifikasi && $verifikasi->ttd_kabalai) {
            $tandaTanganKabalai = TandaTangan::where('role', 'kepalabalai')->first();
            if ($tandaTanganKabalai && $tandaTanganKabalai->gambar_ttd_path) {
                $ttdKabalaiPath = $tandaTanganKabalai->gambar_ttd_path;
            }
        }

        // Format nama file: NamaUser-SuratPengajuanCuti.pdf
        $userName = str_replace(' ', '_', strtolower($cuti->user->name ?? 'user')); 
        $fileName = $userName . '-SuratPengajuanCuti.pdf';

        // Load view dengan data dan tampilkan sebagai PDF di browser
        return Pdf::loadView('pdf.TemplateSuratCutiTahunan', compact(
            'cuti', 
            'kuota', 
            'kepalaBalai', 
            'kepalaUmum', 
            'verifikasi', 
            'ttdKabagPath', 
            'ttdKabalaiPath'
        ))
            ->setPaper('F4', 'portrait') // Set ukuran kertas F4
            ->stream($fileName);
    }
    
    public function viewPDFUmum($id)
    {
        // Ambil data cuti umum berdasarkan ID
        $cuti = PengajuanCutiUmum::with(['jenisCuti', 'user'])->findOrFail($id);
        
        // Cek otorisasi
        $currentUser = Auth::user();
        $allowedRoles = ['admin', 'kepalabagian', 'kepalabalai'];
        
        if ($cuti->user_id == $currentUser->id) {
            // User dapat melihat cuti miliknya sendiri
        } elseif (in_array(strtolower($currentUser->role), $allowedRoles)) {
            // Admin, kepalabagian, dan kepalabalai dapat melihat semua cuti
        } elseif (strtolower($currentUser->role) == 'katimker') {
            // Untuk katimker, cek apakah yang mengajukan cuti adalah anggota timnya
            $katimkerTeam = AnggotaTim::where('user_id', $currentUser->id)
                                      ->where('role', 'ketua')
                                      ->first();
            
            if (!$katimkerTeam) {
                abort(403, 'Unauthorized action.');
            }
            
            // Cek apakah user yang mengajukan cuti merupakan anggota tim dari katimker
            $isTeamMember = AnggotaTim::where('user_id', $cuti->user_id)
                                      ->where('tim_id', $katimkerTeam->tim_id)
                                      ->exists();
            
            if (!$isTeamMember) {
                abort(403, 'Unauthorized action.');
            }
        } else {
            // User lainnya tidak diizinkan melihat cuti orang lain
            abort(403, 'Unauthorized action.');
        }
        
        // Ambil data kuota cuti berdasarkan user_id
        $kuota = KuotaCutiTahunan::where('user_id', $cuti->user_id)->first();
        
        // Ambil data kepala balai (user dengan role kepalabalai)
        $kepalaBalai = User::where('role', 'kepalabalai')->first();
        
        // Ambil data kepala bagian (user dengan role kepalabagian)
        $kepalaUmum = User::where('role', 'kepalabagian')->first();
        
        // Cek status verifikasi tanda tangan
        $verifikasi = VerifikasiTtdCutiUmum::where('pengajuan_cuti_umum_id', $id)->first();
        
        // Ambil path tanda tangan jika sudah diverifikasi
        $ttdKabagPath = null;
        $ttdKabalaiPath = null;
        
        if ($verifikasi && $verifikasi->ttd_kabag) {
            $tandaTanganKabag = TandaTangan::where('role', 'kepalabagian')->first();
            if ($tandaTanganKabag && $tandaTanganKabag->gambar_ttd_path) {
                $ttdKabagPath = $tandaTanganKabag->gambar_ttd_path;
            }
        }
        
        if ($verifikasi && $verifikasi->ttd_kabalai) {
            $tandaTanganKabalai = TandaTangan::where('role', 'kepalabalai')->first();
            if ($tandaTanganKabalai && $tandaTanganKabalai->gambar_ttd_path) {
                $ttdKabalaiPath = $tandaTanganKabalai->gambar_ttd_path;
            }
        }
        
        // Format nama file: NamaUser-SuratCutiUmum-JenisCuti.pdf
        $userName = str_replace(' ', '_', strtolower($cuti->user->name ?? 'user'));
        $jenisCuti = str_replace(' ', '_', strtolower($cuti->jenisCuti->nama_cuti ?? 'umum'));
        $fileName = $userName . '-SuratCutiUmum-' . $jenisCuti . '.pdf';
        
        // Load view dengan data dan tampilkan sebagai PDF di browser
        return Pdf::loadView('pdf.TemplateSuratCutiUmum', compact(
            'cuti',
            'kuota',
            'kepalaBalai',
            'kepalaUmum',
            'verifikasi',
            'ttdKabagPath',
            'ttdKabalaiPath'
        ))
            ->setPaper('F4', 'portrait') // Set ukuran kertas F4
            ->stream($fileName);
    }

    public function viewPDFByType($id, $type)
    {
        if ($type == 'tahunan') {
            return $this->viewPDF($id);
        } elseif ($type == 'umum') {
            return $this->viewPDFUmum($id);
        } else {
            abort(404, 'Invalid leave type');
        }
    }

    public function generatePDF()
    {
        // Cek otorisasi: Hanya admin yang bisa mengakses fungsi ini
        $currentUser = Auth::user();
        if (strtolower($currentUser->role) != 'admin') {
            abort(403, 'Unauthorized action.');
        }
        
        // Ambil data dari database
        $users = User::all();

        // Generate dan download PDF
        return Pdf::loadView('pdf.TemplateSuratCutiTahunan', compact('users'))
                    ->setPaper('F4', 'portrait')
                    ->download('users.pdf');
    }
}