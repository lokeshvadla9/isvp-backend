<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\QueryController;
use App\Http\Controllers\CalenderController;
use App\Http\Controllers\RecommendationController;
use App\Http\Middleware\CorsMiddleware;

Route::get('/', [UserController::class, 'apiStatus']);
Route::prefix('api')->middleware([CorsMiddleware::class])->group(function () {  
    Route::post('/user/createorupdateuser', [UserController::class, 'createOrUpdateUser'])->middleware('web');
    Route::post('/user/login', [UserController::class, 'login'])->middleware('web');
    Route::post('/user/forgotpassword',[UserController::class,'forgotPassword'])->middleware('web');
    Route::post('/user/addsupervisiondetails',[UserController::class,'addSuperviseDetails'])->middleware('web');
    Route::post('/user/getuserdetails',[UserController::class,'getUserData'])->middleware('web');
    Route::get('/user/getsupervisordetails/{studentId}',[UserController::class,'getSupervisorDetails'])->middleware('web');
    Route::post('/user/getstudentdetailsbyprofessor',[UserController::class,'getStudentsByProfessorId'])->middleware('web');
    Route::post('/task/createorupdatetask',[TaskController::class,'createOrUpdateTaskAndAssignStudents'])->middleware('web');
    Route::post('/task/gettasks',[TaskController::class,'getTasks'])->middleware('web');
    Route::post('/task/submitweeklyreport',[TaskController::class,'insertWeeklyReport'])->middleware('web');
    Route::post('/task/getweeklyreports',[TaskController::class,'getWeeklyReports'])->middleware('web');
    Route::post('/task/createorupdatecomment',[TaskController::class,'createOrUpdateComment'])->middleware('web');
    Route::get('/task/getcommentbytask/{taskId}',[TaskController::class,'getCommentsByTask'])->middleware('web');
    Route::post('/task/calculateplaig',[TaskController::class,'calculatePlaig'])->middleware('web');
    Route::post('/task/createorupdatefeedback',[TaskController::class,'createOrUpdateFeedback'])->middleware('web');
    Route::post('/query/createquery',[QueryController::class,'createQuery'])->middleware('web');
    Route::get('/query/getqueries',[QueryController::class,'getQueries'])->middleware('web');
    Route::post('/query/updatequerystatus',[QueryController::class,'updateQueryStatus'])->middleware('web');
    Route::get('/calender/getreminders/{userId}',[CalenderController::class,'getReminders'])->middleware('web');
    Route::post('/calender/createreminder',[CalenderController::class,'createReminder'])->middleware('web');
    Route::post('/recommendation/createorupdaterecommendation',[RecommendationController::class,'createOrUpdateRecommendation'])->middleware('web');   
    Route::post('/recommendation/downloadletter',[RecommendationController::class,'downloadRecommendationLetter'])->middleware('web');
    Route::post('/recommendation/getrecommendationrequests',[RecommendationController::class,'getRecommendationRequests'])->middleware('web');  
});
