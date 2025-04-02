<?php

use App\Http\Controllers\Base\Language_Controller;
use App\Http\Controllers\Base\SystemController;
use App\Http\Controllers\Base\Template_Controller;
use App\Http\Controllers\Landings\LandingPage_Controller;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;




Route::middleware('setLocale')->group(function () { // All routes will be applied with the middleware
    // Route for the landing page
    Route::get('/', [LandingPage_Controller::class, 'index']);
    Route::get('/landing', [LandingPage_Controller::class, 'index']);
    Route::get('/temp', [Template_Controller::class, 'template']);
});

Route::get('/lang/{locale}', [Language_Controller::class, 'switchLanguage'])
    ->name('lang.switch');




// Route::get('/', function () {
//     return view('welcome');
// });

// Test routes for various HTTP errors
Route::get('/test-401', function () {
    abort(code: 401); // Unauthorized
});

Route::get('/test-404', function () {
    abort(code: 404); // Not Found
});

Route::get('/test-500', function () {
    abort(code: 500); // Internal Server Error
});

Route::get('/test-503', function () {
    abort(code: 503); // Service Unavailable (Maintenance Mode)
});





Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::group(['middleware'=>'role:superuser,supervisor,moderator','prefix'=>'posts', 'as'=>'posts.'],function () {
    Route::group(['prefix'=>'posts-type', 'as'=>'posts-type.'],function () {
        /* beberapa route di dalam group */
    });
});



// Route::middleware(['auth', 'role:superuser'])->group(function () {
Route::middleware([])->group(function () {
    Route::get('/sys/maintenance', [SystemController::class, 'maintenance'])->name('su.sys');
    Route::post('/sys/toggle-maintenance', [SystemController::class, 'toggleMaintenance'])->name('su.sys.toggle-maintenance');
    Route::post('/sys/update-app-debug', [SystemController::class, 'updateAppDebug'])->name('su.sys.update-app-debug');
});



require __DIR__.'/auth.php';
