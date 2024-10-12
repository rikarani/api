<?php

use Illuminate\Support\Facades\Route;
use App\http\Controllers\CheckController;

Route::prefix('/cek-ign')->group(function () {
    Route::get('/mlbb', [CheckController::class, 'mlbb']);
});
