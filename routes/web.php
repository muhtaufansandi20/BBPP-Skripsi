<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PDFController;

// Admin Controllers
use App\Http\Controllers\user\UserController;
use App\Http\Controllers\Admin\AdminKalenderCuti;
use App\Http\Controllers\Admin\AdminMasaKerja;
use App\Http\Controllers\Admin\AdminPenomoranSuratCuti;

// User Controllers
use App\Http\Controllers\User\UserPengajuanCutiTahunan;
use App\Http\Controllers\User\UserPengajuanCutiUmum;

// Verifikator Controllers
use App\Http\Controllers\KepalaTimKerja\KatimkerPengajuanCutiTahunan;
use App\Http\Controllers\KepalaTimKerja\KatimkerPengajuanCutiUmum;
use App\Http\Controllers\KepalaBagian\KabagPengajuanCutiTahunan;
use App\Http\Controllers\KepalaBagian\KabagPengajuanCutiUmum;
use App\Http\Controllers\KepalaBagian\KabagVerifikasiCutiUmum;
use App\Http\Controllers\KepalaBagian\CtStatusKatimkerKabag;
use App\Http\Controllers\KepalaBalai\CtStatusKabagKabal;
use App\Http\Controllers\KepalaBalai\KabalaiVerifikasiCutiUmum;
use App\Http\Controllers\Widyaiswara\WidyaiswaraPengajuanCutiTahunan;
use App\Http\Controllers\Widyaiswara\WidyaiswaraPengajuanCutiUmum;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Dashboard & Profile
    Route::get('/dashboard', [HomeController::class, 'index'])->middleware('verified')->name('dashboard');
    Route::post('/dashboard/update', [ProfileController::class, 'update'])->name('dashboard.update');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dokumen PDF (Stream & Download)
    Route::get('/preview-pdf/{id}', [PDFController::class, 'viewPDF'])->name('previewPDF');
    Route::get('/view-pdf/{id}', [PDFController::class, 'viewPDF'])->name('viewPDF');
    Route::get('/view-pdf-umum/{id}', [PDFController::class, 'viewPDFUmum'])->name('viewPDFUmum');
    Route::get('/download-pdf', [PDFController::class, 'generatePDF'])->name('downloadPDF');

    // Pengajuan Cuti Helper & Durasi
    Route::get('/hitungDurasiCuti', [UserPengajuanCutiUmum::class, 'hitungDurasiCuti'])->name('hitungDurasiCuti');
    Route::post('/hitungDurasiCuti', [UserPengajuanCutiUmum::class, 'hitungDurasiCuti'])->name('hitungDurasiCuti.post');
    Route::post('/hitung-cuti-melahirkan', [UserPengajuanCutiUmum::class, 'hitungCutiMelahirkan'])->name('hitungCutiMelahirkan');
    Route::get('/getJenisCutiDetail', [UserPengajuanCutiUmum::class, 'getJenisCutiDetail'])->name('userpengajuancutiumum.getJenisCutiDetail');
    Route::get('/user/pengajuan-cuti-umum/{id}/delete-lampiran', [UserPengajuanCutiUmum::class, 'deleteLampiran'])->name('userpengajuancutiumum.deleteLampiran');
    Route::post('/calculate-business-days', 'App\Http\Controllers\LeaveController@calculateBusinessDays')->name('calculate.business.days');

    // Verifikasi & Persetujuan Berjenjang (TTD Elektronik)
    Route::post('/ctstatuskatimkerkabag/approve-with-signature', [CtStatusKatimkerKabag::class, 'approveWithSignature'])->name('ctstatuskatimkerkabag.approve-with-signature');
    Route::post('/ctstatuskabagkabal/store-kabag', [CtStatusKabagKabal::class, 'storeKabag'])->name('ctstatuskabagkabal.store-kabag');
    Route::post('/ctstatuskabagkabal/approve-kabag-with-signature', [CtStatusKabagKabal::class, 'approveKabagWithSignature'])->name('ctstatuskabagkabal.approve-kabag-with-signature');
    Route::post('/kepalabalai/ctstatus/approve-with-signature-kabal', [CtStatusKabagKabal::class, 'approveWithSignatureKabal'])->name('ctstatuskabagkabal.approve-with-signature-kabal');

    Route::post('/kabag/cuti-umum/approve-with-signature', [KabagVerifikasiCutiUmum::class, 'approveWithSignature'])->name('kabag.cuti-umum.approve-with-signature');
    Route::post('/verifikasi-cuti-umum-kabag', [KabalaiVerifikasiCutiUmum::class, 'storeKabag'])->name('kabalaiverifikasicutiumum.store-kabag');
    Route::post('/approve-with-signature-cuti-umum-kabag', [KabalaiVerifikasiCutiUmum::class, 'approveKabagWithSignature'])->name('kabalaiverifikasicutiumum.approve-with-signature-kabag');
    Route::post('/kabalai/verifikasi-cuti-umum/approve-with-signature', [KabalaiVerifikasiCutiUmum::class, 'approveWithSignature'])->name('kabalverivikasicutiumum.approve-with-signature');

    // Pembatalan (Cancel) Pengajuan Cuti
    Route::post('/userpengajuancutitahunan/{id}/cancel', [UserPengajuanCutiTahunan::class, 'cancel'])->name('userpengajuancutitahunan.cancel');
    Route::post('/katimkerpengajuancutitahunan/{id}/cancel', [KatimkerPengajuanCutiTahunan::class, 'cancel'])->name('katimkerpengajuancutitahunan.cancel');
    Route::post('/kabagpengajuancutitahunan/{id}/cancel', [KabagPengajuanCutiTahunan::class, 'cancel'])->name('kabagpengajuancutitahunan.cancel');
    Route::post('/pengajuan-cuti-umum/{id}/cancel', [UserPengajuanCutiUmum::class, 'cancel'])->name('userpengajuancutiumum.cancel');
    Route::post('/katimker/pengajuan-cuti-umum/{id}/cancel', [KatimkerPengajuanCutiUmum::class, 'cancel'])->name('katimkerpengajuancutitahunan.cancel');
    Route::post('/kabag/pengajuan-cuti-umum/{id}/cancel', [KabagPengajuanCutiUmum::class, 'cancel'])->name('kabagpengajuancutiumum.cancel');
    Route::post('/widyaiswara/pengajuan-cuti-tahunan/{id}/cancel', [WidyaiswaraPengajuanCutiTahunan::class, 'cancel'])->name('widyaiswarapengajuancutitahunan.cancel');
    Route::post('/widyaiswara/pengajuan-cuti-umum/{id}/cancel', [WidyaiswaraPengajuanCutiUmum::class, 'cancel'])->name('widyaiswarapengajuancutiumum.cancel');

    // API Kalender
    Route::get('/api/libur-internal', [AdminKalenderCuti::class, 'getLiburAPI'])->name('api.libur.internal');
});

/*
|--------------------------------------------------------------------------
| Admin Area Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->group(function () {
    // Manajemen Pengguna
    Route::resource('users', UserController::class);

    // Berkas Arsip Surat Cuti
    Route::get('/admin/arsip-surat-cuti', [AdminPenomoranSuratCuti::class, 'index'])->name('arsipsuratcuti.index');

    // Masa Kerja
    Route::get('/admin/masakerja', [AdminMasaKerja::class, 'index'])->name('adminmasakerja.index');
    Route::post('/admin/masakerja/store', [AdminMasaKerja::class, 'store'])->name('adminmasakerja.store');
    Route::put('/admin/masakerja/{id}', [AdminMasaKerja::class, 'update'])->name('adminmasakerja.update');
    Route::delete('/admin/masakerja/{id}', [AdminMasaKerja::class, 'destroy'])->name('adminmasakerja.destroy');
});

require __DIR__.'/auth.php';