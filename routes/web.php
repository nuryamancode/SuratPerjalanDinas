<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DisposisiController;
use App\Http\Controllers\DisposisiDetailController;
use App\Http\Controllers\GolonganController;
use App\Http\Controllers\InputBiayaController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\LampiranController;
use App\Http\Controllers\Pengadministrasiumum\PermohonanSpdController;
// use App\Http\Controllers\Pengadministrasiumum\SuratTugasController;
use App\Http\Controllers\PengajuanBarangJasaController;
use App\Http\Controllers\PengajuanFormNonPbjController;
use App\Http\Controllers\PengajuanFormNonPbjDetailController;
use App\Http\Controllers\PengajuanFormNonPbjDisposisiController;
use App\Http\Controllers\PengajuanFormNonPbjUangMukaController;
use App\Http\Controllers\PengajuanPbjController;
use App\Http\Controllers\PengajuanPbjDetailController;
use App\Http\Controllers\PengajuanPbjDisposisiController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PermohonanSuratPerjalananDinasController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProsesPbjController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SpjFormNonPbjController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\SuratPerjalananDinasController;
use App\Http\Controllers\SuratPerjalananDinasDetailController;
use App\Http\Controllers\SuratPerjalananDinasDetailSupirController;
use App\Http\Controllers\SuratPertanggungJawabanController;
use App\Http\Controllers\SuratPertanggungJawabanDetailController;
use App\Http\Controllers\TTEController;
use App\Http\Controllers\UangMukaController;
use App\Http\Controllers\UserController;
use App\Models\PengajuanPbj;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Auth::routes();
Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // admin
    Route::middleware('auth')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('users', UserController::class);
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

        // roles
        Route::resource('roles', RoleController::class)->except('show');
        // permissions
        Route::resource('permissions', PermissionController::class)->except('show');
        Route::resource('jabatan', JabatanController::class)->except('show');
        Route::resource('golongan', GolonganController::class)->except('show');
        Route::get('surat/detail', [SuratController::class, 'detail'])->name('surat.detail');
        Route::resource('surat', SuratController::class);
        Route::delete('lampiran/{uuid}', [LampiranController::class, 'destroy'])->name('lampiran.destroy');

        // karyawan
        Route::resource('karyawan', KaryawanController::class)->except('show');
        // surat-perjalanan-dinas
        Route::get('surat-perjalanan-dinas/disposisi-single/{id}', [SuratPerjalananDinasController::class, 'disposisi_single'])->name('surat-perjalanan-dinas.disposisi-single');
        Route::post('surat-perjalanan-dinas/disposisi-single/{id}', [SuratPerjalananDinasController::class, 'disposisi_single_submit'])->name('surat-perjalanan-dinas.disposisi-single-submit');

        Route::get('disposisi/acc', [DisposisiController::class, 'acc'])->name('disposisi.acc');
        Route::get('disposisi/{surat_perjalanan_dinas_id}', [DisposisiController::class, 'index'])->name('disposisi.index');
        Route::post('disposisi/{surat_perjalanan_dinas_id}', [DisposisiController::class, 'store'])->name('disposisi.store');

        Route::resource('permohonan-surat-perjalanan-dinas', PermohonanSuratPerjalananDinasController::class);
        Route::resource('disposisi-detail', DisposisiDetailController::class);
        Route::get('surat-perjalanan-dinas/generate-automatic', [SuratPerjalananDinasController::class, 'generate'])->name('surat-perjalanan-dinas.generate');
        Route::post('surat-perjalanan-dinas/{id}/validasi-pemberangkatan', [SuratPerjalananDinasController::class, 'validasi_pemberangkatan'])->name('surat-perjalanan-dinas.validasi-pemberangkatan');
        Route::get('surat-perjalanan-dinas/getbyId', [SuratPerjalananDinasController::class, 'getById'])->name('surat-perjalanan-dinas.getById');
        Route::resource('surat-perjalanan-dinas', SuratPerjalananDinasController::class);
        Route::get('surat-perjalanan-dinas-detail/getById', [SuratPerjalananDinasDetailController::class, 'getById'])->name('surat-perjalanan-dinas-detail.getById');
        Route::resource('surat-perjalanan-dinas-detail', SuratPerjalananDinasDetailController::class);
        Route::get('tte', [TTEController::class, 'index'])->name('tte.index');
        Route::post('tte', [TTEController::class, 'update'])->name('tte.update');
        Route::delete('tte', [TTEController::class, 'destroy'])->name('tte.destroy');
        Route::resource('surat-perjalanan-dinas-supir', SuratPerjalananDinasDetailSupirController::class);

        Route::resource('input-biaya', InputBiayaController::class);
        Route::resource('uang-muka', UangMukaController::class);
        Route::get('surat-pertanggung-jawaban/verifikasi', [SuratPertanggungJawabanController::class, 'verifikasi'])->name('surat-pertanggung-jawaban.verifikasi');
        Route::resource('surat-pertanggung-jawaban', SuratPertanggungJawabanController::class);
        Route::resource('surat-pertanggung-jawaban-detail', SuratPertanggungJawabanDetailController::class);

        Route::get('pengajuan-pbj/{uuid}/disposisi', [PengajuanPbjDisposisiController::class, 'index'])->name('pengajuan-pbj.disposisi.index');
        Route::get('pengajuan-pbj/{uuid}/disposisi/create', [PengajuanPbjDisposisiController::class, 'create'])->name('pengajuan-pbj.disposisi.create');
        Route::post('pengajuan-pbj/disposisi', [PengajuanPbjDisposisiController::class, 'store'])->name('pengajuan-pbj.disposisi.store');
        Route::delete('pengajuan-pbj/{uuid}/disposisi', [PengajuanPbjDisposisiController::class, 'destroy'])->name('pengajuan-pbj.disposisi.destroy');

        Route::get('pengajuan-pbj/verifikasi', [PengajuanPbjController::class, 'verifikasi'])->name('pengajuan-pbj.verifikasi');
        Route::get('pengajuan-pbj/acc-wadir2', [PengajuanPbjController::class, 'acc_wadir2'])->name('pengajuan-pbj.acc-wadir2');
        Route::get('pengajuan-pbj/acc-ppk', [PengajuanPbjController::class, 'acc_ppk'])->name('pengajuan-pbj.acc-ppk');
        Route::resource('pengajuan-pbj', PengajuanPbjController::class);
        Route::resource('pengajuan-pbj-detail', PengajuanPbjDetailController::class);

        // proses pbj
        Route::resource('proses-pbj', ProsesPbjController::class)->except('show');
        Route::get('proses-pbj/{pbj_uuid}', [ProsesPbjController::class, 'show'])->name('proses-pbj.show');


        Route::get('pengajuan-form-non-pbj/{uuid}/disposisi', [PengajuanFormNonPbjDisposisiController::class, 'index'])->name('pengajuan-form-non-pbj.disposisi.index');
        Route::get('pengajuan-form-non-pbj/{uuid}/disposisi/create', [PengajuanFormNonPbjDisposisiController::class, 'create'])->name('pengajuan-form-non-pbj.disposisi.create');
        Route::post('pengajuan-form-non-pbj/{uuid}/disposisi', [PengajuanFormNonPbjDisposisiController::class, 'store'])->name('pengajuan-form-non-pbj.disposisi.store');
        Route::delete('pengajuan-form-non-pbj/{uuid}/disposisi', [PengajuanFormNonPbjDisposisiController::class, 'destroy'])->name('pengajuan-form-non-pbj.disposisi.destroy');

        Route::get('pengajuan-form-non-pbj/acc-pengusul', [PengajuanFormNonPbjController::class, 'acc_pengusul'])->name('pengajuan-form-non-pbj.acc-pengusul');
        Route::get('pengajuan-form-non-pbj/acc-ppk', [PengajuanFormNonPbjController::class, 'acc_ppk'])->name('pengajuan-form-non-pbj.acc-ppk');
        Route::get('pengajuan-form-non-pbj/getById', [PengajuanFormNonPbjController::class, 'getById'])->name('pengajuan-form-non-pbj.getById');
        Route::resource('pengajuan-form-non-pbj', PengajuanFormNonPbjController::class);
        Route::resource('pengajuan-form-non-pbj-detail', PengajuanFormNonPbjDetailController::class);


        // uang muka form non pbj
        Route::controller(PengajuanFormNonPbjUangMukaController::class)->group(function () {
            Route::get('/uang-muka-form-non-pbj', 'index')->name('pengajuan-form-non-pbj.uang-muka.index');
            Route::get('/uang-muka-form-non-pbj/create', 'create')->name('pengajuan-form-non-pbj.uang-muka.create');
            Route::post('/uang-muka-form-non-pbj/create', 'store')->name('pengajuan-form-non-pbj.uang-muka.store');
            Route::get('/uang-muka-form-non-pbj/{uuid}/edit', 'edit')->name('pengajuan-form-non-pbj.uang-muka.edit');
            Route::patch('/uang-muka-form-non-pbj/{uuid}/edit', 'update')->name('pengajuan-form-non-pbj.uang-muka.update');
            Route::delete('/uang-muka-form-non-pbj/{uuid}', 'destroy')->name('pengajuan-form-non-pbj.uang-muka.destroy');
        });

        // spj
        Route::get('spj-form-non-pbj/verifikasi', [SpjFormNonPbjController::class, 'verifikasi'])->name('spj-form-non-pbj.verifikasi');
        Route::resource('spj-form-non-pbj', SpjFormNonPbjController::class);
        Route::resource('spj-form-non-pbj-detail', SuratPertanggungJawabanDetailController::class);
    });

    Route::name('ppk.')->prefix('ppk')->group(function () {
        Route::get('/', [\App\Http\Controllers\Ppk\DashboardController::class, 'index'])->name('dashboard');
        Route::post('permohonan-spd/acc-ppk/{id}', [App\Http\Controllers\Ppk\PermohonanSpdController::class, 'acc_ppk'])->name('permohonan-spd.acc-ppk');
        Route::post('permohonan-spd/verifikasi-ppk/{id}', [App\Http\Controllers\Ppk\PermohonanSpdController::class, 'verifikasi_ppk'])->name('permohonan-spd.verifikasi-ppk');
        Route::resource('permohonan-spd', App\Http\Controllers\Ppk\PermohonanSpdController::class);
        // disposisi spd
        Route::resource('permohonan-spd-disposisi', App\Http\Controllers\Ppk\PermohonanSpdDisposisiController::class);
        Route::post('spd-spj/verifikasi/{uuid}', [App\Http\Controllers\Ppk\SpdSpjController::class, 'verifikasi'])->name('spd-spj.verifikasi');
        Route::resource('spd-spj', App\Http\Controllers\Ppk\SpdSpjController::class);
        Route::get('tte', [App\Http\Controllers\Ppk\TTEController::class, 'index'])->name('tte.index');
        Route::post('tte', [App\Http\Controllers\Ppk\TTEController::class, 'update'])->name('tte.update');
        Route::delete('tte', [App\Http\Controllers\Ppk\TTEController::class, 'destroy'])->name('tte.destroy');
        Route::post('pengajuan-form-non-pbj/acc/{uuid}', [App\Http\Controllers\Ppk\PengajuanFormNonPbjController::class, 'acc'])->name('pengajuan-form-non-pbj.acc');
        Route::resource('pengajuan-form-non-pbj', \App\Http\Controllers\Ppk\PengajuanFormNonPbjController::class);

        Route::get('pengajuan-form-non-pbj/{uuid}/disposisi', [App\Http\Controllers\Ppk\PengajuanFormNonPbjDisposisiController::class, 'index'])->name('pengajuan-form-non-pbj-disposisi.index');
        Route::get('pengajuan-form-non-pbj/{uuid}/disposisi/create', [App\Http\Controllers\Ppk\PengajuanFormNonPbjDisposisiController::class, 'create'])->name('pengajuan-form-non-pbj-disposisi.create');
        Route::post('pengajuan-form-non-pbj/{uuid}/disposisi', [App\Http\Controllers\Ppk\PengajuanFormNonPbjDisposisiController::class, 'store'])->name('pengajuan-form-non-pbj-disposisi.store');
        Route::delete('pengajuan-form-non-pbj/{uuid}/disposisi', [App\Http\Controllers\Ppk\PengajuanFormNonPbjDisposisiController::class, 'destroy'])->name('pengajuan-form-non-pbj-disposisi.destroy');

        Route::controller(\App\Http\Controllers\Ppk\PengajuanFormNonPbjSpjController::class)->group(function () {
            Route::get('/pengajuan-form-non-pbj-spj', 'index')->name('pengajuan-form-non-pbj-spj.index');
            Route::get('/pengajuan-form-non-pbj-spj/{uuid}', 'show')->name('pengajuan-form-non-pbj-spj.show');
            Route::post('pengajuan-form-non-pbj-spj/acc/{uuid}', 'acc')->name('pengajuan-form-non-pbj-spj.acc');
        });

        Route::controller(\App\Http\Controllers\Ppk\PengajuanPbjController::class)->group(function () {
            Route::get('/pengajuan-pbj', 'index')->name('pengajuan-pbj.index');
            Route::get('/pengajuan-pbj/{uuid}', 'show')->name('pengajuan-pbj.show');
            Route::post('pengajuan-pbj/acc/{uuid}', 'acc')->name('pengajuan-pbj.acc');
        });

        Route::resource('spd', App\Http\Controllers\Ppk\SpdController::class);
        // Route::resource('spd-spj', App\Http\Controllers\Ppk\SpdSpjController::class);
        Route::resource('spd-spj-detail', App\Http\Controllers\Ppk\SpdSpjDetailController::class);

        Route::resource('pengajuan-pbj-proses', \App\Http\Controllers\Ppk\PengajuanPbjProsesController::class)->except('show');
        // Route::get('proses-pbj/{pbj_uuid}', [ProsesPbjController::class, 'show'])->name('proses-pbj.show');
    });

    Route::name('pengadministrasi-umum.')->prefix('pengadministrasi-umum')->middleware('role:Pengadministrasi Umum')->group(function () {
        Route::get('/', [\App\Http\Controllers\Pengadministrasiumum\DashboardController::class, 'index'])->name('dashboard');
        Route::get('surat/detail', [\App\Http\Controllers\Pengadministrasiumum\SuratTugasController::class, 'detail'])->name('surat.detail');
        Route::resource('surat', \App\Http\Controllers\Pengadministrasiumum\SuratTugasController::class);

        Route::resource('permohonan-spd', PermohonanSpdController::class);
        Route::resource('pengajuan-form-non-pbj', \App\Http\Controllers\Pengadministrasiumum\PengajuanFormNonPbjController::class);
        Route::resource('pengajuan-pbj', \App\Http\Controllers\Pengadministrasiumum\PengajuanPbjController::class);

        Route::resource('spd', App\Http\Controllers\Pengadministrasiumum\SpdController::class);
        Route::resource('spd-spj', App\Http\Controllers\Pengadministrasiumum\SpdSpjController::class);
        Route::resource('spd-spj-detail', App\Http\Controllers\Pengadministrasiumum\SpdSpjDetailController::class);
    });

    Route::name('wakil-direktur-ii.')->prefix('wakil-direktur-ii')->middleware('role:Wakil Direktur II')->group(function () {
        Route::get('/', [\App\Http\Controllers\Wakildirekturii\DashboardController::class, 'index'])->name('dashboard');
        Route::post('permohonan-spd/verifikasi/{id}', [App\Http\Controllers\Wakildirekturii\PermohonanSpdController::class, 'verifikasi'])->name('permohonan-spd.verifikasi');
        Route::resource('permohonan-spd', App\Http\Controllers\Wakildirekturii\PermohonanSpdController::class);
        Route::get('tte', [App\Http\Controllers\Wakildirekturii\TTEController::class, 'index'])->name('tte.index');
        Route::post('tte', [App\Http\Controllers\Wakildirekturii\TTEController::class, 'update'])->name('tte.update');
        Route::delete('tte', [App\Http\Controllers\Wakildirekturii\TTEController::class, 'destroy'])->name('tte.destroy');

        // disposisi spd
        Route::resource('permohonan-spd-disposisi', App\Http\Controllers\Wakildirekturii\PermohonanSpdDisposisiController::class);
        Route::controller(\App\Http\Controllers\Wakildirekturii\PengajuanPbjController::class)->group(function () {
            Route::get('/pengajuan-pbj', 'index')->name('pengajuan-pbj.index');
            Route::get('/pengajuan-pbj/{uuid}', 'show')->name('pengajuan-pbj.show');
            Route::post('pengajuan-pbj/acc/{uuid}', 'acc')->name('pengajuan-pbj.acc');
        });

        Route::get('pengajuan-pbj/{uuid}/disposisi', [App\Http\Controllers\Wakildirekturii\PengajuanPbjDisposisiController::class, 'index'])->name('pengajuan-pbj-disposisi.index');
        Route::get('pengajuan-pbj/{uuid}/disposisi/create', [App\Http\Controllers\Wakildirekturii\PengajuanPbjDisposisiController::class, 'create'])->name('pengajuan-pbj-disposisi.create');
        Route::post('pengajuan-pbj/{uuid}/disposisi', [App\Http\Controllers\Wakildirekturii\PengajuanPbjDisposisiController::class, 'store'])->name('pengajuan-pbj-disposisi.store');
        Route::delete('pengajuan-pbj/{uuid}/disposisi', [App\Http\Controllers\Wakildirekturii\PengajuanPbjDisposisiController::class, 'destroy'])->name('pengajuan-pbj-disposisi.destroy');

        Route::resource('spd', App\Http\Controllers\Wakildirekturii\SpdController::class);
        Route::resource('spd-spj', App\Http\Controllers\Wakildirekturii\SpdSpjController::class);
        Route::resource('spd-spj-detail', App\Http\Controllers\Wakildirekturii\SpdSpjDetailController::class);
    });

    Route::name('bendahara-keuangan.')->prefix('bendahara-keuangan')->middleware('role:Bendahara Keuangan')->group(function () {
        Route::get('/', [\App\Http\Controllers\Bendaharakeuangan\DashboardController::class, 'index'])->name('dashboard');
        Route::resource('permohonan-spd', App\Http\Controllers\Bendaharakeuangan\PermohonanSpdController::class);
        Route::resource('spd-detail', App\Http\Controllers\Bendaharakeuangan\SpdDetailController::class);
        Route::resource('spd-detail-supir', App\Http\Controllers\Bendaharakeuangan\SpdDetailSupirController::class);
        Route::resource('spd-detail-uang-muka', App\Http\Controllers\Bendaharakeuangan\SpdDetailUangMukaController::class);
        Route::resource('pengajuan-form-non-pbj', \App\Http\Controllers\Bendaharakeuangan\PengajuanFormNonPbjController::class);

        Route::get('spd-detail/print/{uuid}', [App\Http\Controllers\Bendaharakeuangan\SpdDetailController::class, 'print'])->name('spd-detail.print');
        Route::resource('spd', App\Http\Controllers\Bendaharakeuangan\SpdController::class);
        Route::resource('spd-spj', App\Http\Controllers\Bendaharakeuangan\SpdSpjController::class);
        Route::resource('spd-spj-detail', App\Http\Controllers\Bendaharakeuangan\SpdSpjDetailController::class);


        Route::controller(\App\Http\Controllers\Bendaharakeuangan\PengajuanFormNonPbjUangMukaController::class)->group(function () {
            Route::get('/pengajuan-form-non-pbj-uang-muka', 'index')->name('pengajuan-form-non-pbj-uang-muka.index');
            Route::get('/pengajuan-form-non-pbj-uang-muka/create', 'create')->name('pengajuan-form-non-pbj-uang-muka.create');
            Route::post('/pengajuan-form-non-pbj-uang-muka/create', 'store')->name('pengajuan-form-non-pbj-uang-muka.store');
            Route::get('/pengajuan-form-non-pbj-uang-muka/{uuid}/edit', 'edit')->name('pengajuan-form-non-pbj-uang-muka.edit');
            Route::patch('/pengajuan-form-non-pbj-uang-muka/{uuid}/edit', 'update')->name('pengajuan-form-non-pbj-uang-muka.update');
            Route::delete('/pengajuan-form-non-pbj-uang-muka/{uuid}', 'destroy')->name('pengajuan-form-non-pbj-uang-muka.destroy');
        });

        Route::controller(\App\Http\Controllers\Bendaharakeuangan\ArsipController::class)->group(function () {
            Route::get('/arsip-spd-spj', 'spd_spj')->name('arsip-spd-spj.index');
            Route::get('/arsip-spd-spj-detail/{spj_uuid}', 'spd_spj_detail')->name('arsip-spd-spj.detail');
        });
    });

    Route::name('pelaksana-spd.')->prefix('pelaksana-spd')->middleware('role:Pelaksana Perjalanan Dinas')->group(function () {
        Route::get('/', [\App\Http\Controllers\Pelaksanaspd\DashboardController::class, 'index'])->name('dashboard');
        Route::resource('spd', App\Http\Controllers\Pelaksanaspd\SpdController::class);
        Route::resource('spd-spj', App\Http\Controllers\Pelaksanaspd\SpdSpjController::class);
        Route::resource('spd-spj-detail', App\Http\Controllers\Pelaksanaspd\SpdSpjDetailController::class);
    });


    Route::name('pengusul.')->prefix('pengusul')->middleware('role:Pengusul')->group(function () {
        Route::get('/', [\App\Http\Controllers\Pengusul\DashboardController::class, 'index'])->name('dashboard');
        Route::post('pengajuan-pbj-form-non-pbj/verifikasi/{uuid}', [\App\Http\Controllers\Pengusul\PengajuanFormNonPbjController::class, 'verifikasi'])->name('pengajuan-form-non-pbj.verifikasi');
        Route::resource('pengajuan-form-non-pbj', \App\Http\Controllers\Pengusul\PengajuanFormNonPbjController::class);
        Route::resource('pengajuan-form-non-pbj-detail', \App\Http\Controllers\Pengusul\PengajuanFormNonPbjDetailController::class);
    });

    Route::name('pelaksana-belanja.')->prefix('pelaksana-belanja')->middleware('role:Pelaksana Belanja')->group(function () {
        Route::get('/', [\App\Http\Controllers\Pelaksanabelanja\DashboardController::class, 'index'])->name('dashboard');
        Route::resource('pengajuan-form-non-pbj', \App\Http\Controllers\Pelaksanabelanja\PengajuanFormNonPbjController::class);
        Route::resource('pengajuan-form-non-pbj-spj', App\Http\Controllers\Pelaksanabelanja\PengajuanFormNonPbjSpjController::class);
        // Route::resource('pengajuan-form-non-pbj-spj-detail', App\Http\Controllers\Pelaksanabelanja\PengajuanFormNonPbjSpjDetailController::class);

        Route::controller(\App\Http\Controllers\Pelaksanabelanja\PengajuanFormNonPbjSpjDetailController::class)->group(function () {
            Route::get('/pengajuan-form-non-pbj-spj-detail', 'index')->name('pengajuan-form-non-pbj-spj-detail.index');
            Route::get('/pengajuan-form-non-pbj-spj-detail/create', 'create')->name('pengajuan-form-non-pbj-spj-detail.create');
            Route::post('/pengajuan-form-non-pbj-spj-detail/create', 'store')->name('pengajuan-form-non-pbj-spj-detail.store');
            Route::get('/pengajuan-form-non-pbj-spj-detail/{uuid}/edit', 'edit')->name('pengajuan-form-non-pbj-spj-detail.edit');
            Route::patch('/pengajuan-form-non-pbj-spj-detail/{uuid}/edit', 'update')->name('pengajuan-form-non-pbj-spj-detail.update');
            Route::delete('/pengajuan-form-non-pbj-spj-detail/{uuid}', 'destroy')->name('pengajuan-form-non-pbj-spj-detail.destroy');
        });
    });

    Route::name('wakil-direktur-i.')->prefix('wakil-direktur-i')->middleware('role:Wakil Direktur I')->group(function () {
        Route::get('/', [\App\Http\Controllers\Wakildirekturi\DashboardController::class, 'index'])->name('dashboard');
        Route::post('pengajuan-pbj/verifikasi/{uuid}', [\App\Http\Controllers\Wakildirekturi\PengajuanPbjController::class, 'verifikasi'])->name('pengajuan-pbj.verifikasi');
        Route::resource('pengajuan-pbj', \App\Http\Controllers\Wakildirekturi\PengajuanPbjController::class);
        Route::resource('pengajuan-pbj-detail', \App\Http\Controllers\Wakildirekturi\PengajuanPbjDetailController::class);

        Route::resource('spd', App\Http\Controllers\Wakildirekturi\SpdController::class);
        Route::resource('spd-spj', App\Http\Controllers\Wakildirekturi\SpdSpjController::class);
        Route::resource('spd-spj-detail', App\Http\Controllers\Wakildirekturi\SpdSpjDetailController::class);
    });

    Route::name('karyawan.')->prefix('karyawan')->middleware('role:Karyawan')->group(function () {
        Route::get('/', [\App\Http\Controllers\Karyawan\DashboardController::class, 'index'])->name('dashboard');
        Route::resource('spd', App\Http\Controllers\Karyawan\SpdController::class);
        Route::resource('spd-spj', App\Http\Controllers\Karyawan\SpdSpjController::class);
        Route::resource('spd-spj-detail', App\Http\Controllers\Karyawan\SpdSpjDetailController::class);
    });
});
