@extends('app')
@section('content')
    @foreach($articles as $article)
        <article class="format-image group">
        <h2 class="post-title pad">
            <a href="/articles/{{ $article->id }}" rel="bookmark"> {{ $article->title }}</a>
        </h2>
        <div class="post-inner">
            <div class="post-content pad">
                <div class="entry custome">
                    {{ $article->content }}
                </div>
            </div>
        </div>
        </article>
    @endforeach
@endsection