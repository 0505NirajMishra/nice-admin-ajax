<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'show'])->name('getlogin');
Route::get('/login', [LoginController::class, 'show'])->name('getlogin'); // This is to show the login form
Route::post('/login', [LoginController::class, 'login'])->name('postlogin'); // This is to handle the login form submission
Route::get('/logout', [LoginController::class, 'destroy'])->name('logout');

// Register routes
Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('postregister');

// Dashboard

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->name('home');
    Route::resource('products', ProductController::class)->middleware('auth');
});

// Dashboard (protected by auth middleware)

// Products resource routes (protected by auth middleware)
