<?php

use App\Http\Controllers\AuthenticationController;
use Illuminate\Support\Facades\Route;


Route::controller(AuthenticationController::class)->group(function () {
    Route::post('/register', 'register')->name('register');
    Route::post('/login', 'login')->name('login');
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');

    //User
    Route::apiResource('users', \App\Http\Controllers\UserController::class);

    //Category
    Route::apiResource('categories', \App\Http\Controllers\CategoryController::class);

    //Tag
    Route::apiResource('tags', \App\Http\Controllers\TagController::class);

    //Post
    Route::apiResource('posts', \App\Http\Controllers\PostController::class);

    //Comment
    Route::apiResource('comments', \App\Http\Controllers\CommentController::class)->except(['index', 'show']);

});
