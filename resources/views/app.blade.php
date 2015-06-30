<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Tracker</title>
        <link rel="stylesheet" href="{{ elixir('css/all.css') }}">
    </head>
    <body>
        @include('partials.navbar')
        <div class="container">
            @include('flash::message')
            
            @yield('content') 
        </div>

        <script src="/js/all.js"></script>
        @yield('footer')
    </body>
</html>