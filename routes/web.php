<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DisposisiController;
use App\Http\Controllers\DisposisiDetailController;
use App\Http\Controllers\GolonganController;
use App\Http\Controllers\InputBiayaController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\LampiranController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PermohonanSuratPerjalananDinasController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\SuratPerjalananDinasController;
use App\Http\Controllers\SuratPerjalananDinasDetailController;
use App\Http\Controllers\SuratPerjalananDinasDetailSupirController;
use App\Http\Controllers\SuratPertanggungJawabanController;
use App\Http\Controllers\SuratPertanggungJawabanDetailController;
use App\Http\Controllers\TTEController;
use App\Http\Controllers\UangMukaController;
use App\Http\Controllers\UserController;
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
    Route::resource('surat-perjalanan-dinas-supir', SuratPerjalananDinasDetailSupirController::class);

    Route::resource('input-biaya', InputBiayaController::class);
    Route::resource('uang-muka', UangMukaController::class);
    Route::get('surat-pertanggung-jawaban/verifikasi', [SuratPertanggungJawabanController::class, 'verifikasi'])->name('surat-pertanggung-jawaban.verifikasi');
    Route::resource('surat-pertanggung-jawaban', SuratPertanggungJawabanController::class);
    Route::resource('surat-pertanggung-jawaban-detail', SuratPertanggungJawabanDetailController::class);
});
