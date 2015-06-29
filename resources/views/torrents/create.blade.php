@extends('app')

@section('content')
    <h1>Ajouter un torrent</h1>
    <hr>

    {!! Form::open(['url' => 'torrents'])  !!}
        @include ('torrents.form', ['submitButtonText' => 'Ajouter le torrent'])
    {!! Form::close() !!}

    @include ('errors.list')
@stop