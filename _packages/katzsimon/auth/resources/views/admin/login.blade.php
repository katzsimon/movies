@extends('katzsimon::templates.admin')

@section('title')
    Login
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
            <button class="text-white bg-blue-600 py-2 px-3 inline-block rounded hover:no-underline hover:bg-blue-700">Login</button>
        </div>

        {!! Form::close() !!}
    </div>
@endsection
