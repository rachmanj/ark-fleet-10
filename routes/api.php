<?php

use App\Http\Controllers\Api\EquipmentApiController;
use App\Http\Controllers\Api\ProjectApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('equipments/by-unit/{unit_no}', [EquipmentApiController::class, 'showByUnitNo']);
Route::get('equipments', [EquipmentApiController::class, 'index']);
Route::get('projects', [ProjectApiController::class, 'index']);
