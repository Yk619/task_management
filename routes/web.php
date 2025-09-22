<?php

// use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Auth::routes();

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
});

// Dashboard (authenticated)
Route::middleware(['auth'])->group(function () {
    // Route::get('/tasks', function () {
    //     return view('tasks.index');
    // })->name('tasks.index');


    Route::get('/tasks', [App\Http\Controllers\TaskController::class, 'index'])
    ->name('tasks.index');


    Route::get('/dashboard', \App\Http\Controllers\DashboardController::class . '@index')->name('dashboard');

    // Livewire components can be used directly in blade views.
    // Admin-only pages (users management)
    Route::middleware('admin')->group(function () {
        Route::get('/admin/users', \App\Http\Controllers\Admin\UserController::class . '@index')->name('admin.users.index');
        // You can also use Livewire endpoints or blade pages for users CRUD
    });

    // Tasks routes (both admin & user can access list; actions may be protected)
    Route::get('/tasks', \App\Http\Controllers\TaskController::class . '@index')->name('tasks.index');
});
