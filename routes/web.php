<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\File\CategoryController;
use App\Http\Controllers\File\FileController;
use App\Http\Controllers\File\StatusController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::middleware('auth')->group(function () {
    //     Route::get('/dashboard', function () {
    //         return view('dashboard');
    //     })->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::resource('file', FileController::class);
    Route::get('/files/download/{id}', [FileController::class, 'downloadFile'])->name('files.download');

    Route::resource('category', CategoryController::class);
    Route::resource('status', StatusController::class);
});
