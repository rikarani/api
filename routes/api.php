<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckController;

Route::prefix('/cek-ign')->group(function () {
    Route::get('/mlbb', [CheckController::class, 'mlbb']);
    Route::get('/genshin', [CheckController::class, 'genshin']);
});
