@extends('app')

@section('content')

<!-- Search input -->
{!! Form::open(['method' => 'get', 'action' => ['TorrentsController@search']])  !!}
  
    <div class="form-group">
      {!! Form::label('q','Mots-clés:') !!}
      {!! Form::text('q',$input,['class' => 'form-control']) !!}
    </div>

    <!-- Tags input -->
    <div class="form-group">
        {!! Form::label('tags','Tags:') !!}
        {!! Form::text('tags',$tags,['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Rechercher un torrent', ['class' => 'btn btn-primary form-control']) !!}
    </div>
{!! Form:: close() !!}
{!! $table->render() !!}

@stop