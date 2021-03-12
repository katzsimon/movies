@extends('katzsimon::templates.app')

@section('title')
    Account
@endsection


@section('content')
    <div class="box">

        @if(count($upcomingBookings)===0)
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <div>You Have No Upcoming Bookings Yet...</div>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-5 font-bold">Some useful links in the mean time:</div>
                <div class="mb-5"><a href="/cinemas" class="btn btn-primary">Where can I watch a movie?</a></div>
                <div class="mb-5"><a href="/upcoming-movies" class="btn btn-primary">What movies are screening?</a></div>
                <div><a href="/booking" class="btn btn-primary">Make a new Booking</a></div>
            </div>
        </div>
        @endif

            @if(count($upcomingBookings)>0)
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            Upcoming Bookings
                        </div>
                    </div>
                    <div class="card-body">
                        @foreach($upcomingBookings as $booking)
                            <div class="booking">

                                <div>Reference: <strong>{{ $booking['reference'] }}</strong></div>
                                <div class="text-h6"><strong>{{ $booking['screening_movie'] }}</strong></div>
                                <div>{!! $booking['screening_cinema'] !!}, {!! $booking['screening_theatre'] !!}</div>
                                <div><strong>{{ $booking['screening_when'] }}</strong></div>

                                @if($booking['can_cancel']===true)
                                    {!! Form::open(['url' => route('booking.cancel', $booking['id']), 'method'=>'DELETE']) !!}
                                    <button type="submit" class="btn btn-primary absolute top-3 right-3">
                                        Cancel Booking
                                    </button>
                                    {!! Form::close() !!}
                                @endif

                            </div>
                        @endforeach

                    </div>
                </div>
            @endif


            @if(count($pastBookings)>0)
                <div class="card mt-6">
                    <div class="card-header">
                        <div class="card-title">
                            Past Bookings
                        </div>
                    </div>
                    <div class="card-body">
                        @foreach($pastBookings as $booking)
                            <div class="booking">

                                <div>Reference: <strong>{{ $booking['reference'] }}</strong></div>
                                <div class="text-h6"><strong>{{ $booking['screening_movie'] }}</strong></div>
                                <div>{!! $booking['screening_theatre'] !!}</div>
                                <div><strong>{{ $booking['screening_when'] }}</strong></div>

                            </div>
                        @endforeach

                    </div>
                </div>
            @endif

    </div>
@endsection
