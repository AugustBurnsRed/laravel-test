<!-- Hidden Input -->
@if($page == 'create')
    {!! Form::hidden('tmdb_id', '') !!}
@endif

<div class="form-group">
    {!! Form::label('torrent','Torrent:') !!}
    {!! Form::text('torrent',null,['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-7 pl0">
    {!! Form::label('title','Titre:') !!}
    {!! Form::text('title',null,['class' => 'form-control', 'autocompleteInfo']) !!}
</div>

<div class="form-group col-sm-2 pl0">
    {!! Form::label('year','Année:') !!}
    {!! Form::text('year',null,['class' => 'form-control']) !!}
</div>
<div class="clearfix">

</div>
<!-- Tags Form Input -->
<div class="form-group">
    {!! Form::label('tag_list','Tags:') !!}
    {!! Form::select('tag_list[]',$tags,null,['id' => 'tag_list', 'class' => 'form-control', 'multiple']) !!}
</div>

<!-- Add Torrent Form Input -->
<div class="form-group">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
</div>

@section('footer')
    <script>
    $('#tag_list').select2({
        placeholder: 'Choisissez un tag'
    });
    </script>
@endsection
