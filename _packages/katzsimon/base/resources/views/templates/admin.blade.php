{{-- Basic page structure of the Admin CRUD --}}
@extends('katzsimon::admin')

@section('page-content')

    <div class="flex flex-col h-100">
        @include('katzsimon::templates.admin_nav')

        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-6">
                @if(View::hasSection('title')) <h1 class="text-3xl font-bold">@yield('title') </h1> @endif
                @yield('breadcrumbs')
            </div>
        </header>
        <main class=" bg-gray-200 flex-grow">
            <div class="max-w-7xl mx-auto px-6">
                @yield('content')
            </div>
        </main>
        @if(session()->has('message'))
            @include('katzsimon::components.toast')
        @endif
    </div>


@endsection
