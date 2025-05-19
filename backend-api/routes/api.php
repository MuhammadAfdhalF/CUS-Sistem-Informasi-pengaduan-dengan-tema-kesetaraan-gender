<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dosenController;
use App\Http\Controllers\mahasiswaController;
use App\Http\Controllers\pelaporanController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::resource('/dosen', dosenController::class);
Route::resource('/mahasiswa', mahasiswaController::class);
Route::resource('/pelaporan', pelaporanController::class);