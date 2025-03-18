<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SpotifyController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

Route::get('/spotify/token', [SpotifyController::class, 'getToken'])->name('spotify.token');
Route::get('/spotify/search', [SpotifyController::class, 'searchTrack'])->name('spotify.search');

Route::middleware('auth')->group(function () {
    
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/search-users', [UserController::class, 'search'])->name('search.users')->middleware('auth');
    Route::get('/profile/{id}', [UserController::class, 'show'])->name('profile.show');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
  
    Route::post('/post', [PostController::class, 'store'])->name('post.store');

    Route::post('/post/{post}/like', [PostController::class, 'toggleLike'])->name('post.like');

    Route::post('/post/{post}/comment', [PostController::class, 'addComment'])->name('post.comment');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
