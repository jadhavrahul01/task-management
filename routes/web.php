<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\PasswordResetController;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('admin.index');
    }
    return redirect()->route('login');
});

Route::post('/password/email', [PasswordResetController::class, 'sendResetLink'])
    ->name('password.email');

Route::get('/password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/update', [PasswordResetController::class, 'reset'])->name('password.update');

Route::get('/password/forgot', [PasswordResetController::class, 'showForgotForm'])->name('password.request');
Route::post('/password/email', [PasswordResetController::class, 'sendResetLink'])->name('password.email');

Route::middleware('guest')->group(function () {
    Volt::route('/login', 'login')->name('login');
});


Route::middleware('admin.auth')->group(
    function () {
        Route::post('/logout', function () {
            Auth::guard('web')->logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
            return redirect()->route('login');
        })->name('admin.logout');

        Route::redirect('/admin', '/');
        Route::redirect('/admin/dashboard', '/');

        Volt::route('/', 'dashboard.index')->name('admin.index');
        Volt::route('/profile', 'admin.profile')->name('admin.profile');

        Route::group(['middleware' => ['role:admin']], function () {
            Route::name('admin.')->group(function () {

                Route::group(['prefix' => 'employee'], function () {
                    Volt::route('/', 'employee.index')->name('employee.index');
                    Volt::route('create', 'employee.create')->name('employee.create');
                    Volt::route('{id}/show', 'employee.show')->name('employee.show');
                    Volt::route('{id}/edit', 'employee.edit')->name('employee.edit');
                });

                Route::group(['prefix' => 'task'], function () {
                    Volt::route('/', 'task.index')->name('task.index');
                    Volt::route('/create', 'task.create')->name('task.create');
                    Volt::route('{id}/show', 'task.show')->name('task.show');
                    Volt::route('{id}/edit', 'task.edit')->name('task.edit');
                });
            });
        });

        Route::group(['middleware' => ['role:employee|admin']], function () {
            Route::name('admin.')->group(function () {
                Route::group(['prefix' => 'task'], function () {
                    Volt::route('/', 'task.index')->name('task.index');
                    Volt::route('{id}/show', 'task.show')->name('task.show');
                });
            });
        });
    }
);
