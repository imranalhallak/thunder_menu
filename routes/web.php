<?php

use App\Http\Controllers\BranchController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DefaultController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicBranchController;
use App\Http\Controllers\PublicMenuController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\PublicMealController;
use App\Http\Middleware\CheckDefaultBranch;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/about', [PublicController::class, 'create'])->name('about');
Route::get('/', action: [PublicController::class, 'show']);
Route::get('/test', action: [MenuController::class, 'test']);

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::get('/dashboard', [DefaultController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/admin',      [MenuController::class, 'index'])->middleware(middleware: ['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::prefix('admin/branch')->group(function () {
        Route::post('store', [BranchController::class, 'store'])->name('branches.store'); // Display form to create a new Branch

        Route::get('/set-branch/{id}', [BranchController::class, 'setBranch'])->name('set-branch');

    });

    Route::middleware(CheckDefaultBranch::class)->group(function () {
    Route::prefix('admin/menu')->group(function () {

        Route::get('/', [MenuController::class, 'index'])->name('menus.index'); // Get all menus and display in Inertia component
        Route::get('create', [MenuController::class, 'create'])->name('menus.create'); // Display form to create a new menu
        Route::post('/', [MenuController::class, 'store'])->name('menus.store'); // Create a new menu
        Route::get('{id}', [MenuController::class, 'show'])->name('menus.show'); // Display a specific menu
        Route::get('{id}/edit', [MenuController::class, 'edit'])->name('menus.edit'); // Display form to edit a menu
        Route::post('/{id}', [MenuController::class, 'update'])->name('menus.update'); // Update a menu
        Route::delete('{id}', [MenuController::class, 'destroy'])->name('menus.destroy'); // Delete a menu
    });
    Route::prefix('admin/branch')->group(function () {

        Route::get('/', [BranchController::class, 'index'])->name('branches.index'); // Get all menus and display in Inertia component
        Route::get('create', [BranchController::class, 'create'])->name('branches.create'); // Display form to create a new menu
        Route::post('/', [BranchController::class, 'store'])->name('branches.store'); // Create a new menu
        Route::get('{id}', [BranchController::class, 'show'])->name('branches.show'); // Display a specific menu
        Route::get('{id}/edit', [BranchController::class, 'edit'])->name('branches.edit'); // Display form to edit a menu
        Route::post('/u/{id}', [BranchController::class, 'update'])->name('branches.update'); // Update a menu
        Route::delete('{id}', [BranchController::class, 'destroy'])->name('branches.destroy'); // Delete a menu
    });

    Route::prefix('admin/meal')->group(function () {
        Route::post('/u/{id}', [MealController::class, 'update'])->name(name: 'meals.update'); // Update a meal
        Route::get('/', [MealController::class, 'index'])->name('meals.index'); // Get all meals and display in Inertia component
        Route::get('create', [MealController::class, 'create'])->name('meals.create'); // Display form to create a new meal
        Route::post('/', [MealController::class, 'store'])->name('meals.store'); // Create a new meal
        Route::get('{id}', [MealController::class, 'show'])->name('meals.show'); // Display a specific meal
        Route::get('{id}/edit', [MealController::class, 'edit'])->name('meals.edit'); // Display form to edit a meal
        Route::post('/d/{id}', [MealController::class, 'deleteImage'])->name('meals.delete-image'); // Delete a meal image
        Route::post('/o/{id}', [MealController::class, 'orderImage'])->name('meals.order-image'); // Order a meal image
        Route::post('/dd/{id}', [MealController::class, 'destroy'])->name('meals.destroy'); // Delete a meal
    });
});

});
require __DIR__.'/auth.php';

// Route::get('/{branch}/{menu}/{meal}', [PublicMealController::class, 'show'])->name('branch.menu.meal');

// Route::get('/{branch}/{menu}', [PublicMenuController::class, 'show'])->name('branch.menu');

Route::get('/{slug}', action: [PublicBranchController::class, 'show']);
