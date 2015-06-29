<div class="form-group">
    {!! Form::label('title','Titre:') !!}
    {!! Form::text('title',null,['class' => 'form-control']) !!}

</div>

<!-- Description Form Input -->
<div class="form-group">
    {!! Form::label('description','Description:') !!}
    {!! Form::textarea('description',null,['class' => 'form-control']) !!}
</div> 

<!-- Tags Form Input -->
<div class="form-group">
    {!! Form::label('tag_list','Tags:') !!}
    {!! Form::select('tag_list[]',$tags,null,['class' => 'form-control', 'multiple']) !!}
</div> 

<!-- Add Torrent Form Input -->
<div class="form-group">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
</div>