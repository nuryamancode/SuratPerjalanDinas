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
use Illuminate\Support\Facades\Auth;
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
Route::get('/', function () {
    if (Auth::check()) {
        if (auth()->user()->roles->pluck('name')->first() === 'Pengadministrasi Umum') {
            return redirect()->route('pengadministrasi-umum.dashboard');
        } else if (auth()->user()->roles->pluck('name')->first() === 'Wakil Direktur II') {
            return redirect()->route('wakil-direktur-ii.dashboard');
        } elseif (auth()->user()->roles->pluck('name')->first() === 'Wakil Direktur I') {
            return redirect()->route('wakil-direktur-i.dashboard');
        } elseif (auth()->user()->roles->pluck('name')->first() === 'Bendahara Keuangan') {
            return redirect()->route('bendahara-keuangan.dashboard');
        } elseif (auth()->user()->roles->pluck('name')->first() === 'Pengelola Keuangan') {
            return redirect()->route('pengelola-keuangan.dashboard');
        } elseif (auth()->user()->roles->pluck('name')->first() === 'Supir') {
            return redirect()->route('supir.dashboard');
        } elseif (auth()->user()->roles->pluck('name')->first() === 'Karyawan') {
            return redirect()->route('karyawan.dashboard');
        } elseif (auth()->user()->roles->pluck('name')->first() === 'Kepala Bagian') {
            return redirect()->route('kabag.dashboard');
        } elseif (auth()->user()->roles->pluck('name')->first() === 'Pejabat Pembuat Komitmen') {
            return redirect()->route('ppk.dashboard');
        } elseif (auth()->user()->roles->pluck('name')->first() === 'Tim PPK') {
            return redirect()->route('timppk.dashboard');
        } elseif (auth()->user()->roles->pluck('name')->first() === 'Admin') {
            return redirect()->route('dashboard');
        }
    } else {
        return redirect()->route('login');
    }
});
Route::middleware('auth')->group(function () {

    // admin
    Route::prefix('admin')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('users', UserController::class);
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

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


    // ppk
    Route::name('ppk.')->prefix('ppk')->group(function () {
        Route::get('/', [\App\Http\Controllers\Ppk\DashboardController::class, 'index'])->name('dashboard');
        Route::post('permohonan-spd/acc-ppk/{id}', [App\Http\Controllers\Ppk\PermohonanSpdController::class, 'acc_ppk'])->name('permohonan-spd.acc-ppk');
        Route::post('permohonan-spd/verifikasi-ppk/{id}', [App\Http\Controllers\Ppk\PermohonanSpdController::class, 'verifikasi_ppk'])->name('permohonan-spd.verifikasi-ppk');
        Route::resource('permohonan-spd', App\Http\Controllers\Ppk\PermohonanSpdController::class);
        // disposisi spd
        Route::resource('permohonan-spd-disposisi', App\Http\Controllers\Ppk\PermohonanSpdDisposisiController::class);
        Route::post('spd-spj/verifikasi/{id}', [App\Http\Controllers\Ppk\SpdSpjController::class, 'verifikasi'])->name('spd-spj.verifikasi');
        Route::resource('spd-spj', App\Http\Controllers\Ppk\SpdSpjController::class);
        Route::get('tte', [App\Http\Controllers\Ppk\TTEController::class, 'index'])->name('tte.index');
        Route::post('tte', [App\Http\Controllers\Ppk\TTEController::class, 'update'])->name('tte.update');
        Route::delete('tte', [App\Http\Controllers\Ppk\TTEController::class, 'destroy'])->name('tte.destroy');
        Route::resource('spd', App\Http\Controllers\Ppk\SpdController::class);
        Route::resource('spd-spj-detail', App\Http\Controllers\Ppk\SpdSpjDetailController::class);
        Route::get('permohonan-spd-disposisi-print/{id}', [App\Http\Controllers\Ppk\PermohonanSpdDisposisiController::class, 'print'])->name('permohonan-spd-disposisi.print');

        // pembelanjaan
        Route::controller(App\Http\Controllers\Ppk\FormNonPbjController::class)->group(function () {
            Route::get('form-non-pbj', 'index')->name('form-non-pbj.index');
            Route::get('form-non-pbj/detail/{id}', 'show')->name('form-non-pbj.show');
            Route::put('form-non-pbj/tolak/{id}', 'tolak')->name('form-non-pbj.tolak');
        });
        Route::post('pengajuan-form-non-pbj/store/{id}', [App\Http\Controllers\Ppk\PengajuanFormNonPbjController::class, 'store'])->name('pengajuan-form-non-pbj.store');
        Route::resource('pengajuan-form-non-pbj', \App\Http\Controllers\Ppk\PengajuanFormNonPbjController::class);
        Route::get('pengajuan-form-non-pbj/{id}/disposisi', [App\Http\Controllers\Ppk\PengajuanFormNonPbjDisposisiController::class, 'index'])->name('pengajuan-form-non-pbj-disposisi.index');
        Route::get('pengajuan-form-non-pbj/{id}/disposisi/create', [App\Http\Controllers\Ppk\PengajuanFormNonPbjDisposisiController::class, 'create'])->name('pengajuan-form-non-pbj-disposisi.create');
        Route::get('pengajuan-form-non-pbj/{id}/disposisi/edit', [App\Http\Controllers\Ppk\PengajuanFormNonPbjDisposisiController::class, 'edit'])->name('pengajuan-form-non-pbj-disposisi.edit');
        Route::post('pengajuan-form-non-pbj/{id}/disposisi/store', [App\Http\Controllers\Ppk\PengajuanFormNonPbjDisposisiController::class, 'store'])->name('pengajuan-form-non-pbj-disposisi.store');
        Route::put('pengajuan-form-non-pbj/{id}/disposisi/update', [App\Http\Controllers\Ppk\PengajuanFormNonPbjDisposisiController::class, 'update'])->name('pengajuan-form-non-pbj-disposisi.update');
        Route::delete('pengajuan-form-non-pbj/{id}/disposisi', [App\Http\Controllers\Ppk\PengajuanFormNonPbjDisposisiController::class, 'destroy'])->name('pengajuan-form-non-pbj-disposisi.destroy');

        Route::controller(\App\Http\Controllers\Ppk\PengajuanFormNonPbjSpjController::class)->group(function () {
            Route::get('/pengajuan-form-non-pbj-spj', 'index')->name('pengajuan-form-non-pbj-spj.index');
            Route::get('/pengajuan-form-non-pbj-spj/{id}', 'show')->name('pengajuan-form-non-pbj-spj.show');
            Route::post('pengajuan-form-non-pbj-spj/acc/{id}', 'acc')->name('pengajuan-form-non-pbj-spj.acc');
            Route::put('pengajuan-form-non-pbj-spj/tolak/{id}', 'tolak')->name('pengajuan-form-non-pbj-spj.tolak');
        });

        Route::controller(\App\Http\Controllers\Ppk\PengajuanPbjController::class)->group(function () {
            Route::get('/pengajuan-pbj', 'index')->name('pengajuan-pbj.index');
            Route::get('/pengajuan-pbj/{id}', 'show')->name('pengajuan-pbj.show');
            Route::get('/pengajuan-pbj/print/{id}', 'print_disposisi')->name('pengajuan-pbj.print');
            Route::get('pengajuan-pbj/disposisi/{id}', 'disposisi')->name('pengajuan-pbj-disposisi.index');
            Route::get('pengajuan-pbj/disposisi/edit/{id}', 'edit_disposisi')->name('pengajuan-pbj-disposisi.edit');
            Route::put('pengajuan-pbj/disposisi/store/{id}', 'update_disposisi')->name('pengajuan-pbj-disposisi.store');
            Route::post('pengajuan-pbj/verifikasi/{id}', 'verifikasi')->name('pengajuan-pbj.verifikasi');
        });
        Route::controller(\App\Http\Controllers\Ppk\FormNonPbjController::class)->group(function () {
            Route::get('/form-non-pbj', 'index')->name('form-non-pbj.index');
            Route::get('/form-non-pbj/{id}', 'show')->name('form-non-pbj.show');
            Route::post('form-non-pbj/acc/{id}', 'acc')->name('form-non-pbj.acc');
        });

        Route::controller(\App\Http\Controllers\Ppk\FormNonPbjDisposisiController::class)->group(function () {
            Route::get('/form-non-pbj-disposisi/{id}', 'index')->name('form-non-pbj-disposisi.index');
            Route::get('/form-non-pbj-disposisi/{id}/create', 'create')->name('form-non-pbj-disposisi.create');
            Route::post('form-non-pbj-disposisi/{id}/store', 'store')->name('form-non-pbj-disposisi.store');
            // Route::post('form-non-pbj-disposisi/acc/{id}', 'acc')->name('form-non-pbj.acc');
            Route::delete('form-non-pbj-disposisi/{id}', 'destroy')->name('form-non-pbj-disposisi.destroy');
        });

        // Route::resource('form-non-pbj', \App\Http\Controllers\Ppk\FormNonPbjController::class);

        Route::controller(\App\Http\Controllers\Ppk\FormNonPbjSpjController::class)->group(function () {
            Route::get('/form-non-pbj-spj', 'index')->name('form-non-pbj-spj.index');
            Route::get('/form-non-pbj-spj/{id}/print', 'print')->name('form-non-pbj-spj.print');
            Route::get('/form-non-pbj-spj/{id}/show', 'show')->name('form-non-pbj-spj.show');
            Route::post('form-non-pbj-spj/acc/{id}', 'acc')->name('form-non-pbj-spj.acc');
            Route::put('form-non-pbj-spj/tolak/{id}', 'tolak')->name('form-non-pbj-spj.tolak');
        });

        Route::controller(\App\Http\Controllers\Ppk\SuratNonPbjController::class)->group(function () {
            Route::get('/surat-non-pbj', 'index')->name('surat-non-pbj.index');
            Route::get('/surat-non-pbj/{id}', 'show')->name('surat-non-pbj.show');
            Route::post('surat-non-pbj/verifikasi/{id}', 'verifikasi')->name('surat-non-pbj.verifikasi');
            Route::get('surat-non-pbj/print/{id}', 'print_disposisi')->name('surat-non-pbj.print');
            Route::put('surat-non-pbj/tolak/pengajuan/{id}', 'tolak')->name('surat-non-pbj.tolak');
        });


        Route::get('surat-non-pbj/{id}/disposisi', [App\Http\Controllers\Ppk\SuratNonPbjDisposisiController::class, 'index'])->name('surat-non-pbj-disposisi.index');
        Route::get('surat-non-pbj/{id}/disposisi/create', [App\Http\Controllers\Ppk\SuratNonPbjDisposisiController::class, 'create'])->name('surat-non-pbj-disposisi.create');
        Route::post('surat-non-pbj/{id}/disposisi', [App\Http\Controllers\Ppk\SuratNonPbjDisposisiController::class, 'store'])->name('surat-non-pbj-disposisi.store');
        Route::delete('surat-non-pbj/{id}/disposisi', [App\Http\Controllers\Ppk\SuratNonPbjDisposisiController::class, 'destroy'])->name('surat-non-pbj-disposisi.destroy');

        // surat non pbj spj
        Route::controller(\App\Http\Controllers\Ppk\SuratNonPbjSpjController::class)->group(function () {
            Route::get('/surat-non-pbj-spj', 'index')->name('surat-non-pbj-spj.index');
            Route::get('/surat-non-pbj-spj/{id}/print', 'print')->name('surat-non-pbj-spj.print');
            Route::get('/surat-non-pbj-spj/{id}/show', 'show')->name('surat-non-pbj-spj.show');
            Route::post('surat-non-pbj-spj/acc/{id}', 'acc')->name('surat-non-pbj-spj.acc');
            Route::put('surat-non-pbj-spj/tolak/{id}', 'tolak')->name('surat-non-pbj-spj.tolak');
        });
    });

    Route::name('pengadministrasi-umum.')->prefix('pengadministrasi-umum')->middleware('role:Pengadministrasi Umum')->group(function () {
        Route::get('/', [\App\Http\Controllers\Pengadministrasiumum\DashboardController::class, 'index'])->name('dashboard');
        Route::get('surat/detail', [\App\Http\Controllers\Pengadministrasiumum\SuratTugasController::class, 'detail'])->name('surat.detail');
        Route::resource('surat', \App\Http\Controllers\Pengadministrasiumum\SuratTugasController::class);

        Route::resource('permohonan-spd', PermohonanSpdController::class);
        Route::resource('pengajuan-form-non-pbj', \App\Http\Controllers\Pengadministrasiumum\PengajuanFormNonPbjController::class);
        Route::resource('pengajuan-surat-non-pbj', \App\Http\Controllers\Pengadministrasiumum\PengajuanSuratNonPbjController::class);
        Route::resource('pengajuan-pbj', \App\Http\Controllers\Pengadministrasiumum\PengajuanPbjController::class);

        Route::resource('spd', App\Http\Controllers\Pengadministrasiumum\SpdController::class);
        Route::resource('spd-spj', App\Http\Controllers\Pengadministrasiumum\SpdSpjController::class);
        Route::resource('spd-spj-detail', App\Http\Controllers\Pengadministrasiumum\SpdSpjDetailController::class);

        Route::resource('surat-non-pbj', \App\Http\Controllers\Pengadministrasiumum\SuratNonPbjController::class);
    });

    Route::name('wakil-direktur-ii.')->prefix('wakil-direktur-ii')->middleware('role:Wakil Direktur II')->group(function () {
        Route::get('/', [\App\Http\Controllers\Wakildirekturii\DashboardController::class, 'index'])->name('dashboard');
        Route::post('permohonan-spd/verifikasi/{id}', [App\Http\Controllers\Wakildirekturii\PermohonanSpdController::class, 'verifikasi'])->name('permohonan-spd.verifikasi');
        Route::resource('permohonan-spd', App\Http\Controllers\Wakildirekturii\PermohonanSpdController::class);
        Route::get('tte', [App\Http\Controllers\Wakildirekturii\TTEController::class, 'index'])->name('tte.index');
        Route::post('tte', [App\Http\Controllers\Wakildirekturii\TTEController::class, 'update'])->name('tte.update');
        Route::delete('tte', [App\Http\Controllers\Wakildirekturii\TTEController::class, 'destroy'])->name('tte.destroy');

        // disposisi spd
        Route::get('permohonan-spd-disposisi-print/{uuid}', [App\Http\Controllers\Wakildirekturii\PermohonanSpdDisposisiController::class, 'print'])->name('permohonan-spd-disposisi.print');

        Route::resource('permohonan-spd-disposisi', App\Http\Controllers\Wakildirekturii\PermohonanSpdDisposisiController::class);
        Route::get('pengajuan-pbj/detail', [\App\Http\Controllers\Wakildirekturii\PengajuanPbjController::class, 'detail'])->name('pengajuan-pbj.detail');
        Route::controller(\App\Http\Controllers\Wakildirekturii\PengajuanPbjController::class)->group(function () {
            Route::get('/pengajuan-pbj', 'index')->name('pengajuan-pbj.index');
            Route::get('/pengajuan-pbj-lampiran/{lampiran}', 'getFile')->name('pengajuan-pbj.lampiran');
            Route::get('/pengajuan-pbj/{id}', 'show')->name('pengajuan-pbj.show');
            Route::put('pengajuan-pbj/acc/{id}', 'acc')->name('pengajuan-pbj.acc');
            Route::post('pengajuan-pbj/verifikasi/{id}', 'verifikasi')->name('pengajuan-pbj.verifikasi');
            Route::put('pengajuan-pbj/tolak/{id}', 'tolak')->name('pengajuan-pbj.tolak');
        });
        Route::get('permohonan-pbj-print/{id}', [App\Http\Controllers\Wakildirekturii\PengajuanPbjController::class, 'print_disposisi'])->name('pengajuan-pbj.print');

        Route::resource('pengajuan-form-non-pbj', App\Http\Controllers\Wakildirekturii\PengajuanFormNonPbjController::class);
        Route::get('pengajuan-pbj/{id}/disposisi', [App\Http\Controllers\Wakildirekturii\PengajuanPbjDisposisiController::class, 'index'])->name('pengajuan-pbj-disposisi.index');
        Route::get('pengajuan-pbj/{id}/disposisi/create', [App\Http\Controllers\Wakildirekturii\PengajuanPbjDisposisiController::class, 'create'])->name('pengajuan-pbj-disposisi.create');
        Route::get('pengajuan-pbj/{id}/disposisi/edit', [App\Http\Controllers\Wakildirekturii\PengajuanPbjDisposisiController::class, 'edit'])->name('pengajuan-pbj-disposisi.edit');
        Route::put('pengajuan-pbj/{id}/disposisi/update', [App\Http\Controllers\Wakildirekturii\PengajuanPbjDisposisiController::class, 'update'])->name('pengajuan-pbj-disposisi.update');
        Route::post('pengajuan-pbj/{id}/disposisi', [App\Http\Controllers\Wakildirekturii\PengajuanPbjDisposisiController::class, 'store'])->name('pengajuan-pbj-disposisi.store');
        Route::delete('pengajuan-pbj/{id}/disposisi', [App\Http\Controllers\Wakildirekturii\PengajuanPbjDisposisiController::class, 'destroy'])->name('pengajuan-pbj-disposisi.destroy');

        Route::resource('spd', App\Http\Controllers\Wakildirekturii\SpdController::class);
        Route::resource('spd-spj', App\Http\Controllers\Wakildirekturii\SpdSpjController::class);
        Route::resource('spd-spj-detail', App\Http\Controllers\Wakildirekturii\SpdSpjDetailController::class);
        Route::post('surat-non-pbj/verifikasi/{id}', [\App\Http\Controllers\Wakildirekturii\SuratNonPbjController::class, 'verifikasi'])->name('surat-non-pbj.verifikasi');
        Route::get('surat-non-pbj/print/{id}', [\App\Http\Controllers\Wakildirekturii\SuratNonPbjController::class, 'print_disposisi'])->name('surat-non-pbj.print');
        Route::put('surat-non-pbj/tolak/{id}', [\App\Http\Controllers\Wakildirekturii\SuratNonPbjController::class, 'tolak'])->name('surat-non-pbj.tolak');
        Route::resource('surat-non-pbj', \App\Http\Controllers\Wakildirekturii\SuratNonPbjController::class);

        Route::get('surat-non-pbj/{id}/disposisi', [App\Http\Controllers\Wakildirekturii\SuratNonPbjDisposisiController::class, 'index'])->name('surat-non-pbj-disposisi.index');
        Route::get('surat-non-pbj/{id}/disposisi/edit', [App\Http\Controllers\Wakildirekturii\SuratNonPbjDisposisiController::class, 'edit'])->name('surat-non-pbj-disposisi.edit');
        Route::get('surat-non-pbj/{id}/disposisi/create', [App\Http\Controllers\Wakildirekturii\SuratNonPbjDisposisiController::class, 'create'])->name('surat-non-pbj-disposisi.create');
        Route::post('surat-non-pbj/{id}/disposisi', [App\Http\Controllers\Wakildirekturii\SuratNonPbjDisposisiController::class, 'store'])->name('surat-non-pbj-disposisi.store');
        Route::post('surat-non-pbj/{id}/disposisi/update', [App\Http\Controllers\Wakildirekturii\SuratNonPbjDisposisiController::class, 'update'])->name('surat-non-pbj-disposisi.update');
        Route::delete('surat-non-pbj/{id}/disposisi', [App\Http\Controllers\Wakildirekturii\SuratNonPbjDisposisiController::class, 'destroy'])->name('surat-non-pbj-disposisi.destroy');
    });

    Route::name('bendahara-keuangan.')->prefix('bendahara-keuangan')->middleware('role:Bendahara Keuangan')->group(function () {
        Route::get('/', [\App\Http\Controllers\Bendaharakeuangan\DashboardController::class, 'index'])->name('dashboard');
        Route::resource('permohonan-spd', App\Http\Controllers\Bendaharakeuangan\PermohonanSpdController::class);
        Route::resource('pengajuan-pbj', App\Http\Controllers\Bendaharakeuangan\PengajuanPbjController::class);
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
        Route::controller(\App\Http\Controllers\Bendaharakeuangan\PermohonanBelanjaController::class)->group(function () {
            Route::get('/permohonan-belanja', 'index')->name('permohonan-belanja.index');
            Route::get('/permohonan-belanja/{id}/detail', 'show')->name('permohonan-belanja.show');
        });
        Route::controller(\App\Http\Controllers\Bendaharakeuangan\PermohonanBelanjaDisposisiController::class)->group(function () {
            Route::get('/permohonan-belanja-disposisi/{id}', 'index')->name('permohonan-belanja-disposisi.index');
            Route::get('/permohonan-belanja-disposisi/{id}/detail', 'show')->name('permohonan-belanja-disposisi.show');
            Route::put('/permohonan-belanja-disposisi/{id}/tanggapi', 'tanggapi')->name('permohonan-belanja-disposisi.tanggapi');
        });

        Route::controller(\App\Http\Controllers\Bendaharakeuangan\ArsipController::class)->group(function () {
            Route::get('/arsip-spd-spj', 'spd_spj')->name('arsip-spd-spj.index');
            Route::get('/arsip-spd-spj-detail/{spj_uuid}', 'spd_spj_detail')->name('arsip-spd-spj.detail');
            Route::get('/arsip-spd-submit/{spd_uuid}', 'spd_arsip')->name('arsip-spd.submit');
        });


        Route::get('permohonan-spd-disposisi-print/{uuid}', [App\Http\Controllers\Bendaharakeuangan\PermohonanSpdController::class, 'print'])->name('permohonan-spd.print');

        Route::controller(\App\Http\Controllers\Bendaharakeuangan\FormNonPbjController::class)->group(function () {
            Route::get('/form-non-pbj', 'index')->name('form-non-pbj.index');
            Route::post('/form-non-pbj/{uuid}', 'arsip')->name('form-non-pbj.arsip');
            Route::get('/form-non-pbj-arsip', 'get_arsip')->name('arsip-form-non-pbj.index');
            Route::get('/form-non-pbj-spj/{uuid}', 'spj')->name('form-non-pbj.spj');
        });
        Route::controller(\App\Http\Controllers\Bendaharakeuangan\FormNonPbjUangMukaController::class)->group(function () {
            Route::get('/form-non-pbj-uang-muka/{uuid}', 'index')->name('form-non-pbj-uang-muka.index');
            Route::post('/form-non-pbj-uang-muka', 'store')->name('form-non-pbj-uang-muka.store');
        });

        Route::controller(\App\Http\Controllers\Bendaharakeuangan\SuratNonPbjUangMukaController::class)->group(function () {
            Route::get('/surat-non-pbj-uang-muka/{uuid}', 'index')->name('surat-non-pbj-uang-muka.index');
            Route::post('/surat-non-pbj-uang-muka', 'store')->name('surat-non-pbj-uang-muka.store');
        });


        Route::resource('surat-non-pbj', \App\Http\Controllers\Bendaharakeuangan\SuratNonPbjController::class)->only(['index', 'show']);
        Route::controller(\App\Http\Controllers\Bendaharakeuangan\SuratNonPbjController::class)->group(function () {
            Route::post('/surat-non-pbj-submit/{uuid}', 'submit_arsip')->name('surat-non-pbj.submit-arsip');
            Route::put('/surat-non-pbj-tanggapi/{id}', 'store_tanggapi')->name('surat-non-pbj.store_tanggapi');
            Route::get('/arsip-surat-non-pbj', 'arsip_index')->name('surat-non-pbj.arsip-index');
            Route::get('/arsip-surat-non-pbj-spj/{id}/surat', 'arsip_spj')->name('surat-non-pbj.arsip-spj');
            Route::get('/arsip-form-non-pbj-spj/{id}/form', 'arsip_spj_form')->name('form-non-pbj.arsip_spj_form-spj');
        });
        Route::controller(\App\Http\Controllers\Bendaharakeuangan\DistribusiBelanjaController::class)->group(function () {
            Route::get('disposisi-belanja-form-non-pbj', 'form_non_pbj')->name('disposisi-belanja.form-non-pbj');
            Route::get('disposisi-belanja-surat-non-pbj', 'surat_non_pbj')->name('disposisi-belanja.surat-non-pbj');
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
    });

    Route::name('wakil-direktur-i.')->prefix('wakil-direktur-i')->middleware('role:Wakil Direktur I')->group(function () {
        Route::get('/', [\App\Http\Controllers\Wakildirekturi\DashboardController::class, 'index'])->name('dashboard');
        Route::post('pengajuan-pbj/verifikasi/{uuid}', [\App\Http\Controllers\Wakildirekturi\PengajuanPbjController::class, 'verifikasi'])->name('pengajuan-pbj.verifikasi');
        Route::resource('pengajuan-pbj', \App\Http\Controllers\Wakildirekturi\PengajuanPbjController::class);
        Route::resource('pengajuan-form-non-pbj', \App\Http\Controllers\Wakildirekturi\PengajuanFormNonPbjController::class);

        Route::resource('spd', App\Http\Controllers\Wakildirekturi\SpdController::class);
        Route::resource('spd-spj', App\Http\Controllers\Wakildirekturi\SpdSpjController::class);
        Route::resource('spd-spj-detail', App\Http\Controllers\Wakildirekturi\SpdSpjDetailController::class);

        // surat non pbj
        Route::post('surat-non-pbj/verifikasi/{id}', [\App\Http\Controllers\Wakildirekturi\SuratNonPbjController::class, 'verifikasi'])->name('surat-non-pbj.verifikasi');
        Route::put('surat-non-pbj/taksiran/{id}', [\App\Http\Controllers\Wakildirekturi\SuratNonPbjController::class, 'taksiran'])->name('surat-non-pbj.taksiran');
        Route::resource('surat-non-pbj', \App\Http\Controllers\Wakildirekturi\SuratNonPbjController::class)->only(['index', 'show']);
        Route::resource('surat-non-pbj-detail', \App\Http\Controllers\Wakildirekturi\SuratNonPbjDetailController::class);
    });

    Route::name('karyawan.')->prefix('karyawan')->middleware('role:Karyawan')->group(function () {
        Route::get('/', [\App\Http\Controllers\Karyawan\DashboardController::class, 'index'])->name('dashboard');
        Route::resource('spd', App\Http\Controllers\Karyawan\SpdController::class);
        Route::get('/spd-spj/print/{spj_uuid}', [\App\Http\Controllers\Karyawan\SpdSpjController::class, 'print'])->name('spd-spj.print');

        Route::resource('spd-spj', App\Http\Controllers\Karyawan\SpdSpjController::class);
        Route::resource('spd-spj-detail', App\Http\Controllers\Karyawan\SpdSpjDetailController::class);
        Route::get('riwayat-pbj', [\App\Http\Controllers\Karyawan\PengajuanPbjController::class, 'index'])->name('riwayat-pbj.index');
        Route::get('riwayat-pbj/show/{id}', [\App\Http\Controllers\Karyawan\PengajuanPbjController::class, 'show'])->name('riwayat-pbj.show');
        Route::resource('form-non-pbj', \App\Http\Controllers\Karyawan\FormNonPbjController::class);
        Route::resource('surat-non-pbj', \App\Http\Controllers\Karyawan\SuratNonPbjController::class);
    });

    Route::name('kabag.')->prefix('kabag')->middleware('role:Kepala Bagian')->group(function () {
        Route::get('/', [\App\Http\Controllers\Kabag\DashboardController::class, 'index'])->name('dashboard');
        Route::post('pengajuan-pbj/verifikasi/{id}', [\App\Http\Controllers\Kabag\PengajuanPbjController::class, 'verifikasi'])->name('pengajuan-pbj.verifikasi');
        Route::resource('pengajuan-pbj', \App\Http\Controllers\Kabag\PengajuanPbjController::class);
        Route::resource('pengajuan-pbj-detail', \App\Http\Controllers\Kabag\PengajuanPbjDetailController::class);
        Route::resource('surat-non-pbj', \App\Http\Controllers\Kabag\SuratNonPbjController::class)->only(['index', 'show']);
        Route::resource('surat-non-pbj-detail', \App\Http\Controllers\Kabag\SuratNonPbjDetailController::class);
        Route::resource('form-non-pbj', \App\Http\Controllers\Kabag\PengajuanFormNonPbjController::class);
        Route::put('surat-non-pbj/taksiran/{id}', [\App\Http\Controllers\Kabag\SuratNonPbjController::class, 'taksiran'])->name('taksiran.store');
        Route::post('surat-non-pbj/verifikasi/{id}', [\App\Http\Controllers\Kabag\SuratNonPbjController::class, 'verifikasi'])->name('surat-non-pbj.verifikasi');
    });

    Route::name('timppk.')->prefix('timppk')->middleware('role:Tim PPK')->group(function () {
        Route::get('/', [\App\Http\Controllers\Timppk\DashboardController::class, 'index'])->name('dashboard');
        Route::resource('pengajuan-pbj', \App\Http\Controllers\Timppk\PengajuanPbjController::class);
        Route::put('pengajuan-pbj/update-proses/{id}', [\App\Http\Controllers\Timppk\PengajuanPbjController::class, 'update_proses'])->name('pengajuan-pbj.update-proses');
        Route::resource('pembelanjaan-form-non-pbj', \App\Http\Controllers\Timppk\PembelanjaanFormController::class);
        Route::get('/pembelanjaan-form-non-pbj/print/{id}', [\App\Http\Controllers\Timppk\PembelanjaanFormController::class, 'print'])->name('pembelanjaan-form-non-pbj.print', );
        Route::get('/pembelanjaan-form-non-pbj/kirim-ulang/{id}', [\App\Http\Controllers\Timppk\PembelanjaanFormController::class, 'kirim_ulang'])->name('pembelanjaan-form-non-pbj.kirim-ulang', );

        Route::controller(\App\Http\Controllers\Timppk\FormNonPbjController::class)->group(function () {
            Route::get('/form-non-pbj', 'index')->name('form-non-pbj.index');
            Route::get('/form-non-pbj/create', 'create')->name('form-non-pbj.create');
            Route::get('/form-non-pbj/edit/{id}', 'edit')->name('form-non-pbj.edit');
            Route::get('/form-non-pbj/show/{id}', 'show')->name('form-non-pbj.show');
            Route::post('/form-non-pbj/store', 'store')->name('form-non-pbj.store');
            Route::put('/form-non-pbj/update/{id}', 'update')->name('form-non-pbj.update');
        });

        Route::controller(\App\Http\Controllers\Timppk\FormNonPbjSpjController::class)->group(function () {
            Route::get('/form-non-pbj-spj/{id}', 'index')->name('form-non-pbj-spj.index');
            Route::get('/form-non-pbj-spj/{id}/show', 'show')->name('form-non-pbj-spj.show');
            Route::post('/form-non-pbj-spj', 'store')->name('form-non-pbj-spj.store');
        });

        Route::controller(\App\Http\Controllers\Timppk\FormNonPbjSpjDetailController::class)->group(function () {
            Route::get('/form-non-pbj-spj-detail', 'index')->name('form-non-pbj-spj-detail.index');
            Route::get('/form-non-pbj-spj-detail/create/{id}', 'create')->name('form-non-pbj-spj-detail.create');
            Route::post('/form-non-pbj-spj-detail/store/{id}', 'store')->name('form-non-pbj-spj-detail.store');
            Route::get('/form-non-pbj-spj-detail/{id}/edit', 'edit')->name('form-non-pbj-spj-detail.edit');
            Route::patch('/form-non-pbj-spj-detail/{id}/edit', 'update')->name('form-non-pbj-spj-detail.update');
            Route::delete('/form-non-pbj-spj-detail/{id}', 'destroy')->name('form-non-pbj-spj-detail.destroy');
        });

        Route::resource('surat-non-pbj', \App\Http\Controllers\Timppk\SuratNonPbjController::class)->only(['index', 'show']);
        Route::controller(\App\Http\Controllers\Timppk\SuratNonPbjSpjController::class)->group(function () {
            Route::get('/surat-non-pbj-spj/{uuid}', 'index')->name('surat-non-pbj-spj.index');
            Route::get('/surat-non-pbj-spj/{uuid}/show', 'show')->name('surat-non-pbj-spj.show');
            Route::post('/surat-non-pbj-spj', 'store')->name('surat-non-pbj-spj.store');
            Route::get('/surat-non-pbj-spj/print/{id}', 'print')->name('surat-non-pbj-spj.print');
        });
        Route::controller(\App\Http\Controllers\Timppk\SuratNonPbjSpjDetailController::class)->group(function () {
            Route::get('/surat-non-pbj-spj-detail', 'index')->name('surat-non-pbj-spj-detail.index');
            Route::get('/surat-non-pbj-spj-detail/create/data/{id}', 'create')->name('surat-non-pbj-spj-detail.create');
            Route::post('/surat-non-pbj-spj-detail/store/{id}', 'store')->name('surat-non-pbj-spj-detail.store');
            Route::put('/surat-non-pbj-spj-detail/kirim/{id}', 'kirim_ulang')->name('surat-non-pbj-spj-detail.kirim.ulang');
            Route::get('/surat-non-pbj-spj-detail/{uuid}/edit', 'edit')->name('surat-non-pbj-spj-detail.edit');
            Route::patch('/surat-non-pbj-spj-detail/{uuid}/edit', 'update')->name('surat-non-pbj-spj-detail.update');
            Route::delete('/surat-non-pbj-spj-detail/{id}', 'destroy')->name('surat-non-pbj-spj-detail.destroy');
        });
    });
    Route::name('supir.')->prefix('supir')->middleware('role:Supir')->group(function () {
        Route::get('/', [\App\Http\Controllers\Supir\DashboardController::class, 'index'])->name('dashboard');
    });


    Route::name('pengelola-keuangan.')->prefix('pengelola-keuangan')->middleware('role:Pengelola Keuangan')->group(function () {
        Route::get('/', [\App\Http\Controllers\Pengelolakeuangan\DashboardController::class, 'index'])->name('dashboard');
        Route::resource('pengajuan-pbj', \App\Http\Controllers\Pengelolakeuangan\PbjController::class)->only('index', 'show');
        Route::controller(\App\Http\Controllers\Pengelolakeuangan\SuratNonPbjController::class)->group(function () {
            Route::get('/surat-non-pbj', 'index')->name('surat-non-pbj.index');
            Route::get('/surat-non-pbj/arsip/spj', 'arsip_index')->name('surat-non-pbj.arsip.spj');
            Route::get('/arsip-form-non-pbj-spj/{id}/form', 'arsip_spj_form')->name('form-non-pbj.arsip_spj_form-spj');
            Route::get('/surat-non-pbj/arsip/show/{id}/spj', 'lihat_spj')->name('surat-non-pbj.lihat.spj');
            Route::get('/surat-non-pbj/detail/{id}', 'show')->name('surat-non-pbj.show');
            Route::put('/surat-non-pbj-tanggapi/{id}', 'store_tanggapi')->name('surat-non-pbj.store_tanggapi');
        });
        Route::controller(\App\Http\Controllers\Pengelolakeuangan\PengajuanFormNonPbjController::class)->group(function () {
            Route::get('/pengajuan-form-non-pbj', 'index')->name('pengajuan-form-non-pbj.index');
            Route::get('/pengajuan-form-non-pbj/create', 'create')->name('pengajuan-form-non-pbj.create');
            Route::post('/pengajuan-form-non-pbj/store', 'store')->name('pengajuan-form-non-pbj.store');
        });
        Route::controller(\App\Http\Controllers\Pengelolakeuangan\PermohonanBelanjaController::class)->group(function () {
            Route::get('/permohonan-form-non-pbj', 'index')->name('permohonan-form-non-pbj.index');
            Route::get('/permohonan-form-non-pbj/show/{id}', 'show')->name('permohonan-form-non-pbj.show');
        });
        Route::controller(\App\Http\Controllers\Pengelolakeuangan\PermohonanBelanjaDisposisiController::class)->group(function () {
            Route::get('/permohonan-form-non-pbj-disposisi/{id}', 'index')->name('permohonan-form-non-pbj-disposisi.index');
            Route::get('/permohonan-form-non-pbj-disposisi/show/{id}', 'show')->name('permohonan-form-non-pbj-disposisi.show');
            Route::put('/permohonan-form-non-pbj-disposisi/tanggapi/{id}', 'tanggapi')->name('permohonan-form-non-pbj-disposisi.tanggapi');
        });
        Route::controller(\App\Http\Controllers\Pengelolakeuangan\DistribusiBelanjaController::class)->group(function () {
            Route::get('/distribusi-belanja-form-non-pbj','form_non_pbj')->name('distribusi-belanja.form-non-pbj');
            Route::get('/distribusi-belanja-surat-non-pbj','surat_non_pbj')->name('distribusi-belanja.surat-non-pbj');
        });

    });

});
