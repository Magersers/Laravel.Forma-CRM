<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\login;
use App\Http\Controllers\forma;
use App\Http\Controllers\adminpanel;


Route::middleware('web')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('home');
    Route::get('/login', [login::class, 'index'])->name('login');
    Route::get('/admin', [adminpanel::class, 'index'])->name('admin');
    Route::post('/login', [login::class, 'auth'])->name('login_aut');
    Route::post('/valid', [forma::class, 'form_valid'])->name('forma_valid');  
});
    Route::post('/api/status', [adminpanel::class, 'status'])->name('status');

