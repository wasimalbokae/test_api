<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
 Route::get('/category', [CategoryController::class, 'index']);
 Route::POST('/category/create', [CategoryController::class, 'store']);
 Route::get('/category/show/{id}', [CategoryController::class, 'show']);




