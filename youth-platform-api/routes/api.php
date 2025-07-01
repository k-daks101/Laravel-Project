<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OpportunityController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// 🟢 Registration & Login
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// 🟢 Publicly accessible opportunities (read-only)
Route::get('/opportunities', [OpportunityController::class, 'index']);
Route::get('/opportunities/{id}', [OpportunityController::class, 'show']);


/*
|--------------------------------------------------------------------------
| Protected Routes (Sanctum Authenticated)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {
    
    // 🔒 Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // 🔒 Get authenticated user
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // 🔒 Admin-only: Manage opportunities
    Route::post('/opportunities', [OpportunityController::class, 'store']);
    Route::put('/opportunities/{id}', [OpportunityController::class, 'update']);
    Route::delete('/opportunities/{id}', [OpportunityController::class, 'destroy']);
});
