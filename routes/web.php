<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
use App\Http\Controllers\HealthcareProviderController;

Route::get('/', [HealthcareProviderController::class, 'index']);
Route::post('/healthcare-providers', [HealthcareProviderController::class, 'store']);
Route::post('/healthcare-providers/bulk', [HealthcareProviderController::class, 'bulkStore']);
