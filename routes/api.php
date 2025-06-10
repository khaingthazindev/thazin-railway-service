<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StationController;

Route::get('station', [StationController::class, 'index']);
Route::get('station/{slug}', [StationController::class, 'show']);