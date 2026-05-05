<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\StudentController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\AnnouncementController;
use App\Http\Controllers\Backend\ReportController;
use App\Http\Controllers\Backend\SubjectController;

use App\Http\Controllers\Auth\AuthController;

use App\Http\Controllers\FrontendController;

Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::post('/cek-kelulusan', [FrontendController::class, 'cek'])->name('cek.kelulusan');
Route::get('/cek-kelulusan', function() { return redirect()->route('home'); });
Route::get('/pengumuman', [FrontendController::class, 'pengumuman'])->name('pengumuman');
Route::get('/kontak', [FrontendController::class, 'contact'])->name('contact');
Route::get('/download-skl/{id}', [FrontendController::class, 'downloadSkl'])->name('download.skl');
Route::get('/verifikasi/{nomor_peserta}', [FrontendController::class, 'verify'])->name('verify.skl');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/profile', [\App\Http\Controllers\Backend\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\Backend\ProfileController::class, 'update'])->name('profile.update');
    Route::resource('users', \App\Http\Controllers\Backend\UserController::class)->middleware('role:admin');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/students/template', [StudentController::class, 'template'])->name('students.template');
    Route::post('/students/import', [StudentController::class, 'import'])->name('students.import');
    Route::post('/students/bulk-delete', [StudentController::class, 'bulkDelete'])->name('students.bulk-delete');
    Route::get('/students/export', [StudentController::class, 'exportExcel'])->name('students.export');
    Route::post('/students/bulk-print', [StudentController::class, 'bulkPrintPdf'])->name('students.bulk-print');
    Route::get('/students/{id}/print', [StudentController::class, 'printPdf'])->name('students.print');
    Route::resource('students', StudentController::class);
    
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
    
    Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
    Route::post('/announcements', [AnnouncementController::class, 'update'])->name('announcements.update');
    
    Route::get('/landingpage', [\App\Http\Controllers\Backend\LandingPageController::class, 'index'])->name('landingpage.index');
    Route::post('/landingpage', [\App\Http\Controllers\Backend\LandingPageController::class, 'update'])->name('landingpage.update');
    
    Route::get('/reports/logs', [ReportController::class, 'logs'])->name('reports.logs');
    Route::post('/reports/logs/clear', [ReportController::class, 'clearLogs'])->name('reports.logs.clear');

    Route::get('/subjects/template', [SubjectController::class, 'template'])->name('subjects.template');
    Route::post('/subjects/import', [SubjectController::class, 'import'])->name('subjects.import');
    Route::post('/subjects/bulk-delete', [SubjectController::class, 'bulkDestroy'])->name('subjects.bulk-delete');
    Route::resource('subjects', SubjectController::class);
});
