@extends('katzsimon::templates.admin')

@section('title')
    {{ $ui['names'] }}
@endsection

@section('breadcrumbs')
    @if(is_array($breadcrumbs) && count($breadcrumbs)>0)
        <ol class="breadcrumb flex flex-row justify-end">
            @foreach($breadcrumbs as $breadcrumb)
                <li class="inline">
                    @if(!empty($breadcrumb['href']))
                        <a href="{{ $breadcrumb['href'] }}" class="@if(!empty($breadcrumb['active']??false)) active @endif">
                            {{ $breadcrumb['text']??'' }}
                        </a>
                    @else
                        <span class="text-blue-500">
                {{ $breadcrumb['text']??'' }}
            </span>
                    @endif

                    @if(!$loop->last)<span class="mx-2"> / </span> @endif
                </li>
            @endforeach
        </ol>
    @endif
@endsection

@section('content')

    <div class="box">
        <div class="mb-2">

        </div>
        <table class="table table-bordered table-hover table-middle table-items">
            <thead>
            <tr>
                <th class="center">ID</th>
                <th>NAME</th>
                <th>GENRE</th>
                <th class="text-center">RATING</th>
                <th class="">
                    <a href="{{ route("admin.{$ui['items']}.create") }}" class="text-white bg-blue-600 py-2 px-3 inline-block rounded hover:no-underline hover:bg-blue-700">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="inline">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Add <span class="hidden sm:inline">{{ $name??'' }}</span>
                    </a>
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $item)
                <tr>
                    <td class="center">{{ $item['id']??'' }}</td>
                    <td>{{ $item['name']??'' }}</td>
                    <td>{{ $item['genre']??'' }}</td>
                    <td class="text-center">{{ $item['rating']??'' }}</td>
                    <td class="">
                        <div class="relative inline-block text-left">
                            <div>
                                <button type="button" class="inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-2 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50" id="btn-options-menu{{ $id }}" aria-haspopup="true" aria-expanded="true">

                                    <!-- Heroicon name: solid/chevron-down -->
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                    </svg>
                                </button>
                            </div>

                            <div class="origin-top-right absolute right-0 mt-2 rounded-md shadow bg-white ring-1 ring-black ring-opacity-5 z-10 hidden" id="options-menu{{ $id }}">
                                <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                    <a href="{{ route("admin.{$ui['items']}.edit", $id) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 hover:no-underline whitespace-nowrap">Edit {{ $name }}</a>
                                    {!! Form::open(['url' => route("admin.{$ui['items']}.destroy", $id) , 'method'=>'DELETE']) !!}
                                    <button type="submit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 hover:no-underline whitespace-nowrap w-full text-left">
                                        Delete {{ $name }}
                                    </button>
                                    {!! Form::close() !!}

                                </div>
                            </div>
                            <script type="text/javascript">
                                window.addEventListener("DOMContentLoaded", function(event) {
                                    (function() {
                                        var btn = document.querySelector("#btn-options-menu{{ $id }}");
                                        var menu = document.querySelector("#options-menu{{ $id }}");

                                        btn.addEventListener('click', function (e) {
                                            menu.classList.toggle('hidden');
                                        });
                                    }());
                                });
                            </script>
                        </div>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection
