<?php

use App\Http\Controllers\DesenvolvedorController;
use App\Http\Controllers\NivelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/example', function () {
    return response()->json(['message' => 'This is an API route!']);
});

Route::get('/niveis', [NivelController::class, 'index']);
Route::post('/niveis', [NivelController::class, 'store']);
Route::put('/niveis/{id}', [NivelController::class, 'update']);
Route::patch('/niveis/{id}', [NivelController::class, 'update']);
Route::delete('/niveis/{id}', [NivelController::class, 'destroy']);


Route::get('/desenvolvedores', [DesenvolvedorController::class, 'index']);
Route::post('/desenvolvedores', [DesenvolvedorController::class, 'store']);
Route::put('/desenvolvedores/{id}', [DesenvolvedorController::class, 'update']);
Route::patch('/desenvolvedores/{id}', [DesenvolvedorController::class, 'update']);
Route::delete('/desenvolvedores/{id}', [DesenvolvedorController::class, 'destroy']);