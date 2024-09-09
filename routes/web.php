<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// routes/web.php

use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;

Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [UserController::class, 'register']);

Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/profile', [UserController::class, 'showProfile'])->middleware('auth')->name('profile.show');
Route::put('/profile', [UserController::class, 'updateProfile'])->middleware('auth')->name('profile.update');


// Route pour la page d'accueil
Route::get('/', function () {
    return view('welcome');
});

// Auth::routes(); // Cette ligne génère toutes les routes nécessaires pour l'authentification

// Route pour afficher tous les posts (exemple de CRUD)
Route::resource('posts', 'PostController')->middleware('auth');

Route::get('/indes', [PostController::class, 'index']);