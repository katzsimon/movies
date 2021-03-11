@extends('katzsimon::templates.admin')

@section('title')
    {{ $ui['names'] }}
@endsection


@section('content')
    <div class="box">
        {!! Form::open(['url' => route("admin.{$ui['items']}.store"), 'method'=>'post']) !!}
        @include('katzsimon::admin.movies._form', ['ui'=>$ui])
        {!! Form::close() !!}
    </div>
@endsection