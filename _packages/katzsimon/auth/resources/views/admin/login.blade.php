@extends('katzsimon::templates.admin')

@section('title')
    Blade Login
@endsection


@section('content')
    <div class="box">
        {!! Form::open(['url' => route("admin.login"), 'method'=>'post']) !!}
        @include('katzsimon::components.formfield', [
            'type'=>'text',
            'name'=>'email',
            'label'=>'Email',
        ])

        @include('katzsimon::components.formfield', [
            'type'=>'password',
            'name'=>'password',
            'label'=>'Password',
        ])

        <div>
            <button class="btn btn-primary">Login</button>
        </div>

        {!! Form::close() !!}
    </div>
@endsection
