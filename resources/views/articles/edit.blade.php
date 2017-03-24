@extends('app')
@section('content')
    <h1>Modify article:{{ $article->title }}</h1>
    {!! Form::model($article,['url'=>'article/update']) !!}
    {!! Form::hidden('id',$article->id) !!}
    <div class="form-group">
        {!! Form::label('title','TITLE:') !!}
        {!! Form::text('title',$article->title,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('content','CONTENT:') !!}
        {!! Form::textarea('content',$article->content,['class'=>'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('SUBMIT',['class'=>'btn btn-success form-control']) !!}
    </div>
    {!! Form::close() !!}
    @if($errors->any())
        <ul class="alert alert-danger">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

@endsection