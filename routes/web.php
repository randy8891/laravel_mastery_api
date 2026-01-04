<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Minimal named routes to satisfy links in the default welcome view
Route::get('/login', function () {
    // Placeholder: replace with real auth view/controller later
    return view('welcome');
})->name('login');

Route::get('/register', function () {
    // Placeholder: replace with real registration view/controller later
    return view('welcome');
})->name('register');

Route::get('/test-db-connection', function () {
    try {
        \DB::connection()->getPdo();
        return 'Database connection is successful!';
    } catch (\Exception $e) {
        return 'Database connection failed: ' . $e->getMessage();
    }
});

