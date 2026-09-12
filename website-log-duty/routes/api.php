<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DutyLogController;

Route::get('/duty-logs', [DutyLogController::class, 'index']);

Route::post('/duty-logs', [DutyLogController::class, 'store']);

Route::get('/duty-logs/{id}', [DutyLogController::class, 'show']);

