@extends('app')
@section('content')
    @foreach($messages as $message)
    <h1>Edit Post :{{ $message->destination }}</h1>
    {!! Form::model($message,['url'=>'message/update']) !!}
    {!! Form::hidden('msgID',$message->msgID) !!}
    <div class="form-group">
        {!! Form::label('destination','Destination:') !!}
        {!! Form::text('destination',$message->destination,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('content','Content:') !!}
        {!! Form::textarea('content',$message->content,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('category','Category:') !!}
        {!! Form::select('category',['offerRide' => 'Offer a Ride', 'requestRide' => 'Request a Ride'] ,null, 
        		['class' => 'form-control', 'placeholder' => 'Please select a category']) !!}
    </div> 
    <div class="form-group" >
        {!! Form::label('date','Date:') !!}
        {!! Form::text('date',null,['class'=>'form-control', 'data-provide' => 'datepicker', 
                                    'data-date-format' => 'yyyy-mm-dd']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('time','Time:') !!}
        {!! Form::text('time',null,['class'=>'form-control', 'data-provide' => 'timepicker', 
                                    'data-show-meridian' => 'false', 'data-show-seconds' => 'true']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('seatsNumber','Number of Seats:') !!}
        {!! Form::select('seatsNumber',['1' => '1', '2' => '2', '3' => '3', '4' => '4'] ,null, 
        		['class' => 'form-control', 'placeholder' => 'Please select a number']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('curLocation','Current Location:') !!}
        {!! Form::text('curLocation',null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::submit('SUBMIT',['class'=>'btn btn-success form-control']) !!}
    </div>
    {!! Form::close() !!}
    @endforeach
    @if($errors->any())
        <ul class="alert alert-danger">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    <a class="more-link-custom" href="/"><span><i>CANCEL</i></span></a>
@endsection