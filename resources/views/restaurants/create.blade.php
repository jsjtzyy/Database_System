@extends('layouts.app')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <h1>Create a New Restaurant Post</h1>
    {!! Form::open(['url'=>'restaurant']) !!}

  <div class="form-group">
       {!! Form::label('restaurant_name','Restaurant Name:') !!}
       {!! Form::text('restaurant_name',null,['class'=>'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('dish_category','Category:') !!}
        {!! Form::select('dish_category',
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
                 ,null,
            ['class' => 'form-control', 'placeholder' => 'Please select a category']) !!}
    </div>

    <div class="form-group">
       {!! Form::label('content','Content:') !!}
       {!! Form::textarea('content',null,['class'=>'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('location','Location:') !!}
        {!! Form::text('location',null,['class'=>'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('phone_number','Phone Number:') !!}
        {!! Form::text('phone_number',null,['class'=>'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('Email','Email:') !!}
        {!! Form::text('Email',null,['class'=>'form-control']) !!}
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
    <a class="more-link-custom" href="/dashboard"><span><i>CANCEL</i></span></a>




 <!-- ************************************************************ -->
<script type="text/javascript">


$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

var res = null;

</script>  
@endsection