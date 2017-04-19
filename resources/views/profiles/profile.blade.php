@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $user->name }}'s Profile</div>
                <div class="panel-body">
                    <center>
                        <a href="{{ route('profile.edit') }}">
                            <img src="/media/avatars/{{ $user->avatar }}" style="width:150px; height:150px; border-radius:50%;">
                        </a>
                    </center>
                    <br>
                    <p class="text-center">
                        <strong>{{ $user->email }}</strong>
                    </p>
                    <p class="text-center">
                        @if(Auth::id() == $user->id)
                            <a href="{{ route('profile.edit') }}" class="btn btn-info">Edit avatar</a>
                        @endif
                    </p>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Similar Users
                    @if (count($simusers) == 0)
                        <p>Please post something first!</p>
                    @else    
                        @foreach($simusers as $simuser)
                            <article class="format-image group">
                                <h4 class="post-inner pad">
                                    <a href="profile/{{$simuser->ID}}"> {{ $simuser->name }}</a>
                                </h4>
                            </article>
                        @endforeach
                    @endif    
                </div>

            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $user->name }}'s Post</div>
                <div class="panel-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#ride" aria-controls="ride" role="tab" data-toggle="tab">Ride</a></li>
                        <li role="presentation"><a href="#movie" aria-controls="movie" role="tab" data-toggle="tab">Movie</a></li>
                        <li role="presentation"><a href="#restaurant" aria-controls="restaurant" role="tab" data-toggle="tab">Restaurant</a></li>
                    </ul>

                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active" id="ride">
                            @foreach($rides as $ride)
                            <article class="format-image group">
                                <h2 class="post-title pad">
                                    <a href="/messages/{{ $ride->msgID }}"> {{ $ride->destination }}</a>
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
                                            {{ $ride->content }}
                                        </div>
                                        <a class="more-link-custom" href="message/edit/{{ $ride->msgID }}"><span><i>Edit</i></span></a>
                                    </div>
                                </div>
                            </article>
                            <form action="{{ $ride->msgID }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                            @endforeach
                        </div>
                            
                        <div role="tabpanel" class="tab-pane fade" id="movie">
                            @foreach($movies as $movie)
                            <article class="format-image group">
                                <h2 class="post-title pad">
                                    <a href="/movie/{{ $movie->id }}"> {{ $movie->movie_name }}</a>
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
                                            {{ $movie->content }}
                                        </div>
                                        <a class="more-link-custom" href="movie/{{ $movie->id }}/edit/"><span><i>Edit</i></span></a>
                                    </div>
                                </div>
                            </article>
                            <form action="movie/{{ $movie->id }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                            @endforeach
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="restaurant">
                            @foreach($restaurants as $restaurant)
                            <article class="format-image group">
                                <h2 class="post-title pad">
                                    <a href="/restaurant/{{ $restaurant->id }}"> {{ $restaurant->restaurant_name }}</a>
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
                                            {{ $restaurant->content }}
                                        </div>
                                        <a class="more-link-custom" href="restaurant/{{ $restaurant->id }}/edit/"><span><i>Edit</i></span></a>
                                    </div>
                                </div>
                            </article>
                            <form action="restaurant/{{ $restaurant->id }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
