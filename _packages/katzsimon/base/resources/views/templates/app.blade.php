@extends('katzsimon::app')

@section('page-content')

    <div class="flex flex-col h-100">
        @include('katzsimon::templates.app_nav')

        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-6">
                @if(View::hasSection('title')) <h1 class="text-3xl font-bold">@yield('title') </h1> @endif
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
    <script type="text/javascript">
        window.addEventListener("DOMContentLoaded", function(event) {
            (function() {
                var navs = document.querySelectorAll(".btn-nav, .btn-mav-mobile");
                for (var i = 0; i < navs.length; i++) {
                    (function () {
                        var nav = navs[i];
                        var url = nav.getAttribute("href");
                        var path = window.location.pathname;
                        if (path!=='/' && url.includes(window.location.pathname)) nav.classList.add('active');
                    }());
                }

                var btnMobileMenu = document.querySelector("#btnMobileMenu");
                var mobileMenu = document.querySelector("#mobile-menu");

                btnMobileMenu.addEventListener('click', function (e) {
                    mobileMenu.classList.toggle('hidden');
                });
            }());
        });
    </script>


@endsection
