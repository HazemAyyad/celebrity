<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\CouponsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\CelebrityAuthController;

Route::get('/link-storage', function () {
    $target = storage_path('app/public');
    $link = public_path('storage');

    if (file_exists($link)) {
        return '🔁 Already linked.';
    }

    symlink($target, $link);

    return '✅ The [public/storage] directory has been linked.';
});

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
Route::middleware('celebrity.auth')->prefix('celebrity')->name('celebrity.')->group(function () {
    Route::get('dashboard', [MainController::class, 'dashboard'])->name('dashboard');
    Route::get('profile', [MainController::class, 'profile'])->name('profile');
    Route::get('edit-profile', [MainController::class, 'edit_profile'])->name('edit-profile');
    Route::post('save-profile/{id}', [MainController::class, 'save_profile'])->name('save-profile');

    Route::get('my-quotation', [MainController::class, 'myQuotation'])->name('my-quotation');

    Route::get('coupons', [CouponsController::class, 'index'])->name('coupons.index');
    Route::get('get-coupons', [CouponsController::class, 'get_coupons'])->name('get-coupons');
});



