<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TechnologyController;
use App\Http\Controllers\Api\ImageController;

/*
|--------------------------------------------------------------------------
| Routes d'authentification (publiques)
|--------------------------------------------------------------------------
*/
Route::post('/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Routes publiques - Projects
|--------------------------------------------------------------------------
*/
Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/projects/featured', [ProjectController::class, 'featured']);
Route::get('/projects/{id}', [ProjectController::class, 'show']);

/*
|--------------------------------------------------------------------------
| Routes publiques - Technologies
|--------------------------------------------------------------------------
*/
Route::get('/technologies', [TechnologyController::class, 'index']);
Route::get('/technologies/{id}', [TechnologyController::class, 'show']);

/*
|--------------------------------------------------------------------------
| Routes publiques - Images
|--------------------------------------------------------------------------
*/
Route::get('/images', [ImageController::class, 'index']);
Route::get('/images/{id}', [ImageController::class, 'show']);


/*
|--------------------------------------------------------------------------
| Routes protégées (nécessitent un token JWT)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:api')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/refresh', [AuthController::class, 'refresh']);

    // Projects (Admin)
    Route::get('/admin/projects', [ProjectController::class, 'adminIndex']);
    Route::post('/projects', [ProjectController::class, 'store']);
    Route::put('/projects/{id}', [ProjectController::class, 'update']);
    Route::delete('/projects/{id}', [ProjectController::class, 'destroy']);

    // Routes Technologies
    Route::post('/technologies', [TechnologyController::class, 'store']);
    Route::put('/technologies/{id}', [TechnologyController::class, 'update']);
    Route::delete('/technologies/{id}', [TechnologyController::class, 'destroy']);

    // Routes Images
    Route::post('/images', [ImageController::class, 'store']);
    Route::put('/images/{id}', [ImageController::class, 'update']);
    Route::delete('/images/{id}', [ImageController::class, 'destroy']);
});