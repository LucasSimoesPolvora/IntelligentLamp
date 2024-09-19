<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-get', function () {
    return response()->json([
        'message' => 'Hello, World!',
        'test' => 'How are you?',
        'test2' => 'I am fine, thank you.'
    ]);
});
