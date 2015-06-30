<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/">Tracker</a>
    </div>

    <div id="navbar" class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li class="{{ setActive('torrents') }}"><a href="/torrents">Torrents</a></li>
      </ul>

      <ul class="nav navbar-nav  navbar-right">
        <li>{!! link_to_action('TorrentsController@show', $latest->title, [$latest->id]) !!}</li>
      </ul>
      <div class="navbar-form navbar-right">
        {!! Form::open(['method' => 'get', 'action' => ['TorrentsController@search']])  !!}
          {!! Form::input('', 'q', Input::get('recherche', ''))!!}
          {!! Form::submit('Filter results') !!}
        {!! Form:: close() !!}
      </div>
    </div>
  </div>
</nav>