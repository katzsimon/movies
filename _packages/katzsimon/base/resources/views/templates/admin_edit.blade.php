{{-- Default template for an Edit Admin Page --}}
@extends('katzsimon::templates.admin')

@section('title')
    {{ $ui['names'] }}
@endsection

@section('breadcrumbs')
    @include('katzsimon::components.breadcrumbs', ['breadcrumbs'=>$breadcrumbs])
@endsection

@section('content')
    <div class="box">
        {!! Form::model($item, ['url' => isset($parent) ? route("admin.{$parent->getUI()['items']}.{$ui['items']}.update", [$parent['id'], $item['id']]) : route("admin.{$ui['items']}.update", $item['id']), 'method'=>'patch']) !!}
        @include("katzsimon::admin.{$ui['items']}._form", ['ui'=>$ui, 'edit'=>true, 'create'=>false])
        {!! Form::close() !!}
    </div>
@endsection
