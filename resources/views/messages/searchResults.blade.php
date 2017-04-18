@extends('layouts.app')
@section('content')
	<h1>Search Results: </h1>
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
				</div>
			</div>
		</article>
	@endforeach
	@foreach($users as $user)
		<article class="format-image group">
			<h2 class="post-title pad"> User Name:</h2>
			<div class="post-inner">
				<div class="post-content pad">
					<div class="entry custome">
						{{ $user->name }}
					</div>
				</div>
			</div>
			<h2 class="post-title pad"> Contact Info:</h2>
			<div class="post-inner">
				<div class="post-content pad">
					<div class="entry custome">
						Email: {{ $user->email }}; Mobile: {{ $user->phoneNumber }}
					</div>
				</div>
			</div>
		</article>
	@endforeach
	<a class="more-link-custom" href="/message/search"><span><i>RETURN SEARCH</i></span></a>
	<a class="more-link-custom" href="/"><span><i>RETURN HOME</i></span></a>
@endsection