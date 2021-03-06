@extends('layouts.app')

@section('content')
<div class="col-12 mx-0 my-2">
    <form method="POST" action="{{ route('search') }}" class="col-md-8 offset-md-2 col-12 row">
        @csrf
        <input type="text" name="squery" id="search" class="form-control col-9 mx-auto" placeholder="{{ __('home.search') }}">
        <input type="submit" value="{{ __('home.search') }}" class="btn btn-primary mx-auto col-2">
    </form>
</div>

<div class="col-12 mx-0 my-2 row">
    @foreach ($articles as $art)
        <div class="card col-sm-6 col-md-5 my-3 mx-auto px-0">
            <a href="{{ route('article', ['article' => $art->permalink]) }}" class="text-dark text-decoration-none">
                <div class="w-100 px-1 py-2">
                    @if($art->image)
                        <img src="{{ asset("storage/images/$art->publisher_id/$art->id/medium/$art->image") }}" alt="" class="img-fluid">
                    @else
                        <img src="{{ $art->image_url }}" alt="" class="img-fluid">
                    @endif
                </div>
                <div class="w-100 px-1 py-2">
                    <h3 class="text-center">{{ $art->title }}</h3>
                </div>
            </a>
        </div>
    @endforeach
</div>

<div class="col-12">
    {!! $articles->links() !!}
</div>
@endsection
