@extends('app')

@section('content')

    {!! Form::open(['url' => 'torrents'])  !!}
    @include ('torrents.form', ['submitButtonText' => 'Ajouter le torrent','page' => 'create'])
    {!! Form::close() !!}

    @include ('errors.list')
@stop