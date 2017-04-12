@extends('layoutsapp')
@section('content')
    <h1>Start a New Search</h1>
    {!! Form::open(['url'=>'message/result']) !!}

	<div class="form-group">
       {!! Form::label('destination','Destination:') !!}
       {!! Form::text('destination',null,['class'=>'form-control']) !!}
   	</div>
    <div class="form-group" >
        {!! Form::label('date','Date:') !!}
        {!! Form::text('date',null,['class'=>'form-control', 'data-provide' => 'datepicker', 
                                    'data-date-format' => 'yyyy-mm-dd']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('seatsNumber','Number of Seats:') !!}
        {!! Form::select('seatsNumber',['1' => '1', '2' => '2', '3' => '3', '4' => '4'] ,null, 
        		['class' => 'form-control', 'placeholder' => 'Please select a number']) !!}
    </div>
   	<div class="form-group">
       {!! Form::submit('SEARCH',['class'=>'btn btn-success form-control']) !!}
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