<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SubTaskController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {

    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:users')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
    });
});


Route::middleware('auth:users')->group(function () {

    ## Users Route
    Route::resource('users', UserController::class);

    ## Tasks Route
    Route::resource('tasks', TaskController::class);

    ## SubTasks Route
    Route::resource('subtasks', SubTaskController::class);
});
