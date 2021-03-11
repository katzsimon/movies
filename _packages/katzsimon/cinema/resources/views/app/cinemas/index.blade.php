@extends('katzsimon::templates.app')

@section('title')
    Cinemas
@endsection

@section('content')
    <div class="box">

        @foreach($data as $cinema=>$item)
            <div class="card mb-6">
                <div class="card-header">
                    <div class="card-title">{{ $cinema??'' }}</div>
                    <small>{{ $item['location']??'' }}</small>
                </div>
                <div class="card-body">

                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <td><strong>Movies Screening Here</strong></td>
                            <td class="w-40">&nbsp;</td>
                        </tr>
                        </thead>
                    @foreach($item['movies'] as $movieId=>$movieName)
                        <tr>
                            <td>
                                {{ $movieName??'' }}
                            </td>
                            <td class="text-center">
                                <a href="{{ route('booking.movie', $movieId) }}" class="btn btn-primary">Book Now</a>
                            </td>
                        </tr>


                        <div></div>
                    @endforeach
                    </table>

                </div>
            </div>

        @endforeach
    </div>
@endsection
