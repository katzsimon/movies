@extends('katzsimon::templates.app')

@section('title')
    Home
@endsection


@section('content')
    <div class="box">
        @if(count($movies)>0)
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Featured Movies</div>
                </div>
                <div class="card-body">
                    @foreach($movies as $item)
                        @include('katzsimon::app.movie.movie', ['item'=>$item])
                    @endforeach
                </div>
            </div>

        @endif

        @if(count($upcomingBookings)>0)
            <div class="card mt-12">
                <div class="card-header">
                    <div class="flex flex-row justify-between">
                        <div class="card-title flex-grow">Upcoming Bookings</div>
                        <div class=""><a href="{{ route('booking') }}" class="btn btn-primary">Make a new Booking</a></div>
                    </div>
                </div>
                <div class="card-body">

                    @forelse($upcomingBookings as $item)

                        <div class="border border-gray-400 p-3 mb-3 relative">
                            <div>Reference: <strong>{{ $item['reference']??'' }}</strong></div>
                            <div class="text-h6"><strong><a href="{{ route('movie', $item['movie_id']) }}">{{ $item['screening_movie']??'' }}</a></strong></div>
                            <div>{{ $item['screening_cinema'] }}, {{ $item['screening_theatre'] }} ({{ $item['seats']??'' }} seats)</div>
                            <div><strong>{{ $item['screening_when']??'' }}</strong></div>

                            @if($item['can_cancel'])
                                {!! Form::open(['url' => route('booking.cancel', $item['id']), 'method'=>'POST']) !!}
                                <button type="submit" class="btn btn-primary absolute top-3 right-3">
                                    Cancel Booking
                                </button>
                                {!! Form::close() !!}
                            @endif
                        </div>
                    @empty
                        <div>You have no bookings yet</div>
                    @endforelse

                </div>
            </div>
        @endif
    </div>
@endsection
