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
                ['african_cuisines' => 'African Cuisines',
                 'americans_cuisines' => 'Americans Cuisines',
                 'asian_cuisines' => 'Asian Cuisines',
                 'european_cuisines' => 'European Cuisines',
                 'oceanic_cuisines' => 'Oceanic Cuisines']
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
    <a class="more-link-custom" href="/restaurant"><span><i>CANCEL</i></span></a>




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