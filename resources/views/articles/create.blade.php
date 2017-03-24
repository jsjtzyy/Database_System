@extends('app')
@section('content')
    <h1>Start a new article</h1>
    {!! Form::open(['url'=>'article/store']) !!}

	<div class="form-group">
       {!! Form::label('title','TITLE:') !!}
       {!! Form::text('title',null,['class'=>'form-control']) !!}
   	</div>
   	<div class="form-group">
       {!! Form::label('content','CONTENT:') !!}
       {!! Form::textarea('content',null,['class'=>'form-control']) !!}
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