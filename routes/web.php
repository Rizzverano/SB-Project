<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LegislativeController;
use App\Http\Controllers\DirectoryController;
use App\Models\LegislativeRecord;
use App\Http\Controllers\LoginChallengeController;
use App\Http\Controllers\LoginOtpController;

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


Route::get('/', [DirectoryController::class, 'welcome'])->name('home');

Route::get('/legislative_index', [LegislativeController::class, 'index'])
    ->name('legislative_index');

Route::post('/restore-record/{id}', function ($id) {
    $record = LegislativeRecord::onlyTrashed()->findOrFail($id);
    $record->restore();

    return back()->with('success', 'Record restored successfully!');
})->name('restore.record');

Route::get('/about', [DirectoryController::class, 'about'])
    ->name('about');


Route::get('/contact', [DirectoryController::class, 'contact'])
    ->name('contact');

Route::post('/contact', [DirectoryController::class, 'storeContact'])
    ->name('contact.store')
    ->middleware('throttle:5,1')
    ->middleware('block.spam'); // 5 requests per minute

Route::get('/gallery', [DirectoryController::class, 'gallery'])
    ->name('gallery');



Route::middleware('nocache')->group(function () {
    Route::get('/admin/login-challenge', [LoginChallengeController::class, 'show'])
        ->name('login.challenge');

    Route::post('/admin/login-challenge', [LoginChallengeController::class, 'verify'])
        ->name('login.challenge.verify');

    Route::get('/admin/login-otp', [LoginOtpController::class, 'show'])
        ->name('login.otp');

    Route::post('/admin/login-otp', [LoginOtpController::class, 'verify'])
        ->name('login.otp.verify');
});

Route::get('/legislative-process', [DirectoryController::class, 'legislativeProcess'])
    ->name('legislative.process');

Route::get('/sb-members', [DirectoryController::class, 'sbmember'])
    ->name('sb.members');

Route::get('/sb-info', [DirectoryController::class, 'sbinfo'])
    ->name('sb.info');

Route::get('/sb-sec', [DirectoryController::class, 'sbsec'])
    ->name('sb.sec');
