<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PurchasesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmployeesController;



// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication routes
Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::post('/register', [UsersController::class, 'register'])->name('register.submit');
Route::get('/login', [UsersController::class, 'login'])->name('login');
Route::post('/login', [UsersController::class, 'doLogin'])->name('do_login');
Route::post('/logout', [UsersController::class, 'doLogout'])->name('logout');

// Protected routes
Route::middleware(['auth'])->group(function () {
    // User profile and management
    Route::get('/profile', [UsersController::class, 'profile'])->name('profile');
    Route::get('/purchase-history', [UsersController::class, 'purchaseHistory'])->name('purchase_history');
    
    // User resource routes
    Route::resource('users', UsersController::class);
    
    // Employee and Admin routes
    Route::middleware(['role:Employee,Admin'])->group(function () {
        Route::resource('products', ProductsController::class)->except(['index', 'show']);
        Route::get('/employees/customers', [EmployeesController::class, 'customers'])->name('employees.customers');
        Route::post('/employees/add-credit/{user}', [EmployeesController::class, 'addCredit'])->name('employees.add_credit');
        Route::get('/employees/credit-history/{user}', [EmployeesController::class, 'creditHistory'])->name('employees.credit_history');
        Route::get('/employees/reset/{user}', [EmployeesController::class, 'reset'])->name('employees.reset');

    });

    // Admin only routes
    Route::middleware(['role:Admin'])->group(function () {
        Route::resource('employees', EmployeesController::class);
        Route::get('/admin/create-employee', [AdminController::class, 'createEmployee'])->name('admin.create_employee');
        Route::post('/admin/create-employee', [AdminController::class, 'storeEmployee'])->name('admin.store_employee');
    });

    // Product routes
    Route::middleware(['permission:add_products,edit_products,delete_products'])->group(function () {
        Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('products', [ProductController::class, 'store'])->name('products.store');
        Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    });

    // Public product routes (viewing)
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');

    // Protected product routes (buying)
    Route::post('products/{product}/buy', [ProductController::class, 'buy'])->name('products.buy');
});

// Public product routes
Route::resource('products', ProductsController::class)->only(['index', 'show']);

// WebSecTest routes
Route::get('/multable', function () { return view('multable'); });
Route::get('/even', function () { return view('even'); });
Route::get('/prime', function () { return view('prime'); });
Route::get('/test', function () { return view('test'); });

Route::get('/purchases', [PurchasesController::class, 'index'])->name('purchases.index');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

Route::get('/home', [HomeController::class, 'index'])->name('home');