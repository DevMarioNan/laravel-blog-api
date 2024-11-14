<?php

use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//posts routing
Route::apiResource('/posts',PostController::class);
Route::get('/posts/{post}/user',[PostController::class,'user']);
Route::get('/posts/{post}/comments',[PostController::class,'comments']);

//comments routing
Route::apiResource('/comments',CommentController::class);
Route::get('/comments/{id}/user',[CommentController::class,'user']);
Route::get('/comments/{id}/post',[CommentController::class,'post']);

//Authentication routing
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/logout',[AuthController::class,'logout'])->middleware('auth:sanctum');