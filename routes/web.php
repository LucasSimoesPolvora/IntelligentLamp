<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\t_notification;
use App\Models\t_lampadaire;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-get', function () {
    $notifs = t_notification::all();
    return response()->json([
        'message' => $notifs,
    ]);
});

Route::get('/lampadaire/{id}', function ($id) {
    $lampadaire = t_lampadaire::find(intval($id));
    print_r($lampadaire);
    return response()->json([
        'lampadaire' => $lampadaire,
    ]);
});

Route::post('/insert/notification',  function (Request $req) {
    $reqContent = $req->all();
    
    try {
        
        $notif = new t_notification();
        $notif->title = $reqContent['title'];
        $notif->content = $reqContent['message'];
        $notif->fkLampadaire = $reqContent['fkLampadaire'];
        $notif->save();
    }
    catch (\Exception $e) {
        return response()->json([
            'message' => 'Failed to insert data',
            'error' => $e->getMessage(),
        ]);
    }
    
    print_r($reqContent);
});
