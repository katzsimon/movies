@extends('katzsimon::templates.admin')

@section('title')
    Blade Register
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
            <button class="btn btn-primary">Register</button>
        </div>

        {!! Form::close() !!}
    </div>
@endsection
