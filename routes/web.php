<?php

// use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BobotController;
use App\Http\Controllers\DampakController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KemungkinanController;
use App\Http\Controllers\ResikoController;
use App\Http\Controllers\ResikoDivisiController;
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

Route::get('/', [ResikoController::class, 'index_dash'])->name('dashboard')->middleware('auth');
Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'authenticating'])->middleware('guest');
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth');

$middleware = ['auth'];
if (env('DEVELOPMENT', false)) {
    $middleware[] = 'check.permission';
}
Route::middleware($middleware)->group(function () {

    // Kemungkinan
    Route::get('/input-kemungkinan', [KemungkinanController::class, 'index'])->name('input-kemungkinan');
    Route::post('/input-kemungkinan-add', [KemungkinanController::class, 'store'])->name('input-kemungkinan-add');
    Route::get('/input-kemungkinan-edit', [KemungkinanController::class, 'edit'])->name('input-kemungkinan-edit');
    Route::match(['put', 'patch'], '/input-kemungkinan/{id}', [KemungkinanController::class, 'update'])->name('input-kemungkinan-update');
    Route::get('/input-kemungkinan-delete/{id}', [KemungkinanController::class, 'destroy'])->name('input-kemungkinan-delete');

    // Dampak
    Route::get('/input-dampak', [DampakController::class, 'index'])->name('input-dampak');
    Route::post('/input-dampak-add', [DampakController::class, 'store'])->name('input-dampak-add');
    Route::get('/input-dampak-edit', [DampakController::class, 'edit'])->name('input-dampak-edit');
    Route::match(['put', 'patch'], '/input-dampak/{id}', [DampakController::class, 'update'])->name('input-dampak-update');
    Route::get('/input-dampak-delete/{id}', [DampakController::class, 'destroy'])->name('input-dampak-delete');

    // Divisi
    Route::get('/input-divisi', [DivisiController::class, 'index'])->name('input-divisi');
    Route::post('/input-divisi-add', [DivisiController::class, 'store'])->name('input-divisi-add');
    Route::get('/input-divisi-edit', [DivisiController::class, 'edit'])->name('input-divisi-edit');
    Route::match(['put', 'patch'], '/input-divisi/{id}', [DivisiController::class, 'update'])->name('input-divisi-update');
    Route::get('/input-divisi-delete/{id}', [DivisiController::class, 'destroy'])->name('input-divisi-delete');

    // Kategori
    Route::get('/input-kategori', [KategoriController::class, 'index'])->name('input-kategori');
    Route::post('/input-kategori-add', [KategoriController::class, 'store'])->name('input-kategori-add');
    Route::get('/input-kategori-edit', [KategoriController::class, 'edit'])->name('input-kategori-edit');
    Route::match(['put', 'patch'], '/input-kategori/{id}', [KategoriController::class, 'update'])->name('input-kategori-update');
    Route::get('/input-kategori-delete/{id}', [KategoriController::class, 'destroy'])->name('input-kategori-delete');

    // Bobot
    Route::get('/input-bobot', [BobotController::class, 'index'])->name('input-bobot');
    Route::post('/input-bobot-add', [BobotController::class, 'store'])->name('input-bobot-add');
    Route::get('/input-bobot-edit', [BobotController::class, 'edit'])->name('input-bobot-edit');
    Route::match(['put', 'patch'], '/input-bobot/{id}', [BobotController::class, 'update'])->name('input-bobot-update');
    Route::get('/input-bobot-delete/{id}', [BobotController::class, 'destroy'])->name('input-bobot-delete');

    // Approval
    Route::get('/input-approval', [ApprovalController::class, 'index'])->name('input-approval');
    Route::post('/input-approval-add', [ApprovalController::class, 'store'])->name('input-approval-add');
    Route::get('/input-approval-edit', [ApprovalController::class, 'edit'])->name('input-approval-edit');
    Route::match(['put', 'patch'], '/input-approval-update/{id}', [ApprovalController::class, 'update'])->name('input-approval-update');
    Route::get('/input-approval-delete/{id}', [ApprovalController::class, 'destroy'])->name('input-approval-delete');

    Route::get('/input-approval-mr', [ApprovalController::class, 'index_mr'])->name('input-approval-mr');

    // Dashboard
    Route::get('/dashboard', [ResikoController::class, 'index_dash'])->name('dashboard');
    Route::get('/chart-divisi/{tahun?}', [ResikoController::class, 'chartDivisi'])->name('chart.divisi');
    Route::get('/chart/kategori-heatmap', [ResikoController::class, 'rataRataInhernKategori'])->name('chart.kategori.heatmap');
    Route::get('/dashboard-list-divisi', [ResikoController::class, 'index_dash_divisi'])->name('dashboard-list-divisi');
    Route::get('/dashboard-divisi', [ResikoController::class, 'index_divisi_dash'])->name('dashboard-divisi');

    //print ke word
    Route::post('/laporan-export-docx', [ResikoController::class, 'exportDocx'])->name('laporan.export.docx');

    // Risk Register @masing-masing divisi
    Route::get('/input-risk', [ResikoController::class, 'index'])->name('input-risk');
    // 1. Identifikasi
    // 1.1 Sasaran
    Route::post('/input-sasaran-add', [ResikoController::class, 'store_sasaran'])->name('input-sasaran-add');
    Route::get('/input-sasaran-edit', [ResikoController::class, 'edit_sasaran'])->name('input-sasaran-edit');
    Route::match(['put', 'patch'], '/input-sasaran-update/{id}', [ResikoController::class, 'update_sasaran'])->name('input-sasaran-update');
    Route::get('/input-sasaran-delete/{id}', [ResikoController::class, 'destroy_sasaran'])->name('input-sasaran-delete');

    // 1.2 Tujuan
    Route::post('/input-tujuan-add', [ResikoController::class, 'store_tujuan'])->name('input-tujuan-add');
    Route::get('/input-tujuan-edit', [ResikoController::class, 'edit_tujuan'])->name('input-tujuan-edit');
    Route::match(['put', 'patch'], '/input-tujuan-update/{id}', [ResikoController::class, 'update_tujuan'])->name('input-tujuan-update');
    Route::get('/input-tujuan-delete/{id}', [ResikoController::class, 'destroy_tujuan'])->name('input-tujuan-delete');
    Route::get('/get-sasaran', [ResikoController::class, 'getSasaranByTahun']);

    // 1.3 Event
    Route::post('/input-event-add', [ResikoController::class, 'store_event'])->name('input-event-add');
    Route::get('/input-event-edit', [ResikoController::class, 'edit_event'])->name('input-event-edit');
    Route::match(['put', 'patch'], '/input-event-update/{id}', [ResikoController::class, 'update_event'])->name('input-event-update');
    Route::get('/input-event-delete/{id}', [ResikoController::class, 'destroy_event'])->name('input-event-delete');
    Route::get('/get-tujuan', [ResikoController::class, 'getTujuanByTahun']);

    // 1.4 Resiko
    Route::post('/input-resiko-add', [ResikoController::class, 'store_resiko'])->name('input-resiko-add');
    Route::get('/input-resiko-edit', [ResikoController::class, 'edit_resiko'])->name('input-resiko-edit');
    Route::match(['put', 'patch'], '/input-resiko-update/{id}', [ResikoController::class, 'update_resiko'])->name('input-resiko-update');
    Route::get('/input-resiko-delete/{id}', [ResikoController::class, 'destroy_resiko'])->name('input-resiko-delete');
    Route::get('/get-event', [ResikoController::class, 'getEventByTahun'])->name('event.byYear');

    // 2. Pengukuran
    Route::post('/input-pengukuran-add', [ResikoController::class, 'store_pengukuran'])->name('input-pengukuran-add');
    Route::get('/input-pengukuran-edit', [ResikoController::class, 'edit_pengukuran'])->name('input-pengukuran-edit');
    Route::match(['put', 'patch'], '/input-pengukuran-update/{id}', [ResikoController::class, 'update_pengukuran'])->name('input-pengukuran-update');
    Route::get('/input-pengukuran-delete/{id}', [ResikoController::class, 'destroy_pengukuran'])->name('input-pengukuran-delete');

    // 3. Pengendalian
    Route::post('/input-pengendalian-add', [ResikoController::class, 'store_pengendalian'])->name('input-pengendalian-add');
    Route::get('/input-pengendalian-edit', [ResikoController::class, 'edit_pengendalian'])->name('input-pengendalian-edit');
    Route::match(['put', 'patch'], '/input-pengendalian-update/{id}', [ResikoController::class, 'update_pengendalian'])->name('input-pengendalian-update');
    Route::get('/input-pengendalian-delete/{id}', [ResikoController::class, 'destroy_pengendalian'])->name('input-pengendalian-delete');

    // 4. Monitoring Divisi
    Route::post('/input-monitoring-add', [ResikoController::class, 'store_monitoring'])->name('input-monitoring-add');
    Route::get('/input-monitoring-edit', [ResikoController::class, 'edit_monitoring'])->name('input-monitoring-edit');
    Route::match(['put', 'patch'], '/input-monitoring-update/{id}', [ResikoController::class, 'update_monitoring'])->name('input-monitoring-update');
    Route::get('/input-monitoring-delete/{id}', [ResikoController::class, 'destroy_monitoring'])->name('input-monitoring-delete');
});
