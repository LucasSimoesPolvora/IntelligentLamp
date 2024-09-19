<?php

use Illuminate\Support\Facades\Route;
use App\Models\t_notification;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-get', function () {
    $notifs = t_notification::all();
    return response()->json([
        'message' => $notifs,
    ]);
});
