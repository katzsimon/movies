@extends('katzsimon::templates.admin')

@section('title')
    {{ $ui['names'] }}
@endsection

@section('breadcrumbs')
    @include('katzsimon::components.breadcrumbs', ['breadcrumbs'=>$breadcrumbs])
@endsection

@section('content')

    <div class="box">

        <table class="table table-bordered table-hover table-middle table-items mb-12">
            <thead>
            <tr>
                <th class="center w-24">ID</th>
                <th class="">Movie</th>
                <th class="">Cinema</th>
                <th class="">Theatre</th>
                <th class="center">When</th>
                <th class="center">Seats Available</th>
                <th class="">
                    @include('katzsimon::components.item_create', ['item'=>$ui['items'], 'name'=>$ui['name']])
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($upcomingScreenings as $item)
                <tr>
                    <td class="center">{{ $item['id']??'' }}</td>
                    <td><a href="{{ route('admin.movies.edit', $item['movie_id']) }}" class="link">{{ $item['movie_name']??'' }}</a></td>
                    <td><a href="{{ route('admin.cinemas.edit', $item['cinema_id']) }}" class="link">{!! $item['cinema_name']??'' !!}</a></td>
                    <td><a href="{{ route('admin.cinemas.theatres.edit', [$item['cinema_id'], $item['theatre_id']]) }}" class="link">{!! $item['theatre_name']??'' !!}</a></td>
                    <td class="center">{{ $item['datetime']??'' }}</td>
                    <td class="center">{{ $item['seats_available']??'' }}</td>
                    <td class="">
                        @include('katzsimon::components.item_menu', ['id'=>$item['id'], 'name'=>$ui['name']])
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>


        <h3 class="text-3xl mb-3">Past Screenings</h3>
        <table class="table table-bordered table-hover table-middle table-items">
            <thead>
            <tr>
                <th class="center w-24">ID</th>
                <th class="">Movie</th>
                <th class="">Theatre</th>
                <th class="center">When</th>
                <th class="center">Seats Available</th>
                <th class="">

                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($pastScreenings as $item)
                <tr>
                    <td class="center">{{ $item['id']??'' }}</td>
                    <td><a href="{{ route('admin.movies.edit', $item['movie_id']) }}">{{ $item['movie_name']??'' }}</a></td>
                    <td>{!! $item['theatre_name']??'' !!}</td>
                    <td class="center">{{ $item['datetime']??'' }}</td>
                    <td class="center">{{ $item['seats_available']??'' }}</td>
                    <td class="">
                        @include('katzsimon::components.item_menu', ['id'=>$item['id'], 'name'=>$ui['name']])
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection

