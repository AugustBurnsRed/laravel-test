@extends('app')

@section('content')
    <h1>Torrents</h1>
    <hr>
    @foreach ($torrents as $torrent)
        <article>
            <h2>
                <a href="{{ action('SeriesController@showEpisode', ['toDoNomSerie', $torrent->id]) }}">{{ $torrent->title }}</a>
            </h2>
            <div class="description">{{ $torrent->description }} <br> {{ $torrent->created_at->diffForHumans() }}</div>
        </article>
    @endforeach
@stop