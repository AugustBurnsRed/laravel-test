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
            <div>
                @foreach ($torrent->tags as $tag)
                    <li><a href="{{ action('TagsController@show', [$tag->name]) }}">{{ $tag->name }}</a></li>
                @endforeach
            </div>
        </article>
    @endforeach
@stop