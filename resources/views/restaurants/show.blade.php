@extends('layouts.app')
@section('content')
        <article class="format-image group">

            <h2 class="post-title pad">restaurant Name</h2>
            <div class="post-inner">
                <div class="post-content pad">
                    <div class="entry custome">
                        {{ $restaurant->restaurant_name }}
                    </div>
                </div>
            </div>
            <h2 class="post-title pad">Category</h2>
            <div class="post-inner">
                <div class="post-content pad">
                    <div class="entry custome">
                        {{ $restaurant->dish_category }}
                    </div>
                </div>
            </div>

            <h2 class="post-title pad">Content</h2>
            <div class="post-inner">
                <div class="post-content pad">
                    <div class="entry custome">
                        {{ $restaurant->content }}
                    </div>
                </div>
            </div>

            <h2 class="post-title pad">Location</h2>
            <div class="post-inner">
                <div class="post-content pad">
                    <div class="entry custome">
                        {{ $restaurant->location }}
                    </div>
                </div>
            </div>

            <h2 class="post-title pad">Start Time</h2>
            <div class="post-inner">
                <div class="post-content pad">
                    <div class="entry custome">
                        {{ $restaurant->start_at}}
                    </div>
                </div>
            </div>

            <h2 class="post-title pad">Contact With</h2>
            <div class="post-inner">
                <div class="post-content pad">
                    <div class="entry custome">
                        Phone: {{ $restaurant->phone_number }}
                        <br>
                        Email: {{ $restaurant->Email }}
                    </div>
                </div>
            </div>

        </article>

    <a class="more-link-custom" href="/restaurant"><span><i>RETURN</i></span></a>
@endsection