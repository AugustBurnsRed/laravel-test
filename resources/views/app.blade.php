<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Document</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{ elixir('css/all.css') }}">
    </head>
    <body>
        <div class="container">
            @include('flash::message')
            
            @yield('content') 
        </div>

        <script src="//code.jquery.com/jquery.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

        <script>
            $('div.alert').not('.alert-important').delay(3000).slideUp(300);
        </script>
        
        @yield('footer')
    </body>
</html>