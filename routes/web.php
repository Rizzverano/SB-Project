<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LegislativeController;
use App\Http\Controllers\DirectoryController;
use App\Models\LegislativeRecord;

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

Route::get('/', function () {
    return view('welcome');
})->name('home');

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
