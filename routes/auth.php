<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\MagicLoginController;
use Inertia\Inertia;

Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return Inertia::render('Auth/MagicLogin');
    })->middleware('guest')->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::post('/magic-link', [MagicLoginController::class, 'sendMagicLink'])
        ->middleware('guest')
        ->name('magic-link.send');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
