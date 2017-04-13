@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit your avatar.</div>
                <div class="panel-body">
                    <form enctype="multipart/form-data" action="{{ route('profile.update') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="control-label">Upload avatar</label>
                            <input name="avatar" type="file" class="file" data-show-preview="false">
                        </div>
                    </form>
                    <p class="text-center">
                        <a href="../profile" class="btn btn-info" role="button">Back</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
