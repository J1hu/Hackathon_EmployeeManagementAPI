<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/management/employee', [UserController::class, 'index']);
Route::get('/management/employee/{employeeId}', [UserController::class, 'get']);
Route::post('/management/employee', [UserController::class, 'store']);
Route::put('/management/employee/{employeeId}', [UserController::class, 'update']);
Route::delete('/management/employee/{employeeId}', [UserController::class, 'delete']);
