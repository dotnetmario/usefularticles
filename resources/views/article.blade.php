@extends('layouts.app')

@section('js')
    <script src="{{ asset('js/article.js') }}" defer></script>
@endsection

@section('content')
<div class="col-12 row mx-0 px-0">
    <div class="col-md-5 mx-2">
        @if($article->image)
            <img src="{{ asset("storage/images/$article->publisher_id/$article->id/large/$article->image") }}" alt="" class="img-fluid">
        @else
            <img src="{{ $article->image_url }}" alt="" class="img-fluid">
        @endif
    </div>

    <div class="col-md-5 mr-4">
        <h1 class="text-center">{{ $article->title }}</h1>
        <hr class="px-5">
        <p>{{ $article->description }}</p>
    </div>
</div>

<div class="col-12 row mx-0 px-0">
    <div class="col-md-8">
        <h1 class="text-center">{{ __('article.comments') }}</h1>
        <hr class="px-5">
        @if(Auth::check())
            <form class="form">
                <button id="comment_send" class="btn btn-primary" type="button">{{ __('comment.comment') }}</button>
                <div class="form-group">
                    <textarea name="comment" id="comment_field" cols="30" rows="10" class="form-control" placeholder="{{ __('article.leave-comment') }}"></textarea>
                </div>
            </form>
        @endif
        <div id="comments">
            @foreach($comments as $com)
                <div class="card my-3">
                    <h5>{{ $com->user->firstname }}</h5>
                    <h6 class="text-muted">{{ "@".$com->user->username }}</h6>
                    <p>{{ $com->body }}</p>
                    @if($com->user->id != Auth::id() && Auth::check())
                        <form class="form m-4 ml-5">
                            <button class="btn btn-primary reply_send" type="button" data-comment="{{ $com->id }}">{{ __('comment.reply') }}</button>
                            <div class="form-group">
                                <textarea name="reply" cols="30" rows="3" class="form-control reply_field" placeholder="{{ __('article.leave-reply') }}"></textarea>
                            </div>
                        </form>
                    @endif
                    <div id="replies_{{ $com->id }}" class="ml-5">
                        @foreach($com->replies as $rep)
                            <div class="card my-2">
                                <h5>{{ $rep->user->firstname }}</h5>
                                <h6 class="text-muted">{{ "@".$rep->user->username }}</h6>
                                <p>{{ $rep->body }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection