@extends('katzsimon::templates.admin')

@section('title')
    Dashboard
@endsection

@section('breadcrumbs')
    @include('katzsimon::components.breadcrumbs', ['breadcrumbs'=>$breadcrumbs])
@endsection

@section('content')
    <div class="box">

        @if(count($bookings)>0)
            <div class="card mb-6">
                <div class="card-header">
                    <div class="card-title">Upcoming Bookings</div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-middle table-hover">
                        <thead>
                        <tr>
                            <th>User</th>
                            <th>Where</th>
                            <th>Movie</th>
                            <th>When</th>
                            <th>Seats</th>
                            <th>Reference</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($bookings as $booking)
                            <tr>
                                <td>{{ $booking['user_name']??'' }}</td>
                                <td>{!! $booking['screening_cinema_theatre']??'' !!}</td>
                                <td>{{ $booking['movie_name']??'' }}</td>
                                <td>{{ $booking['screening_when']??'' }}</td>
                                <td>{{ $booking['seats']??'' }}</td>
                                <td>{{ $booking['reference']??'' }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <div class="card-title">Factories</div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover table-middle">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th class="w-60">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Movie</td>
                        <td class="text-center">
                            {!! Form::open(['url' => route("admin.factory.movies"), 'method'=>'post']) !!}
                            <div class="flex2 flex-row2">
                                <x-formfield type="select" name="numberMovie" label="Number of Movies" :options="['', 1, 2, 3, 4, 5]"></x-formfield>
                                <button type="submit" class="btn btn-primary w-full">Make Movies</button>
                            </div>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                    <tr>
                        <td>Screenings (with Cinemas, Theatres, Movies)</td>
                        <td class="text-center">
                            {!! Form::open(['url' => route("admin.factory.screenings"), 'method'=>'post']) !!}
                            <div class="flex2 flex-row2">
                                <x-formfield type="select" name="numberScreening" label="Number of Screenings" :options="['', 1, 2, 3, 4, 5]"></x-formfield>
                                <x-formfield type="select" name="numberMovie" label="Number of Movies" :options="['', 1, 2, 3, 4, 5]"></x-formfield>
                                <button type="submit" class="btn btn-primary w-full">Make Screenings</button>
                            </div>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                    <tr>
                        <td>Bookings (with Cinema, Theatre, Movie, Screening)</td>
                        <td class="text-center">
                            {!! Form::open(['url' => route("admin.factory.bookings"), 'method'=>'post']) !!}
                            <div class="flex2 flex-row2">
                                <x-formfield type="select" name="numberBooking" label="Number of Bookings" :options="['', 1, 2, 3, 4, 5]"></x-formfield>
                                <x-formfield type="select" name="past" label="Future or Past" :options="['', 'Past', 'Future']"></x-formfield>
                                <button type="submit" class="btn btn-primary w-full">Make Bookings</button>
                            </div>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
