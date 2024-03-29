<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CorsMiddleware;

Route::get('/', [UserController::class, 'apiStatus']);
Route::prefix('api')->middleware([CorsMiddleware::class])->group(function () {  
    Route::post('/user/createorupdateuser', [UserController::class, 'createOrUpdateUser'])->middleware('web');
    Route::post('/user/login', [UserController::class, 'login'])->middleware('web');
    Route::post('/user/forgotpassword',[UserController::class,'forgotPassword'])->middleware('web');
});
