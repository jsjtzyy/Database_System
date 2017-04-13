@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $user->name }}'s Profile</div>
                <div class="panel-body">
                    <center>
                        <img src="/media/avatars/{{ $user->avatar }}" style="width:150px; height:150px; border-radius:50%;">
                    </center>
                    <br>
                    <p class="text-center">
                        @if(Auth::id() == $user->id)
                            <a href="{{ route('profile.edit') }}" class="btn btn-info">Edit avatar</a>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
