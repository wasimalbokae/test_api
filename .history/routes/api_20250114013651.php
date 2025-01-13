<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
 Route::get('/category', [CategoryController::class, 'index']);
 Route::POST('/category/create', [CategoryController::class, 'store']);
 Route::get('/category/show/{id}', [CategoryController::class, 'show']);
 Route::DELETE('/category/delete/{id}', [CategoryController::class, 'destroy']);
 Route::put('/category/update/{id}', [CategoryController::class, 'update']);

 Route::get('/tag', [TagController::class, 'index']);
 Route::POST('/tag/create', [TagController::class, 'store']);
 Route::get('/tag/show/{id}', [TagController::class, 'show']);
 Route::DELETE('/tag/delete/{id}', [TagController::class, 'destroy']);
 Route::put('/tag/update/{id}', [TagController::class, 'update']);




