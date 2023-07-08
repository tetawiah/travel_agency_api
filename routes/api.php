<?php

use App\Http\Controllers\API\V1\TourController;
use App\Http\Controllers\API\V1\TravelController;
use App\Http\Controllers\API\v1\Admin;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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


Route::post('login',LoginController::class);
Route::prefix('v1')->group(function () {
    Route::get('/travels',[TravelController::class,'index']);
    Route::get('/travels/{travel:slug}/tours',[TourController::class,'index']);
    Route::prefix('admin')->middleware(['auth:sanctum','role:admin'])->group(function () {
        Route::post('travels',[Admin\TravelController::class,'store']);
        Route::post('travels/{travel:slug}/tours',[Admin\TourController::class,'store']);
    });
});
