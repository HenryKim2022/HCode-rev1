<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Base\Template_Controller;
use App\Http\Controllers\Base\Language_Controller;
use App\Http\Controllers\Landings\LandingPage_Controller;
use App\Http\Controllers\ProfileController;



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


require __DIR__.'/auth.php';
