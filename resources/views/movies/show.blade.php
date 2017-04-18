@extends('layouts.app')
@section('content')
        <article class="format-image group">

            <h2 class="post-title pad">Movie Name</h2>
            <div class="post-inner">
                <div class="post-content pad">
                    <div class="entry custome">
                        {{ $movie->movie_name }}
                    </div>
                </div>
            </div>
            <h2 class="post-title pad">Category</h2>
            <div class="post-inner">
                <div class="post-content pad">
                    <div class="entry custome">
                        {{ $movie->movie_category }}
                    </div>
                </div>
            </div>

            <h2 class="post-title pad">Content</h2>
            <div class="post-inner">
                <div class="post-content pad">
                    <div class="entry custome">
                        {{ $movie->content }}
                    </div>
                </div>
            </div>

            <h2 class="post-title pad">Location</h2>
            <div class="post-inner">
                <div class="post-content pad">
                    <div class="entry custome">
                        {{ $movie->location }}
                    </div>
                </div>
            </div>

            <h2 class="post-title pad">Start Time</h2>
            <div class="post-inner">
                <div class="post-content pad">
                    <div class="entry custome">
                        {{ $movie->start_at}}
                    </div>
                </div>
            </div>

            <h2 class="post-title pad">Contact With</h2>
            <div class="post-inner">
                <div class="post-content pad">
                    <div class="entry custome">
                        Phone: {{ $movie->phone_number }}
                        <br>
                        Email: {{ $movie->Email }}
                    </div>
                </div>
            </div>

        </article>

    <a class="more-link-custom" href="/movie"><span><i>RETURN</i></span></a>
@endsection