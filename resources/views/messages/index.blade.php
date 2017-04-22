@extends('layouts.app')
@section('content')
	
	@foreach($messages as $message)
	<article class="format-image group">
	    <h2 class="post-title pad">
	        <a href="/messages/{{ $message->msgID }}"> {{ $message->destination }}</a>
	    </h2>
	    <div class="post-inner">
	        <div class="post-deco">
	            <div class="hex hex-small">
	                <div class="hex-inner"><i class="fa"></i></div>
	                <div class="corner-1"></div>
	                <div class="corner-2"></div>
	            </div>
	        </div>
	        <div class="post-content pad">
	            <div class="entry custome">
	                {{ $message->content }}
	            </div>
	            @if ($message->userID == Auth::user()->id)
				<a class="more-link-custom" href="/message/edit/{{ $message->msgID }}"><span><i>Edit</i></span></a>
				@endif
			</div>
	    </div>
	</article>
	@if ($message->userID == Auth::user()->id)
		<form action="{{ $message->msgID }}" method="POST">
			{{ csrf_field() }}
			{{ method_field('DELETE') }}
			<button type="submit" class="btn btn-danger">Delete</button>
	</form>
	@endif
    @endforeach
	<a class="more-link-custom" href="/message/create"><span><i>NEW POST</i></span></a>
	<a class="more-link-custom" href="/message/search"><span><i>SEARCH</i></span></a>

<!-- 	<a class="more-link-custom" href="/message/analysis"><span><i>See who can go with me</i></span></a>
 -->
{!! Form::open(['url'=>'message/analysis']) !!}
    <div class="form-group" >
        {!! Form::label('date','Select Date:') !!}
        {!! Form::text('date',null,['class'=>'form-control', 'data-provide' => 'datepicker', 
                                    'data-date-format' => 'yyyy-mm-dd']) !!}
    </div>
    <div class="form-group">
       {!! Form::submit('See Who Can Go with Me',['class'=>'btn btn-success form-control']) !!}
   	</div>
{!! Form::close() !!}

<script>

</script>

@endsection
