<?php

use App\Http\Controllers\CommunicationController;
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

    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    // file routes
    Route::resource('file', FileController::class);
    Route::get('/files/download/{id}', [FileController::class, 'downloadFile'])->name('files.download');
    Route::get('/export-files', [FileController::class, 'exportByStatus'])->name('files.export');
    Route::get('/export-all-files', [FileController::class, 'exportAllFiles'])->name('files.export.all');

    // comminication routes
    Route::get('/incoming/communication', [CommunicationController::class, 'incoming']);
    Route::get('/outgoing/communication', [CommunicationController::class, 'outgoing']);
    Route::resource('communication', CommunicationController::class);
    Route::get('/communications/download/{id}', [FileController::class, 'downloadFile'])->name('communication.download');
    Route::get('/exports-communications', [CommunicationController::class, 'exportCommunications'])->name('communication.export');
    Route::get('/export-communications/{status}', [CommunicationController::class, 'exportCommunicationsByStatus'])->name('communication.export.status');




    Route::resource('category', CategoryController::class);
    Route::resource('status', StatusController::class);
    Route::get('/archived/status', [StatusController::class, 'archived'])->name('status.archived');
});
