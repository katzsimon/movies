@extends('katzsimon::templates.app')

@section('title')
    Make a Booking
@endsection

@section('content')
    <div class="box">

        {!! Form::open(['url' => route('booking.handle'), 'method'=>'post']) !!}

        <x-formfield type="select" name="movie_id" label="Select The Movie" :options="$movie_options" :value="$movie_id"></x-formfield>

        <x-formfield type="select" name="screening_id" label="Select The Screening" :options="$screening_options" :value="$screening_id"></x-formfield>

        <x-formfield type="select" name="seats" label="Number Of Seats To Book" :options="$seat_options"></x-formfield>

        <button type="submit" class="btn btn-primary">Book Now</button>

        {!! Form::close() !!}

    </div>
    <script type="text/javascript">
        window.addEventListener("DOMContentLoaded", function(event) {
        (function() {
            let movie = document.querySelector("#movie_id");
            let screening = document.querySelector("#screening_id");
            let seats = document.querySelector("#seats");

            movie.addEventListener('change', function (e) {
                window.location = '{{ URL::to('/booking/movie') }}/'+movie.value;
            });

            screening.addEventListener('change', function (e) {
                window.location = '{{ URL::to('/booking/screening') }}/'+screening.value;
            });

        	function booking(source) {

        	    source = source || '';
                let url = `/booking`;

                if (source==='movie') {
                    const movieId = movie.value;
                    url = `/booking/movie/${movieId}`;
                } else if (source==='screening') {
                    const screeningId = screening.value;
                    url = `/booking/screening/${screeningId}`;
                }


                fetch(url, {
                    method: 'GET',
                    headers: {
                        'FORCE-CONTENT-TYPE': 'application/json',
                    },
                })
                .then(response => {
                    return response.json();
                })
                .then((data) => {

                    updateOptions(movie, data.movie_options);
                    updateOptions(screening, data.screening_options);
                    updateOptions(seats, data.seat_options);

                    //console.log('screening_options: ', data.screening_options);
                    //console.log('movie_options: ', data.movie_options);
                    //let movieOptions = JSON.parse(data.movie_options);
                    //console.log('movieOptions: ', movieOptions);
                    //let screeningOptions = JSON.parse(data.screening_options);
                    //console.log('screening_options: ', movieOptions.length, data.screening_options);
                    //console.log('movie_options: ', screeningOptions.length, data.movie_options);

                });

            }

            function updateOptions(obj, newOptions) {
                let currentValue = obj.value;

                let output = '<option value=""></option>';
                for (const [value, text] of Object.entries(newOptions)) {
                    if (value!=='') output += `<option value="${value}">${text}</option>`;
                }

                obj.innerHTML = output;

                obj.value = '';
                obj.value = currentValue;
            }
        }());
        });
    </script>
@endsection
