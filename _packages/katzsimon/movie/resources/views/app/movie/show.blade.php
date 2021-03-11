@extends('katzsimon::templates.app')

@section('title')
    Movie
@endsection

@section('content')
    <div class="box">
        @include('katzsimon::app.movie.movie', ['item'=>$item])
    </div>
@endsection
