<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountingExportsController;

Route::get('/', [AccountingExportsController::class, 'index']);
Route::post('/upload', [AccountingExportsController::class, 'storeFileDetails'])->name('upload');;
Route::get('/batch', [AccountingExportsController::class, 'batch'])->name('batch');
