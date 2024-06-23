<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/niveis', function () {
    return view('niveis');
});

Route::get('/desenvolvedores', function () {
    return view('desenvolvedores');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});