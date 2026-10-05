<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RecipeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('recipes.index')
        : redirect()->route('login');
})->name('home');

// Autenticación (solo invitados)
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);

    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

// Cerrar sesión
Route::post('logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Recetas (requieren autenticación)
Route::middleware('auth')->group(function () {
    Route::get('recipes', [RecipeController::class, 'index'])->name('recipes.index');

    Route::get('recipes/create', [RecipeController::class, 'create'])->name('recipes.create');
    Route::post('recipes', [RecipeController::class, 'store'])->name('recipes.store');

    Route::get('recipes/{recipe}', [RecipeController::class, 'show'])->name('recipes.show');

    Route::get('recipes/{recipe}/edit', [RecipeController::class, 'edit'])->name('recipes.edit');
    Route::match(['put', 'patch'], 'recipes/{recipe}', [RecipeController::class, 'update'])->name('recipes.update');

    Route::delete('recipes/{recipe}', [RecipeController::class, 'destroy'])->name('recipes.destroy');
});