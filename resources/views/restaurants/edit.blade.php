@extends('layouts.app')
@section('content')
    <h1>Edit restaurant </h1>
    {!! Form::model($restaurant,['url'=>'restaurant/update']) !!}
    {!! Form::hidden('id',$restaurant->id) !!}

    <div class="form-group">
        {!! Form::label('restaurant_name','restaurant Name:') !!}
        {!! Form::text('restaurant_name',$restaurant->restaurant_name,['class'=>'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('dish_category','Category:') !!}
        {!! Form::select('dish_category',
                ['african_cuisines' => 'African Cuisines',
                 'americans_cuisines' => 'Americans Cuisines',
                 'asian_cuisines' => 'Asian Cuisines',
                 'european_cuisines' => 'European Cuisines',
                 'oceanic_cuisines' => 'Oceanic Cuisines']
                 ,$restaurant->dish_category,
        		['class' => 'form-control', 'placeholder' => 'Please select a category']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('content','Content:') !!}
        {!! Form::textarea('content',$restaurant->content,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('location','Location:') !!}
        {!! Form::text('location',$restaurant->location,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('phone_number','Phone Number:') !!}
        {!! Form::text('phone_number',$restaurant->phone_number,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Email','email:') !!}
        {!! Form::text('Email',$restaurant->Email,['class'=>'form-control']) !!}
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
@endsection