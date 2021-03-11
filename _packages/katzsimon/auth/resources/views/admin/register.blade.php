@extends('katzsimon::templates.admin')

@section('title')
    Register
@endsection



@section('content')
    <div class="box">
        {!! Form::open(['url' => route("admin.register"), 'method'=>'post']) !!}

        @include('katzsimon::components.formfield', [
            'type'=>'text',
            'name'=>'name',
            'label'=>'Name',
        ])

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

        @include('katzsimon::components.formfield', [
            'type'=>'password',
            'name'=>'password_confirmation',
            'label'=>'Password Confirmation',
        ])

        <div>
            <button class="text-white bg-blue-600 py-2 px-3 inline-block rounded hover:no-underline hover:bg-blue-700">Register</button>
        </div>

        {!! Form::close() !!}
    </div>
@endsection
