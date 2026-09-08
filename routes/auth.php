<?php

use App\Http\Controllers\Admin\AdminAlurVerfikasiCuti;
use App\Http\Controllers\Admin\AdminAnggotaTim;
use App\Http\Controllers\Admin\AdminDataJenisCuti;
use App\Http\Controllers\Admin\AdminDataKuotaCutiTahunan;
use App\Http\Controllers\Admin\AdminDataPengguna;
use App\Http\Controllers\Admin\AdminMasaKerja;
use App\Http\Controllers\Admin\AdminPengajuanCutiTahunan;
use App\Http\Controllers\Admin\AdminPengajuanCutiUmum;
use App\Http\Controllers\Admin\AdminPenomoranSuratCuti;
use App\Http\Controllers\Admin\AdminPerubahanCuti;
use App\Http\Controllers\Admin\AdminTandaTangan;
use App\Http\Controllers\Admin\AdminTimKerja;
use App\Http\Controllers\Admin\CtStatusUserAdmin;
use App\Http\Controllers\Admin\RiwayatCutiAdmin;
use App\Http\Controllers\Admin\VerifikasiCutiUmumAdmin;
use App\Http\Controllers\Admin\AdminKalenderCuti;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\KepalaBagian\CtStatusKatimkerKabag;
use App\Http\Controllers\KepalaBagian\KabagDataPermohonanCuti;
use App\Http\Controllers\KepalaBagian\KabagDataPermohonanCutiUmum;
use App\Http\Controllers\KepalaBagian\KabagMasaKerja;
use App\Http\Controllers\KepalaBagian\KabagPengajuanCutiTahunan;
use App\Http\Controllers\KepalaBagian\KabagPengajuanCutiUmum;
use App\Http\Controllers\KepalaBagian\KabagVerifikasiCutiUmum;
use App\Http\Controllers\kepalabalai\CtStatusKabagKabal;
use App\Http\Controllers\KepalaBalai\KabalaiDataPermohonanCutiUmum;
use App\Http\Controllers\KepalaBalai\KabalaiMasaKerja;
use App\Http\Controllers\KepalaBalai\KabalaiVerifikasiCutiUmum;
use App\Http\Controllers\KepalaBalai\KepalaBalaiDataPermohonanCuti;
use App\Http\Controllers\KepalaTimKerja\CtStatusAdminKatimker;
use App\Http\Controllers\KepalaTimKerja\KatimkerDataPermohonanCuti;
use App\Http\Controllers\KepalaTimKerja\KatimkerDataPermohonanCutiUmum;
use App\Http\Controllers\KepalaTimKerja\KatimkerMasaKerja;
use App\Http\Controllers\KepalaTimKerja\KatimkerPengajuanCutiTahunan;
use App\Http\Controllers\KepalaTimKerja\KatimkerPengajuanCutiUmum;
use App\Http\Controllers\KepalaTimKerja\KatimkerVerifikasiCutiUmum;
// use App\Http\Controllers\ProductsController;
use App\Http\Controllers\User\UserDashboard;
use App\Http\Controllers\User\UserMasaKerja;
use App\Http\Controllers\User\UserPengajuanCutiTahunan;
use App\Http\Controllers\User\UserPengajuanCutiUmum;
use App\Http\Controllers\User\UserProfile;
use App\Http\Controllers\Widyaiswara\WidyaiswaraMasaKerja;
use App\Http\Controllers\Widyaiswara\WidyaiswaraPengajuanCutiTahunan;
use App\Http\Controllers\Widyaiswara\WidyaiswaraPengajuanCutiUmum;
use App\Http\Middleware\Widyaiswara;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    Route::resource('admindatapengguna', AdminDataPengguna::class)
    ->middleware('admin')
    ->names([
        'index' => 'admindatapengguna.index',
        'create' => 'admindatapengguna.create',
        'store' => 'admindatapengguna.store',
        'show' => 'admindatapengguna.show',         
        'edit' => 'admindatapengguna.edit',
        'update' => 'admindatapengguna.update',
        'destroy' => 'admindatapengguna.destroy',
    ]);

    Route::resource('admintimkerja', AdminTimKerja::class)
    ->middleware('admin')
    ->names([
        'index' => 'admintimkerja.index',
        'create' => 'admintimkerja.create',
        'store' => 'admintimkerja.store',
        'show' => 'admintimkerja.show',         
        'edit' => 'admintimkerja.edit',
        'update' => 'admintimkerja.update',
        'destroy' => 'admintimkerja.destroy',
    ]);

    Route::resource('adminanggotatim', AdminAnggotaTim::class)
    ->middleware('admin')
    ->names([
        'index' => 'adminanggotatim.index',
        'create' => 'adminanggotatim.create',
        'store' => 'adminanggotatim.store',
        'show' => 'adminanggotatim.show',         
        'edit' => 'adminanggotatim.edit',
        'update' => 'adminanggotatim.update',
        'destroy' => 'adminanggotatim.destroy',
    ]);

    Route::resource('admindatajeniscuti', AdminDataJenisCuti::class)
    ->middleware('admin')
    ->names([
        'index' => 'admindatajeniscuti.index',
        'create' => 'admindatajeniscuti.create',
        'store' => 'admindatajeniscuti.store',
        'show' => 'admindatajeniscuti.show',         
        'edit' => 'admindatajeniscuti.edit',
        'update' => 'admindatajeniscuti.update',
        'destroy' => 'admindatajeniscuti.destroy',
    ]);
    Route::post('/admin/kuota-cuti-tahunan/bulk-reset', [AdminDataKuotaCutiTahunan::class, 'bulkReset'])->middleware('admin')->name('admindatakuotacutitahunan.bulkReset');
    Route::resource('admindatakuotacutitahunan', AdminDataKuotaCutiTahunan::class)
    ->middleware('admin')
    ->names([
        'index' => 'admindatakuotacutitahunan.index',
        'create' => 'admindatakuotacutitahunan.create',
        'store' => 'admindatakuotacutitahunan.store',
        'show' => 'admindatakuotacutitahunan.show',         
        'edit' => 'admindatakuotacutitahunan.edit',
        'update' => 'admindatakuotacutitahunan.update',
        'destroy' => 'admindatakuotacutitahunan.destroy',
    ]);

    Route::resource('adminkalendercuti', AdminKalenderCuti::class)
    ->middleware('admin')
    ->names([
        'index' => 'adminkalendercuti.index',
        'create' => 'adminkalendercuti.create',
        'store' => 'adminkalendercuti.store',
        'show' => 'adminkalendercuti.show',         
        'edit' => 'adminkalendercuti.edit',
        'update' => 'adminkalendercuti.update',
        'destroy' => 'adminkalendercuti.destroy',
    ]);
    Route::resource('adminpengajuancutitahunan', AdminPengajuanCutiTahunan::class)
    ->middleware('admin')
    ->names([
        'index' => 'adminpengajuancutitahunan.index',
        'create' => 'adminpengajuancutitahunan.create',
        'store' => 'adminpengajuancutitahunan.store',
        'show' => 'adminpengajuancutitahunan.show',         
        'edit' => 'adminpengajuancutitahunan.edit',
        'update' => 'adminpengajuancutitahunan.update',
        'destroy' => 'adminpengajuancutitahunan.destroy',
    ]);

    Route::resource('userpengajuancutitahunan', UserPengajuanCutiTahunan::class)
    ->middleware('user')
    ->names([
        'index' => 'userpengajuancutitahunan.index',
        'create' => 'userpengajuancutitahunan.create',
        'store' => 'userpengajuancutitahunan.store',
        'show' => 'userpengajuancutitahunan.show',         
        'edit' => 'userpengajuancutitahunan.edit',
        'update' => 'userpengajuancutitahunan.update',
        'destroy' => 'userpengajuancutitahunan.destroy',
    ]);

    Route::resource('usermasakerja', UserMasaKerja::class)
    ->middleware('user')
    ->names([
        'index' => 'usermasakerja.index',
        'create' => 'usermasakerja.create',
        'store' => 'usermasakerja.store',
        'show' => 'usermasakerja.show',         
        'edit' => 'usermasakerja.edit',
        'update' => 'usermasakerja.update',
        'destroy' => 'usermasakerja.destroy',
    ]);

    Route::resource('ctstatususeradmin', CtStatusUserAdmin::class)
    ->middleware('admin')
    ->names([
        'index' => 'ctstatususeradmin.index',
        'create' => 'ctstatususeradmin.create',
        'store' => 'ctstatususeradmin.store',
        'show' => 'ctstatususeradmin.show',
        'edit' => 'ctstatususeradmin.edit',
        'update' => 'ctstatususeradmin.update',
        'destroy' => 'ctstatususeradmin.destroy',
    ]);

    Route::resource('ctstatusadminkatimker', CtStatusAdminKatimker::class)
    ->middleware('kepalatimkerja')
    ->names([
        'index' => 'ctstatusadminkatimker.index',
        'create' => 'ctstatusadminkatimker.create',
        'store' => 'ctstatusadminkatimker.store',
        'show' => 'ctstatusadminkatimker.show',
        'edit' => 'ctstatusadminkatimker.edit',
        'update' => 'ctstatusadminkatimker.update',
        'destroy' => 'ctstatusadminkatimker.destroy',
    ]);

    Route::resource('ctstatuskatimkerkabag', CtStatusKatimkerKabag::class)
    ->middleware('kepalabagian')
    ->names([
        'index' => 'ctstatuskatimkerkabag.index',
        'create' => 'ctstatuskatimkerkabag.create',
        'store' => 'ctstatuskatimkerkabag.store',
        'show' => 'ctstatuskatimkerkabag.show',
        'edit' => 'ctstatuskatimkerkabag.edit',
        'update' => 'ctstatuskatimkerkabag.update',
        'destroy' => 'ctstatuskatimkerkabag.destroy',
    ]);

    Route::resource('ctstatuskabagkabal', CtStatusKabagKabal::class)
    ->middleware('kepalabalai')
    ->names([
        'index' => 'ctstatuskabagkabal.index',
        'create' => 'ctstatuskabagkabal.create',
        'store' => 'ctstatuskabagkabal.store',
        'show' => 'ctstatuskabagkabal.show',
        'edit' => 'ctstatuskabagkabal.edit',
        'update' => 'ctstatuskabagkabal.update',
        'destroy' => 'ctstatuskabagkabal.destroy',
    ]);

    Route::resource('katimkerdatapermohonancuti', KatimkerDataPermohonanCuti::class)
    ->middleware('kepalatimkerja')
    ->names([
        'index' => 'katimkerdatapermohonancuti.index',
        'create' => 'katimkerdatapermohonancuti.create',
        'store' => 'katimkerdatapermohonancuti.store',
        'show' => 'katimkerdatapermohonancuti.show',
        'edit' => 'katimkerdatapermohonancuti.edit',
        'update' => 'katimkerdatapermohonancuti.update',
        'destroy' => 'katimkerdatapermohonancuti.destroy',
    ]);

    Route::resource('kabagdatapermohonancuti', KabagDataPermohonanCuti::class)
    ->middleware('kepalabagian')
    ->names([
        'index' => 'kabagdatapermohonancuti.index',
        'create' => 'kabagdatapermohonancuti.create',
        'store' => 'kabagdatapermohonancuti.store',
        'show' => 'kabagdatapermohonancuti.show',
        'edit' => 'kabagdatapermohonancuti.edit',
        'update' => 'kabagdatapermohonancuti.update',
        'destroy' => 'kabagdatapermohonancuti.destroy',
    ]);

    Route::resource('kepalabalaidatapermohonancuti', KepalaBalaiDataPermohonanCuti::class)
    ->middleware('kepalabalai')
    ->names([
        'index' => 'kepalabalaidatapermohonancuti.index',
        'create' => 'kepalabalaidatapermohonancuti.create',
        'store' => 'kepalabalaidatapermohonancuti.store',
        'show' => 'kepalabalaidatapermohonancuti.show',
        'edit' => 'kepalabalaidatapermohonancuti.edit',
        'update' => 'kepalabalaidatapermohonancuti.update',
        'destroy' => 'kepalabalaidatapermohonancuti.destroy',
    ]);

    Route::resource('adminpenomoransuratcuti', AdminPenomoranSuratCuti::class)
    ->middleware('admin')
    ->names([
        'index' => 'adminpenomoransuratcuti.index',
        'create' => 'adminpenomoransuratcuti.create',
        'store' => 'adminpenomoransuratcuti.store',
        'show' => 'adminpenomoransuratcuti.show',
        'edit' => 'adminpenomoransuratcuti.edit',
        'update' => 'adminpenomoransuratcuti.update',
        'destroy' => 'adminpenomoransuratcuti.destroy',
    ]);

    Route::resource('adminpengajuancutiumum', AdminPengajuanCutiUmum::class)
    ->middleware('admin')
    ->names([
        'index' => 'adminpengajuancutiumum.index',
        'create' => 'adminpengajuancutiumum.create',
        'store' => 'adminpengajuancutiumum.store',
        'show' => 'adminpengajuancutiumum.show',
        'edit' => 'adminpengajuancutiumum.edit',
        'update' => 'adminpengajuancutiumum.update',
        'destroy' => 'adminpengajuancutiumum.destroy',
    ]);

    Route::resource('userpengajuancutiumum', UserPengajuanCutiUmum::class)
    ->middleware('user')
    ->names([
        'index' => 'userpengajuancutiumum.index',
        'create' => 'userpengajuancutiumum.create',
        'store' => 'userpengajuancutiumum.store',
        'show' => 'userpengajuancutiumum.show',
        'edit' => 'userpengajuancutiumum.edit',
        'update' => 'userpengajuancutiumum.update',
        'destroy' => 'userpengajuancutiumum.destroy',
    ]);

    Route::resource('adminperubahancuti', AdminPerubahanCuti::class)
    ->middleware('admin')
    ->names([
        'index' => 'adminperubahancuti.index',
        'create' => 'adminperubahancuti.create',
        'store' => 'adminperubahancuti.store',
        'show' => 'adminperubahancuti.show',
        'edit' => 'adminperubahancuti.edit',
        'update' => 'adminperubahancuti.update',
        'destroy' => 'adminperubahancuti.destroy',
    ]);

    Route::resource('userprofile', UserProfile::class)
    ->middleware('user')
    ->names([
        'index' => 'userprofile.index',
        'create' => 'userprofile.create',
        'store' => 'userprofile.store',
        'show' => 'userprofile.show',
        'edit' => 'userprofile.edit',
        'update' => 'userprofile.update',
        'destroy' => 'userprofile.destroy',
    ]);

    Route::resource('userdashboard', UserDashboard::class)
    ->middleware('user')
    ->names([
        'index' => 'userdashboard.index',
        'create' => 'userdashboard.create',
        'store' => 'userdashboard.store',
        'show' => 'userdashboard.show',
        'edit' => 'userdashboard.edit',
        'update' => 'userdashboard.update',
        'destroy' => 'userdashboard.destroy',
    ]);

    Route::resource('adminkelolatandatangan', AdminTandaTangan::class)
    ->middleware('admin')
    ->names([
        'index' => 'adminkelolatandatangan.index',
        'create' => 'adminkelolatandatangan.create',
        'store' => 'adminkelolatandatangan.store',
        'show' => 'adminkelolatandatangan.show',
        'edit' => 'adminkelolatandatangan.edit',
        'update' => 'adminkelolatandatangan.update',
        'destroy' => 'adminkelolatandatangan.destroy',
    ]);

    Route::resource('adminverifikasicutiumum', VerifikasiCutiUmumAdmin::class)
    ->middleware('admin')
    ->names([
        'index' => 'adminverifikasicutiumum.index',
        'create' => 'adminverifikasicutiumum.create',
        'store' => 'adminverifikasicutiumum.store',
        'show' => 'adminverifikasicutiumum.show',
        'edit' => 'adminverifikasicutiumum.edit',
        'update' => 'adminverifikasicutiumum.update',
        'destroy' => 'adminverifikasicutiumum.destroy',
    ]);

    Route::resource('katimkerdatapermohonancutiumum', KatimkerDataPermohonanCutiUmum::class)
    ->middleware('kepalatimkerja')
    ->names([
        'index' => 'katimkerdatapermohonancutiumum.index',
        'create' => 'katimkerdatapermohonancutiumum.create',
        'store' => 'katimkerdatapermohonancutiumum.store',
        'show' => 'katimkerdatapermohonancutiumum.show',
        'edit' => 'katimkerdatapermohonancutiumum.edit',
        'update' => 'katimkerdatapermohonancutiumum.update',
        'destroy' => 'katimkerdatapermohonancutiumum.destroy',
    ]);

    Route::resource('katimkerverifikasicutiumum', KatimkerVerifikasiCutiUmum::class)
    ->middleware('kepalatimkerja')
    ->names([
        'index' => 'katimkerverifikasicutiumum.index',
        'create' => 'katimkerverifikasicutiumum.create',
        'store' => 'katimkerverifikasicutiumum.store',
        'show' => 'katimkerverifikasicutiumum.show',
        'edit' => 'katimkerverifikasicutiumum.edit',
        'update' => 'katimkerverifikasicutiumum.update',
        'destroy' => 'katimkerverifikasicutiumum.destroy',
    ]);

    Route::resource('kabagdatapermohonancutiumum', KabagDataPermohonanCutiUmum::class)
    ->middleware('kepalabagian')
    ->names([
        'index' => 'kabagdatapermohonancutiumum.index',
        'create' => 'kabagdatapermohonancutiumum.create',
        'store' => 'kabagdatapermohonancutiumum.store',
        'show' => 'kabagdatapermohonancutiumum.show',
        'edit' => 'kabagdatapermohonancutiumum.edit',
        'update' => 'kabagdatapermohonancutiumum.update',
        'destroy' => 'kabagdatapermohonancutiumum.destroy',
    ]);

    Route::resource('kabagverivikasicutiumum', KabagVerifikasiCutiUmum::class)
    ->middleware('kepalabagian')
    ->names([
        'index' => 'kabagverivikasicutiumum.index',
        'create' => 'kabagverivikasicutiumum.create',
        'store' => 'kabagverivikasicutiumum.store',
        'show' => 'kabagverivikasicutiumum.show',
        'edit' => 'kabagverivikasicutiumum.edit',
        'update' => 'kabagverivikasicutiumum.update',
        'destroy' => 'kabagverivikasicutiumum.destroy',
    ]);

    Route::resource('kabalaidatapermohonancutiumum', KabalaiDataPermohonanCutiUmum::class)
    ->middleware('kepalabalai')
    ->names([
        'index' => 'kabalaidatapermohonancutiumum.index',
        'create' => 'kabalaidatapermohonancutiumum.create',
        'store' => 'kabalaidatapermohonancutiumum.store',
        'show' => 'kabalaidatapermohonancutiumum.show',
        'edit' => 'kabalaidatapermohonancutiumum.edit',
        'update' => 'kabalaidatapermohonancutiumum.update',
        'destroy' => 'kabalaidatapermohonancutiumum.destroy',
    ]);

    Route::resource('kabalaiverifikasicutiumum', KabalaiVerifikasiCutiUmum::class)
    ->middleware('kepalabalai')
    ->names([
        'index' => 'kabalaiverifikasicutiumum.index',
        'create' => 'kabalaiverifikasicutiumum.create',
        'store' => 'kabalaiverifikasicutiumum.store',
        'show' => 'kabalaiverifikasicutiumum.show',
        'edit' => 'kabalaiverifikasicutiumum.edit',
        'update' => 'kabalaiverifikasicutiumum.update',
        'destroy' => 'kabalaiverifikasicutiumum.destroy',
    ]);

    Route::resource('katimkerpengajuancutitahunan', KatimkerPengajuanCutiTahunan::class)
    ->middleware('kepalatimkerja')
    ->names([
        'index' => 'katimkerpengajuancutitahunan.index',
        'create' => 'katimkerpengajuancutitahunan.create',
        'store' => 'katimkerpengajuancutitahunan.store',
        'show' => 'katimkerpengajuancutitahunan.show',         
        'edit' => 'katimkerpengajuancutitahunan.edit',
        'update' => 'katimkerpengajuancutitahunan.update',
        'destroy' => 'katimkerpengajuancutitahunan.destroy',
    ]);

    Route::resource('katimkermasakerja', KatimkerMasaKerja::class)
    ->middleware('kepalatimkerja')
    ->names([
        'index' => 'katimkermasakerja.index',
        'create' => 'katimkermasakerja.create',
        'store' => 'katimkermasakerja.store',
        'show' => 'katimkermasakerja.show',         
        'edit' => 'katimkermasakerja.edit',
        'update' => 'katimkermasakerja.update',
        'destroy' => 'katimkermasakerja.destroy',
    ]);

    Route::resource('adminmasakerja', AdminMasaKerja::class)
    ->middleware('admin')
    ->names([
        'index' => 'adminmasakerja.index',
        'create' => 'adminmasakerja.create',
        'store' => 'adminmasakerja.store',
        'show' => 'adminmasakerja.show',
        'edit' => 'adminmasakerja.edit',
        'update' => 'adminmasakerja.update',
        'destroy' => 'adminmasakerja.destroy',
    ]);

    Route::resource('katimkerpengajuancutiumum', KatimkerPengajuanCutiUmum::class)
    ->middleware('kepalatimkerja')
    ->names([
        'index' => 'katimkerpengajuancutiumum.index',
        'create' => 'katimkerpengajuancutiumum.create',
        'store' => 'katimkerpengajuancutiumum.store',
        'show' => 'katimkerpengajuancutiumum.show',         
        'edit' => 'katimkerpengajuancutiumum.edit',
        'update' => 'katimkerpengajuancutiumum.update',
        'destroy' => 'katimkerpengajuancutiumum.destroy',
    ]);

    Route::resource('kabagmasakerja', KabagMasaKerja::class)
    ->middleware('kepalabagian')
    ->names([
        'index' => 'kabagmasakerja.index',
        'create' => 'kabagmasakerja.create',
        'store' => 'kabagmasakerja.store',
        'show' => 'kabagmasakerja.show',
        'edit' => 'kabagmasakerja.edit',
        'update' => 'kabagmasakerja.update',
        'destroy' => 'kabagmasakerja.destroy',
    ]);

    Route::resource('kabagpengajuancutitahunan', KabagPengajuanCutiTahunan::class)
    ->middleware('kepalabagian')
    ->names([
        'index' => 'kabagpengajuancutitahunan.index',
        'create' => 'kabagpengajuancutitahunan.create',
        'store' => 'kabagpengajuancutitahunan.store',
        'show' => 'kabagpengajuancutitahunan.show',
        'edit' => 'kabagpengajuancutitahunan.edit',
        'update' => 'kabagpengajuancutitahunan.update',
        'destroy' => 'kabagpengajuancutitahunan.destroy',
    ]);

    Route::resource('kabagpengajuancutiumum', KabagPengajuanCutiUmum::class)
    ->middleware('kepalabagian') 
    ->names([
        'index' => 'kabagpengajuancutiumum.index',
        'create' => 'kabagpengajuancutiumum.create',
        'store' => 'kabagpengajuancutiumum.store',
        'show' => 'kabagpengajuancutiumum.show',
        'edit' => 'kabagpengajuancutiumum.edit',
        'update' => 'kabagpengajuancutiumum.update',
        'destroy' => 'kabagpengajuancutiumum.destroy',
    ]);

    Route::resource('alurverifikasicuti', AdminAlurVerfikasiCuti::class)
    ->middleware('admin')
    ->names([
        'index' => 'alurverifikasicuti.index',
        'create' => 'alurverifikasicuti.create',
        'store' => 'alurverifikasicuti.store',
        'show' => 'alurverifikasicuti.show',
        'edit' => 'alurverifikasicuti.edit',
        'update' => 'alurverifikasicuti.update',
        'destroy' => 'alurverifikasicuti.destroy',
    ]);

    Route::resource('adminriwayatcuti', RiwayatCutiAdmin::class)
    ->middleware('admin')
    ->names([
        'index' => 'adminriwayatcuti.index',
        'create' => 'adminriwayatcuti.create',
        'store' => 'adminriwayatcuti.store',
        'show' => 'adminriwayatcuti.show',
        'edit' => 'adminriwayatcuti.edit',
        'update' => 'adminriwayatcuti.update',
        'destroy' => 'adminriwayatcuti.destroy',
    ]);

    
    Route::resource('widyaiswaramasakerja', WidyaiswaraMasaKerja::class)
    ->middleware('widyaiswara')
    ->names([
        'index' => 'widyaiswaramasakerja.index',
        'create' => 'widyaiswaramasakerja.create',
        'store' => 'widyaiswaramasakerja.store',
        'show' => 'widyaiswaramasakerja.show',
        'edit' => 'widyaiswaramasakerja.edit',
        'update' => 'widyaiswaramasakerja.update',
        'destroy' => 'widyaiswaramasakerja.destroy',
    ]);

    Route::resource('widyaiswarapengajuancutiumum', WidyaiswaraPengajuanCutiUmum::class)
    ->middleware('widyaiswara')
    ->names([
        'index' => 'widyaiswarapengajuancutiumum.index',
        'create' => 'widyaiswarapengajuancutiumum.create',
        'store' => 'widyaiswarapengajuancutiumum.store',
        'show' => 'widyaiswarapengajuancutiumum.show',
        'edit' => 'widyaiswarapengajuancutiumum.edit',
        'update' => 'widyaiswarapengajuancutiumum.update',
        'destroy' => 'widyaiswarapengajuancutiumum.destroy',
    ]);

        
    Route::resource('widyaiswarapengajuancutitahunan', WidyaiswaraPengajuanCutiTahunan::class)
    ->middleware('widyaiswara')
    ->names([
        'index' => 'widyaiswarapengajuancutitahunan.index',
        'create' => 'widyaiswarapengajuancutitahunan.create',
        'store' => 'widyaiswarapengajuancutitahunan.store',
        'show' => 'widyaiswarapengajuancutitahunan.show',
        'edit' => 'widyaiswarapengajuancutitahunan.edit',
        'update' => 'widyaiswarapengajuancutitahunan.update',
        'destroy' => 'widyaiswarapengajuancutitahunan.destroy',
    ]);

    Route::resource('kepalabalaimasakerja', KabalaiMasaKerja::class)
    ->middleware('kepalabalai')
    ->names([
        'index' => 'kepalabalaimasakerja.index',
        'create' => 'kepalabalaimasakerja.create',
        'store' => 'kepalabalaimasakerja.store',
        'show' => 'kepalabalaimasakerja.show',         
        'edit' => 'kepalabalaimasakerja.edit',
        'update' => 'kepalabalaimasakerja.update',
        'destroy' => 'kepalabalaimasakerja.destroy',
    ]);

    Route::resource('adminkalendercuti', AdminKalenderCuti::class)
    ->middleware('admin') // Pastikan nama middleware sesuai dengan yang Anda daftarkan (misal: 'admin')
    ->names([
        'index'   => 'adminkalendercuti.index',
        'create'  => 'adminkalendercuti.create',
        'store'   => 'adminkalendercuti.store',
        'show'    => 'adminkalendercuti.show',
        'edit'    => 'adminkalendercuti.edit',
        'update'  => 'adminkalendercuti.update',
        'destroy' => 'adminkalendercuti.destroy',
    ]);
    
});
