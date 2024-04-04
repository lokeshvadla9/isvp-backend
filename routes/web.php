<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CorsMiddleware;

Route::get('/', [UserController::class, 'apiStatus']);
Route::prefix('api')->middleware([CorsMiddleware::class])->group(function () {  
    Route::post('/user/createorupdateuser', [UserController::class, 'createOrUpdateUser'])->middleware('web');
    Route::post('/user/login', [UserController::class, 'login'])->middleware('web');
    Route::post('/user/forgotpassword',[UserController::class,'forgotPassword'])->middleware('web');
    Route::post('/user/addsupervisiondetails',[UserController::class,'addSuperviseDetails'])->middleware('web');
    Route::post('/user/getuserdetails',[UserController::class,'getUserData'])->middleware('web');
    Route::get('/user/getsupervisordetails/{studentId}',[UserController::class,'getSupervisorDetails'])->middleware('web');
});
