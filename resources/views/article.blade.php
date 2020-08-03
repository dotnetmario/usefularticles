@extends('layouts.app')

@section('content')
<div class="col-12 row mx-0 px-0">
    <div class="col-md-5 mx-2">
        <img src="{{ $article->image_url }}" alt="" class="image-fluid">
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
        <div>
            @foreach($comments as $com)
                <div class="card">
                    <h5>{{ $com->user }}</h5>
                    <h6 class="text-muted">{{ "@".$com->username }}</h6>
                    <p>{{ $com->body }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection