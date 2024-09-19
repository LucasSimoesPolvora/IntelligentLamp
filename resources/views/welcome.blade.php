<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <!-- <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" /> -->

        <!-- Styles -->

        
    </head>
    <body>
        <button id="btn">Click me</button>
        <script src="{{ URL::asset('js/test.js') }}" type="module"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

        <script>
            document.getElementById('btn').addEventListener('click', function() {
                $.ajax({
                    url: '/test-get',
                    type: 'GET',
                    success: function(data) {
                        console.log(data.test2);
                    }
                });
            });
        </script>
    </body>
</html>
