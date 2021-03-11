@extends('katzsimon::templates.admin')

@section('title')
    {{ $ui['names'] }}
@endsection

@section('breadcrumbs')
    @include('katzsimon::components.breadcrumbs', ['breadcrumbs'=>$breadcrumbs])
@endsection

@section('content')
    <div class="box">
        {!! Form::open(['url' => isset($parent) ? route("admin.{$parent->getUI()['items']}.{$ui['items']}.store", $parent) : route("admin.{$ui['items']}.store"), 'method'=>'post']) !!}
        @include("katzsimon::admin.{$ui['items']}._form", ['ui'=>$ui, 'edit'=>false, 'create'=>true])
        {!! Form::close() !!}
    </div>
@endsection
