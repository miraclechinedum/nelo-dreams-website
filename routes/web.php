<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MediaItemController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UpdateController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public site
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/updates', [UpdateController::class, 'index'])->name('updates.index');
Route::get('/updates/{post}', [UpdateController::class, 'show'])->name('updates.show');

Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:8,1')
    ->name('contact.store');

/*
|--------------------------------------------------------------------------
| Admin sign-in
|--------------------------------------------------------------------------
| There is no public registration — accounts are created with `php artisan
| admin:user` (or the seeder), so anyone who can sign in is an administrator.
*/

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [LoginController::class, 'create'])->name('login');
    Route::post('/admin/login', [LoginController::class, 'store'])
        ->middleware('throttle:6,1');
});

Route::post('/admin/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');

    Route::resource('posts', PostController::class)->except('show');
    Route::patch('posts/{post}/toggle', [PostController::class, 'toggle'])->name('posts.toggle');
    Route::delete('posts/{post}/media/{media}', [PostController::class, 'detachMedia'])->name('posts.media.destroy');

    Route::resource('media', MediaItemController::class)->except('show')->parameters(['media' => 'media']);
    Route::patch('media/{media}/toggle', [MediaItemController::class, 'toggle'])->name('media.toggle');

    Route::get('messages', [MessageController::class, 'index'])->name('messages.index');
    Route::delete('messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');

    Route::get('account', [AccountController::class, 'edit'])->name('account.edit');
    Route::patch('account', [AccountController::class, 'update'])->name('account.update');
});
