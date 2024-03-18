<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\Api\TypeController;
use App\Models\Car;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});

Route::controller(AuthController::class)->prefix('auth')->group(function () {
  Route::post('/register', 'register');
  Route::post('/login', 'login');
  Route::post('/logout', 'logout');
  Route::post('/me', 'me');
  Route::post('/change-password', 'changePassword');
});

Route::controller(TypeController::class)->prefix('types')->group(function () {
  Route::get('/', 'index');
  Route::get('/{type}', 'show');
  Route::post('/', 'store');
  Route::put('/{type}', 'update');
  Route::delete('/{type}', 'destroy');
});

Route::controller(BrandController::class)->prefix('brands')->group(function () {
  Route::get('/', 'index');
  Route::get('/{brand}', 'show');
  Route::post('/', 'store');
  Route::put('/{brand}', 'update');
  Route::delete('/{brand}', 'destroy');
});

Route::controller(CarController::class)->prefix('cars')->group(function () {
  Route::get('/', 'index');
  Route::get('/{car}', 'show');
  Route::post('/', 'store');
  Route::put('/{car}', 'update');
  Route::delete('/{car}', 'destroy');
});
