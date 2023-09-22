<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
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

Route::middleware('auth:sanctum')->get('user', function (Request $request) {
    // dd($request);
    return $request->user();
});

Route::post('register', [RegisteredUserController::class, 'store']);
Route::post('login', [AuthenticatedSessionController::class, 'store']);
Route::middleware('auth:sanctum')->post('logout', [AuthenticatedSessionController::class, 'destroy']);

Route::middleware('auth:sanctum')->post('categories/create', [CategoryController::class, 'store']);
Route::middleware('auth:sanctum')->get('categories/{category}', [CategoryController::class, 'show']);
Route::middleware('auth:sanctum')->put('categories/{category}', [CategoryController::class, 'update']);
Route::middleware('auth:sanctum')->delete('categories/{category}', [CategoryController::class, 'destroy']);
Route::get('categories',[CategoryController::class, 'index']);

Route::middleware('auth:sanctum')->post('posts', [PostController::class, 'store']);
Route::middleware('auth:sanctum')->get('posts/{post}',[PostController::class, 'show']);
Route::middleware('auth:sanctum')->put('posts/{post}', [PostController::class, 'update']);
Route::middleware('auth:sanctum')->delete('posts/{post}', [PostController::class, 'destroy']);
Route::middleware('auth:sanctum')->get('dashboard-posts',[PostController::class, 'index']);
Route::middleware('auth:sanctum')->get('calendar-post',[PostController::class, 'calendarPost']);

