@extends('katzsimon::templates.admin')

@section('title')
    {{ $ui['names'] }}
@endsection


@section('content')
    <div class="box">
        {!! Form::model($item, ['url' => route("admin.{$ui['items']}.update", $item['id']), 'method'=>'patch']) !!}
        @include('katzsimon::admin.movies._form', ['ui'=>$ui])
        {!! Form::close() !!}
    </div>
@endsection
