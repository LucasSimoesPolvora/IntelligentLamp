<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Intelligent Lamp</title>

        <!-- Fonts -->
        <!-- <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" /> -->

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">

        
    </head>
    <body>
        <button id="btn">Click me</button>
        <audio id="audio" src="{{ asset('songs/notifSong.wav') }}"></audio>

        <div id="notificationBox">

        </div>
        <script src="{{ URL::asset('js/test.js') }}" type="module"></script>
    </body>
</html>
