@if (Auth::user())
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                        aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">Tracker</a>
            </div>

            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                  <li class="dropdown {{ setActive('torrents') }}">
                       <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Torrents <span class="caret"></span></a>
                       <ul class="dropdown-menu">
                         <li><a href="/torrents">Voir tous</a></li>
                         <li><a href="/torrents/create">Ajouter</a></li>
                         <li role="separator" class="divider"></li>
                         <li><a href="#">Separated link</a></li>
                       </ul>
                    </li>
                    <li class="{{ setActive('torrents') }}"><a href="/torrents">Torrents</a></li>
                    <li class="{{ setActive('forum') }}"><a href="/forum">Forum</a></li>
                </ul>
                @if(isset($latest))
                    <ul class="nav navbar-nav  navbar-right">
                        <li>{!! link_to_action('TorrentsController@show', $latest->title, [$latest->id]) !!}</li>
                    </ul>
                @endif

                <div class="navbar-form navbar-right">
                    @include ('partials.searchTorrent')
                </div>
            </div>
        </div>
    </nav>
@endif
