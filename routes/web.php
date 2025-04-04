<?php

use App\Http\Controllers\Base\Language_Controller;
use App\Http\Controllers\Base\SystemController;
use App\Http\Controllers\Base\Template_Controller;
use App\Http\Controllers\Landings\LandingPage_Controller;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;

use Illuminate\Support\Facades\Route;

// Locale Middleware Group
Route::group(['middleware' => ['setLocale']], function () {
    Route::get('/', [LandingPage_Controller::class, 'index'])->name('root');
    Route::get('/landing', [LandingPage_Controller::class, 'index'])->name('landing.root');
    Route::get('/temp', [Template_Controller::class, 'template']);
});

// Language Switching Route
Route::get('/lang/{locale}', [Language_Controller::class, 'switchLanguage'])
    ->name('lang.switch');


Route::middleware(['setLocale'])->group(function () {
    // System Settings Routes
    Route::get('/system/settings', [SystemController::class, 'index'])->name('index.syssettings');
    Route::post('/system/update-maintenance-exclusion', [SystemController::class, 'update'])->name('syssettings.exclusionupdate');
    Route::post('/system/toggle-maintenance', [SystemController::class, 'toggleMaintenance'])->name('syssettings.togglemaintenance');
    Route::post('/system/toggle-debug', [SystemController::class, 'toggleDebug'])->name('syssettings.toggledebug');
    Route::post('/system/save-typed-ip', [SystemController::class, 'saveTypedIp'])->name('syssettings.savetyped.ip');
    Route::post('/system/save-typed-uri', [SystemController::class, 'saveTypedUri'])->name('syssettings.savetyped.uri');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard Route
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


// Role-Based Middleware Group
Route::group(['middleware' => 'role:superuser,supervisor,moderator', 'prefix' => 'posts', 'as' => 'posts.'], function () {
    Route::group(['prefix' => 'posts-type', 'as' => 'posts-type.'], function () {
        /* Define specific routes here */
    });
});

// Test Routes (Only for Development)
if (app()->environment('local')) {
    Route::get('/test-401', function () {
        abort(401); // Unauthorized
    });

    Route::get('/test-404', function () {
        abort(404); // Not Found
    });

    Route::get('/test-500', function () {
        abort(500); // Internal Server Error
    });

    Route::get('/test-503', function () {
        abort(503); // Service Unavailable (Maintenance Mode)
    });
}





// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->name('password.update');
});

// Email Verification Routes
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', [EmailVerificationPromptController::class, 'create'])
        ->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, 'verify'])
        ->middleware('signed')
        ->name('verification.verify');

    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->name('verification.send');
});

// Confirm Password Route
Route::middleware('auth')->group(function () {
    Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store']);
});

// Logout Route
Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');





// Include Authentication Routes
require __DIR__ . '/auth.php';
