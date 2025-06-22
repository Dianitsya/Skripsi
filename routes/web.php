<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\{
    TodoController, UserController, ModuleController, ProfileController,
    CategoryController, DashboardController, TaskController, FeedbackController,
    QuestionnaireController
};
use App\Http\Controllers\KumpulanModulController;


// 🔹 Landing Page
Route::get('/', function () {
    return view('welcome');
});

// 🔹 Authenticated Routes
Route::middleware(['auth'])->group(function () {
    // 🔹 Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 🔹 Dashboard berdasarkan level
    Route::get('/dashboard/beginner', [DashboardController::class, 'beginner'])->name('dashboard.beginner');
    Route::get('/dashboard/intermediate', [DashboardController::class, 'intermediate'])->name('dashboard.intermediate');
    Route::get('/dashboard/advanced', [DashboardController::class, 'advanced'])->name('dashboard.advanced');

    // 🔹 Dashboard Admin
    Route::middleware('admin')->group(function () {
        Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
    });

    // 🔹 Kuisioner
    Route::prefix('questionnaire')->group(function () {
        Route::get('questionnaire', [QuestionnaireController::class, 'show'])->name('questionnaire.show');
        Route::post('questionnaire', [QuestionnaireController::class, 'store'])->name('questionnaire.store');

        Route::get('questionnaire2', [QuestionnaireController::class, 'showLearningStyle'])->name('questionnaire2.show');
        Route::post('questionnaire2', [QuestionnaireController::class, 'storeLearningStyle'])->name('questionnaire2.store');

        Route::get('questionnaire_result', [QuestionnaireController::class, 'result'])->name('questionnaire.result');
    });

    // 🔹 Profile Management
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // 🔹 Module Routes
    Route::middleware('user')->group(function () {
        Route::get('/modules', [ModuleController::class, 'index'])->name('modules.index');
        Route::get('/modules/{module}', [ModuleController::class, 'show'])->name('modules.show');
    });

    // 🔹 Admin Routes
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
            Route::post('/', [CategoryController::class, 'store'])->name('category.store');
            Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('category.edit');
            Route::patch('/{category}', [CategoryController::class, 'update'])->name('category.update');
            Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');
        });

        // Module Management
        Route::prefix('module')->group(function () {
            Route::get('/', [ModuleController::class, 'index'])->name('module.index');
            Route::get('/create', [ModuleController::class, 'create'])->name('module.create');
            Route::post('/', [ModuleController::class, 'store'])->name('module.store');
            Route::get('/{module}/edit', [ModuleController::class, 'edit'])->name('module.edit');
            Route::patch('/{module}', [ModuleController::class, 'update'])->name('module.update');
            Route::delete('/{module}', [ModuleController::class, 'destroy'])->name('module.destroy');
            Route::get('/{module}', [ModuleController::class, 'show'])->name('module.show');
        });
        Route::middleware('admin')->group(function () {
            Route::get('/kumpulan-modul', [KumpulanModulController::class, 'index'])->name('kumpulan_modul.index');
        });
    });
});

// 🔹 Auth Routes
require __DIR__ . '/auth.php';
