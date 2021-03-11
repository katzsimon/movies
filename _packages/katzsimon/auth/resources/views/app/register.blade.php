@extends('katzsimon::templates.app')

@section('title')
    Register
@endsection



@section('content')
    <div class="box">
        {!! Form::open(['url' => route("register"), 'method'=>'post']) !!}

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
            <button class="btn btn-primary">Register</button>
        </div>

        {!! Form::close() !!}
    </div>
@endsection
