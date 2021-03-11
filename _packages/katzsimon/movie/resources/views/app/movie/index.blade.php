@extends('katzsimon::templates.app')

@section('title')
    All Movies
@endsection

@section('content')
    <div class="box">
        @foreach($data as $item)
            @include('katzsimon::app.movie.movie', ['item'=>$item, 'loop'=>$loop])
        @endforeach
    </div>
@endsection
