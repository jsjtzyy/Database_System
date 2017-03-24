@extends('app')
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
				<a class="more-link-custom" href="message/edit/{{ $message->msgID }}"><span><i>Edit</i></span></a>
			</div>
	    </div>
	</article>
	<form action="{{ $message->msgID }}" method="POST">
		{{ csrf_field() }}
		{{ method_field('DELETE') }}
		<button type="submit" class="btn btn-danger">Delete</button>
	</form>
    @endforeach
	<a class="more-link-custom" href="/message/create"><span><i>NEW POST</i></span></a>
	<a class="more-link-custom" href="/message/search"><span><i>SEARCH</i></span></a>
	@foreach($matchUserPairs as $pair)
		<article class="format-image group">
			<h2 class="post-title pad"> Potential pairs:</h2>
			<div class="post-inner">
				<div class="post-content pad">
					<div class="entry custome">
						Provider userID: {{ $pair->provider }}; Requestor userID:  {{ $pair->requestor }}
					</div>
				</div>
			</div>
		</article>
	@endforeach
@endsection