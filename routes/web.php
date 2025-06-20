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
use App\Http\Controllers\Admin\TryoutController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\ContentController;
use App\Http\Controllers\Student\PackageController as StudentPackageController;
use App\Http\Controllers\Student\PaymentController;
use App\Http\Controllers\Student\StudentExamController;
use App\Http\Controllers\Student\ProfileController as StudentProfileController;
use App\Http\Controllers\Student\StudentTryoutController;




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

    // Tryout
    Route::get('tryout', [TryoutController::class, 'index'])->name('tryout.index');
    Route::get('tryout/create', [TryoutController::class, 'create'])->name('tryout.create');
    Route::post('tryout', [TryoutController::class, 'store'])->name('tryout.store');
    Route::get('tryout/{tryoutPackage}', [TryoutController::class, 'show'])->name('tryout.show');
    Route::delete('tryout/{tryoutPackage}', [TryoutController::class, 'destroy'])->name('tryout.destroy');

    Route::get('tryout/{tryoutPackage}/subtest/create', [TryoutController::class, 'createSubtest'])->name('tryout.subtest.create');
    Route::post('tryout/{tryoutPackage}/subtest', [TryoutController::class, 'storeSubtest'])->name('tryout.subtest.store');
    Route::delete('tryout/{tryoutPackage}/subtest/{subtest}', [TryoutController::class, 'destroySubtest'])->name('tryout.subtest.destroy');

    Route::get('subtest/{subtest}/question/create', [TryoutController::class, 'createQuestion'])->name('tryout.question.create');
    Route::post('subtest/{subtest}/question', [TryoutController::class, 'storeQuestion'])->name('tryout.question.store');
    Route::delete('subtest/{subtest}/question/{tryoutQuestion}', [TryoutController::class, 'destroyQuestion'])->name('tryout.question.destroy');

    Route::get('question/{tryoutQuestion}/answer/create', [TryoutController::class, 'createAnswer'])->name('tryout.answer.create');
    Route::post('question/{tryoutQuestion}/answer', [TryoutController::class, 'storeAnswer'])->name('tryout.answer.store');
    Route::delete('question/{tryoutQuestion}/answer/{tryoutAnswer}', [TryoutController::class, 'destroyAnswer'])->name('tryout.answer.destroy');
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

    // Profil Siswa
    Route::get('/profil', [StudentProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profil', [StudentProfileController::class, 'update'])->name('profile.update');

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
        // Tryout UTBK
        // Tryout
        Route::get('/tryout', [StudentTryoutController::class, 'packages'])->name('tryout.packages');
        Route::get('/tryout/{packageId}/subtests', [StudentTryoutController::class, 'subtests'])->name('tryout.subtests');
        Route::get('/subtest/{subtestId}/questions', [StudentTryoutController::class, 'questions'])->name('tryout.questions');
        Route::post('/subtest/{subtestId}/submit', [StudentTryoutController::class, 'submitSubtest'])->name('tryout.submitSubtest');
        Route::post('/tryout/{packageId}/submit-package', [StudentTryoutController::class, 'submitPackage'])->name('tryout.submitPackage');
        Route::get('/tryout/{packageId}/result', [StudentTryoutController::class, 'result'])->name('tryout.result');
    });
});

// Callback dari Midtrans (tidak perlu login)
Route::post('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
Route::get('/test-ngrok', function () {
    return 'Koneksi Ngrok Berhasil!';
});
require __DIR__ . '/auth.php';