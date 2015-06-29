@extends('app')

@section('content')
    <h1>Éditer: {!! $torrent->title !!}</h1>

    <hr>

    {!! Form::model($torrent,['method' => 'PATCH', 'action' => ['TorrentsController@update', $torrent->id]])  !!}
        @include ('torrents.form', ['submitButtonText' => 'Éditer le torrent'])
    {!! Form::close() !!}

    @include ('errors.list')

@stop