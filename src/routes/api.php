<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;



Route::post("/register", [AuthController::class, 'register']);
Route::post("/login", [AuthController::class, 'login']);


//----------------------------------------------------------

Route::get("/", [HomeController::class, 'index']);
Route::get("/show/{id}", [HomeController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    
    Route::prefix('admin')->group(function () {
        Route::post('/store', [HomeController::class,'store']);
        Route::put('/update/{id}', [HomeController::class,'update']);
        Route::delete('/delete/{id}', [HomeController::class,'delete']);
        Route::get('/getusers', [AuthController::class,'getAllUsers']);
    });

    Route::prefix('user')->group(function () {
        Route::get('/data', [AuthController::class,'getUserData']);
    });
});
