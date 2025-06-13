<?php

/*
|--------------------------------------------------------------------------
| File: /routes/web.php
| Deskripsi: Rute untuk seluruh aplikasi, dengan grup khusus untuk admin.
|--------------------------------------------------------------------------
*/

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\ContentController;
use App\Http\Controllers\Student\PackageController as StudentPackageController;
use App\Http\Controllers\Student\PaymentController;
use App\Http\Controllers\Student\StudentExamController;

// Halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Rute Bawaan Breeze untuk profil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| RUTE PANEL ADMIN
| Semua rute di sini memerlukan login dan role 'admin'.
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CRUD Resources
    Route::resource('categories', CategoryController::class);
    Route::resource('sub-categories', SubCategoryController::class);
    Route::resource('subjects', SubjectController::class);
    Route::resource('modules', ModuleController::class);
    Route::resource('videos', VideoController::class);
    Route::resource('packages', PackageController::class);
    
    // Nested resource untuk Soal di dalam Ujian
    // Contoh URL: /admin/exams/1/questions/create
    Route::resource('exams', ExamController::class);
    Route::resource('exams.questions', QuestionController::class)->shallow();
});

/*|--------------------------------------------------------------------------
| RUTE PANEL SISWA
| Semua rute di sini memerlukan login dan role 'siswa'.
|--------------------------------------------------------------------------
*/  

Route::middleware(['auth', 'verified', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');

    // Paket & Pembayaran
    Route::get('/paket', [StudentPackageController::class, 'index'])->name('packages.index');
    Route::post('/paket/beli', [PaymentController::class, 'checkout'])->name('packages.checkout');
    Route::post('/payment/process', [PaymentController::class, 'process'])->name('payment.process');
    Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');

    // Konten Belajar (perlu middleware langganan aktif)
    Route::middleware('check-subscription')->group(function () {
        Route::get('/kategori/{category:slug}', [ContentController::class, 'showCategory'])->name('content.category');
        Route::get('/mapel/{subject:slug}', [ContentController::class, 'showSubject'])->name('content.subject');
        Route::get('/modul/{module}', [ContentController::class, 'showModule'])->name('content.module');
        Route::get('/video/{video}', [ContentController::class, 'showVideo'])->name('content.video');

        // Ujian
        Route::get('/ujian/{exam}', [StudentExamController::class, 'show'])->name('exam.show');
        Route::post('/ujian/{exam}/start', [StudentExamController::class, 'start'])->name('exam.start');
        Route::get('/ujian/simulasi/{userExamAttempt}', [StudentExamController::class, 'simulation'])->name('exam.simulation');
        Route::post('/ujian/simulasi/{userExamAttempt}/submit', [StudentExamController::class, 'submit'])->name('exam.submit');
        Route::get('/ujian/hasil/{userExamAttempt}', [StudentExamController::class, 'result'])->name('exam.result');
    });
});

// Callback dari Midtrans (tidak perlu login)
Route::post('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');

require __DIR__.'/auth.php';