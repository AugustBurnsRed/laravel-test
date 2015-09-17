<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="_token" content="{!! csrf_token() !!}" />
  <title>Tracker</title>
  <link rel="stylesheet" href="{{ elixir('css/all.css') }}">
</head>

<body>
  @include('partials.navbar')
  <div class="container">
    {!! Breadcrumbs::render() !!} @include('flash::message') @yield('content')
  </div>

  <script src="/js/all.js"></script>
  <script type="text/javascript">
    $.ajaxSetup({
      headers: {
        'X-CSRF-Token': $('meta[name=_token]').attr('content')
      }
    });
  </script>
  @yield('footer')
</body>

</html>
