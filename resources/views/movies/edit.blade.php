@extends('app')
@section('content')
    <h1>Edit Movie </h1>
    {!! Form::model($movie,['url'=>'movie/update']) !!}
    {!! Form::hidden('id',$movie->id) !!}

    <div class="form-group">
        {!! Form::label('movie_name','Movie Name:') !!}
        {!! Form::text('movie_name',$movie->movie_name,['class'=>'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('movie_category','Category:') !!}
        {!! Form::select('movie_category',
                ['action' => 'action',
                 'adventure' => 'adventure',
                 'comedy' => 'comedy',
                 'crime_gangster' => 'crime&gangster',
                 'drama' => 'drama',
                 'epics_historical' => 'epics/historical',
                 'horror' => 'horror',
                 'musicals_dance' => 'musicals/dance',
                 'science_fiction' => 'science fiction',
                 'war' => 'war',
                 'westerns' => 'westerns']
                 ,$movie->movie_category,
        		['class' => 'form-control', 'placeholder' => 'Please select a category']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('content','Content:') !!}
        {!! Form::textarea('content',$movie->content,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('location','Location:') !!}
        {!! Form::text('location',$movie->location,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('phone_number','Phone Number:') !!}
        {!! Form::text('phone_number',$movie->phone_number,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Email','email:') !!}
        {!! Form::text('Email',$movie->Email,['class'=>'form-control']) !!}
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
    <a class="more-link-custom" href="/movie"><span><i>CANCEL</i></span></a>
@endsection