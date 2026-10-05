<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('task.index');
})->name('home');

// Listado de tareas
Route::get('task', [TaskController::class, 'index'])
    ->name('task.index');

Route::get('tasks', [TaskController::class, 'index'])
    ->name('tasks.index');

// Crear tarea
Route::get('task/crear', [TaskController::class, 'create'])
    ->name('task.create');

Route::post('task', [TaskController::class, 'store'])
    ->name('task.store');

// Cambiar estado rápidamente
Route::patch('task/{task}/estado', [TaskController::class, 'changeStatus'])
    ->name('task.change-status');

// Ver tarea
Route::get('task/{task}', [TaskController::class, 'show'])
    ->name('task.show');

// Editar tarea
Route::get('task/{task}/editar', [TaskController::class, 'edit'])
    ->name('task.edit');

Route::match(['put', 'patch'], 'task/{task}', [TaskController::class, 'update'])
    ->name('task.update');

// Eliminar tarea
Route::delete('task/{task}', [TaskController::class, 'destroy'])
    ->name('task.destroy');