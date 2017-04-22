@extends('layouts.app')
@section('content')
    @foreach($messages as $message)
        <article class="format-image group">
            <h2 class="post-title pad">
                <a href="/messages/{{ $message->msgID}}" rel="bookmark"> {{ $message->destination }}</a>
            </h2>
            <div class="post-inner">
                <div class="post-content pad">
                    <div class="entry custome">
                        {{ $message->content }}
                    </div>
                </div>
            </div>
            <h2 class="post-title pad">Category</h2>
            <div class="post-inner">
                <div class="post-content pad">
                    <div class="entry custome">
                        {{ $message->category }}
                    </div>
                </div>
            </div>
            <h2 class="post-title pad">Expected Time</h2>
            <div class="post-inner">
                <div class="post-content pad">
                    <div class="entry custome">
                        {{ $message->date }}, {{ $message->time}}
                    </div>
                </div>
            </div>
            <h2 class="post-title pad">Current Location</h2>
            <div class="post-inner">
                <div class="post-content pad">
                    <div class="entry custome">
                        {{ $message->curLocation }}
                    </div>
                </div>
            </div>
            <h2 class="post-title pad">Seats Available</h2>
            <div class="post-inner">
                <div class="post-content pad">
                    <div class="entry custome">
                        {{ $message->seatsNumber }}
                    </div>
                </div>
            </div>
        </article>
    @endforeach

    <a class="more-link-custom" href="/ride"><span><i>RETURN</i></span></a>
@endsection