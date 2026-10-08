<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TournamentController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('login',   [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register',[AuthController::class, 'register']);
});

Route::post('logout', [AuthController::class, 'logout'])
    ->middleware('auth')->name('logout');

Route::get('tournaments', [TournamentController::class, 'index'])->name('tournaments.index');
Route::get('tournaments/{tournament}', [TournamentController::class, 'show'])->name('tournaments.show');

Route::middleware('auth')->group(function () {

    Route::post('tournaments/{tournament}/inscribirme', [RegistrationController::class, 'store'])
        ->name('registrations.store');
    Route::delete('tournaments/{tournament}/inscribirme', [RegistrationController::class, 'destroy'])
        ->name('registrations.destroy');
    Route::get('mis-torneos', [RegistrationController::class, 'mine'])
        ->name('registrations.mine');

    Route::middleware('admin')->prefix('admin')->group(function () {
        Route::get('tournaments', [TournamentController::class, 'adminIndex'])->name('admin.tournaments.index');
        Route::get('tournaments/create', [TournamentController::class, 'create'])->name('admin.tournaments.create');
        Route::post('tournaments', [TournamentController::class, 'store'])->name('admin.tournaments.store');
        Route::get('tournaments/{tournament}/edit', [TournamentController::class, 'edit'])->name('admin.tournaments.edit');
        Route::put('tournaments/{tournament}', [TournamentController::class, 'update'])->name('admin.tournaments.update');
        Route::delete('tournaments/{tournament}', [TournamentController::class, 'destroy'])->name('admin.tournaments.destroy');

        Route::delete('registrations/{registration}', [RegistrationController::class, 'adminDestroy'])
            ->name('admin.registrations.destroy');
    });
});