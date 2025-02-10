<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\FeedbackController;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard untuk pengguna yang login
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Route untuk pengguna yang sudah login
Route::middleware('auth')->group(function () {

    // Profile Management
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // Todo Management (Optional, can be removed if not needed)
    Route::prefix('todo')->group(function () {
        Route::get('/', [TodoController::class, 'index'])->name('todo.index');
        Route::get('/create', [TodoController::class, 'create'])->name('todo.create');
        Route::post('/store', [TodoController::class, 'store'])->name('todo.store');
        Route::get('/{todo}/edit', [TodoController::class, 'edit'])->name('todo.edit');
        Route::patch('/{todo}', [TodoController::class, 'update'])->name('todo.update');
        Route::patch('/{todo}/complete', [TodoController::class, 'complete'])->name('todo.complete');
        Route::patch('/{todo}/incomplete', [TodoController::class, 'uncomplete'])->name('todo.uncomplete');
        Route::delete('/{todo}', [TodoController::class, 'destroy'])->name('todo.destroy');
        Route::delete('/', [TodoController::class, 'destroyCompleted'])->name('todo.deleteallcompleted');
    });

    // Task & Feedback Routes
    Route::resource('tasks', TaskController::class);
    Route::post('/tasks/{task}/submit', [TaskController::class, 'submitAnswer'])->name('tasks.submit');
    Route::post('tasks/{task}/feedback', [FeedbackController::class, 'store'])->name('tasks.feedback.store');
    Route::delete('tasks/{task}/feedback/{feedback}', [FeedbackController::class, 'destroy'])->name('tasks.feedback.delete');

    // API Notifications for Logged-in Users
    Route::get('/api/notifications', function (Request $request) {
        $notifications = Auth::user()->notifications()->latest()->take(5)->get();

        $formattedNotifications = $notifications->map(function ($notification) {
            return [
                'title' => $notification->data['title'],
                'url' => $notification->data['url'],
                'time' => $notification->created_at->diffForHumans(),
            ];
        });

        return response()->json(['notifications' => $formattedNotifications]);
    })->name('notifications.index');

    // Admin Routes (Only accessible by admins)
    Route::middleware('admin')->group(function () {

        // User Management
        Route::prefix('user')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('user.index');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('user.destroy');
            Route::patch('/{user}/makeadmin', [UserController::class, 'makeadmin'])->name('user.makeadmin');
            Route::patch('/{user}/removeadmin', [UserController::class, 'removeadmin'])->name('user.removeadmin');
        });

        // Category Management
        Route::prefix('category')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('category.index');
            Route::get('/create', [CategoryController::class, 'create'])->name('category.create');
            Route::post('/store', [CategoryController::class, 'store'])->name('category.store');
            Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('category.edit');
            Route::patch('/{category}', [CategoryController::class, 'update'])->name('category.update');
            Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');
        });

        // Module Management
        Route::prefix('module')->group(function () {
            Route::get('/', [ModuleController::class, 'index'])->name('module.index');
            Route::get('/create', [ModuleController::class, 'create'])->name('module.create');
            Route::post('/store', [ModuleController::class, 'store'])->name('module.store');
            Route::get('/{module}/edit', [ModuleController::class, 'edit'])->name('module.edit');
            Route::patch('/{module}', [ModuleController::class, 'update'])->name('module.update');
            Route::delete('/{module}', [ModuleController::class, 'destroy'])->name('module.destroy');
            Route::get('/{module}', [ModuleController::class, 'show'])->name('module.show');
        });
    });

    // Task Delete Route (Admin Only)
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
});

require __DIR__ . '/auth.php';
