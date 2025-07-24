<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\CelebrityAuthController;

Route::prefix('celebrity')->name('celebrity.')->group(function () {
    Route::get('login', [CelebrityAuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [CelebrityAuthController::class, 'login']);
    Route::get('register', [CelebrityAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [CelebrityAuthController::class, 'register']);
    Route::post('logout', [CelebrityAuthController::class, 'logout'])->name('logout');

    Route::get('forgot-password', [CelebrityAuthController::class, 'showForgotForm'])->name('forgot-password');
    Route::post('forgot-password', [CelebrityAuthController::class, 'sendOtpForReset'])->name('forgot-password.send-otp');

    Route::get('verify-otp-reset', [CelebrityAuthController::class, 'showOtpResetForm'])->name('otp-reset.form');
    Route::post('verify-otp-reset', [CelebrityAuthController::class, 'verifyOtpForReset'])->name('otp-reset.verify');

    Route::get('reset-password', [CelebrityAuthController::class, 'showResetPasswordForm'])->name('reset-password.form');
    Route::post('reset-password', [CelebrityAuthController::class, 'resetPassword'])->name('reset-password');

    // صفحة إدخال الـ OTP
    Route::get('otp', [CelebrityAuthController::class, 'showOtpForm'])->name('otp.form');
    Route::post('/resend-otp', [CelebrityAuthController::class, 'resendOtp'])
        ->name('resendOtp');

    // عملية التحقق من الـ OTP
    Route::post('verify-otp', [CelebrityAuthController::class, 'verifyOtp'])->name('verify-otp');



});
Route::middleware('auth:celebrity')->prefix('celebrity')->name('celebrity.')->group(function () {
    Route::get('dashboard', [MainController::class, 'dashboard'])->name('dashboard');
    Route::get('profile', [MainController::class, 'profile'])->name('profile');
});



