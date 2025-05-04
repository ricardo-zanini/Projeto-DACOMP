<?php

use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\Home;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/', function () {return view('home.index');})->name('home');
