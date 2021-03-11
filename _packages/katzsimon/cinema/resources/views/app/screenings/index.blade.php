@extends('katzsimon::templates.app')

@section('title')
    Screenings of: {{ $movie['name']??'' }}
@endsection

@section('content')
    <div class="box">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>Cinema</th>
                <th>Theatre</th>
                <th>When</th>
                <th class="text-center">Seats Available</th>
                <th class="w-40"></th>
            </tr>
            </thead>
        @forelse($data as $screening)
            <tr>
                <td>{{ $screening['cinema_name'] }}</td>
                <td>{{ $screening['theatre_name'] }}</td>
                <td>{{ $screening['datetime'] }}</td>
                <td class="text-center">{{ $screening['seats_available'] }}</td>
                <td class="text-center">
                    @if(Auth::check())
                    <a href="{{ route('booking.screening', $screening['id']) }}" class="btn btn-primary">
                        Book Now
                    </a>
                    @else
                        <a href="{{ route('booking.screening', $screening['id']) }}" class="btn btn-primary">
                            Login To Book
                        </a>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">
                    There are no Screenings for this Movie
                </td>
            </tr>
        @endforelse
        </table>
    </div>
@endsection
