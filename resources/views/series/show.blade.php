@extends('app')

@section('content')
    <h1>{{ $torrent->title }}</h1>
    <hr>
    
    <article>
        {{ $torrent->description }}
    </article>

    @unless ($torrent->tags->isEmpty())
        <h5>Tags:</h5>
        <ul>
            @foreach ($torrent->tags as $tag)
                <li><a href="{{ action('TagsController@show', [$tag->name]) }}">{{ $tag->name }}</a></li>
            @endforeach
        </ul>
    @endunless
@stop