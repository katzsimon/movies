<?php

namespace Katzsimon\Cinema\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;


class Screening extends \App\Models\Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'theatre_id',
        'movie_id',
        'datetime',
    ];

    protected $ui = [
        'item'=>'screening',
    ];




    // Usually always used with Theatre and Movie
    protected $with = ['theatre', 'movie'];


    public function theatre()
    {
        return $this->hasOne('App\Models\Theatre', 'id', 'theatre_id');
    }

    public function movie()
    {
        return $this->hasOne('App\Models\Movie', 'id', 'movie_id');
    }



    /**
     * Removes the seconds from the time
     *
     * @param string $value
     * @return false|string
     */
    public function getDatetimeAttribute($value='') {
        return substr($value, 0, 16);
    }

    /**
     * Adds seconds to the time
     *
     * @param string $value
     */
    public function setDatetimeAttribute($value='') {
        if (is_string($value) && strlen($value)===16) $this->attributes['datetime'] = "{$value}:00";
        else $this->attributes['datetime'] = $value;
    }




    /**
     * Format the datetime that is easier to read for people
     *
     * @param string $value
     * @return string
     */
    public function getHumanTimeAttribute($value='') {
        return Carbon::parse("{$this->datetime}")->diffForHumans();
    }


    /**
     * Build the options for a select element
     *
     * @param array $options
     * @return array
     */
    public static function options($options=[]) {

        $items = Screening::orderBy('datetime', 'asc')->get();

        $options = [];
        $options[] = '';
        foreach ($items as $item) {
            $options[$item->id] = "{$item->theatre->cinema->name} - {$item->theatre->name} - {$item->movie->name} - {$item->datetime} ({$item->human_time})";
        }
        return $options;

    }

    /**
     * Calculates the current seats available for the Screening
     *
     * @param string $value
     * @return int
     */
    public function getSeatsAvailableAttribute($value='') {
        $maxTheatreSeats = intval($this->theatre->max_seats??0);
        $bookings = Booking::where('screening_id', $this->id)->sum('seats');
        $seatsBooked = intval($bookings);

        return $maxTheatreSeats - $seatsBooked;
    }



    /**
     * Build options for select element
     * Of the available seats that can still be booked for a specific Screening
     * Used in the Booking Page
     *
     * @return array
     */
    public function optionsSeats() {
        $maxSeats = $this->seats_available??0;

        $options = [];
        $options[''] = '';
        for ($i=1; $i<=$maxSeats; $i++) {
            $options[$i] = $i;
        }

        return $options;
    }

    /**
     * Build options for select element
     * Of Upcoming Movies only
     * Used in the Booking Page
     *
     * Optionally can pass in a list of the upcoming movies, if this is empty it will retrieve it
     *
     * @param array $upcomingMovies
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public static function optionsUpcomingMovies($upcomingMovies=[]) {

        if (empty($upcomingMovies)) {
            $repository = app()->make(\Katzsimon\Cinema\Repositories\ScreeningRepository::class);
            $items = $repository->upcomingMoviesScreening($screenings??null);
        } else {
            $items = $upcomingMovies;
        }

        $options = [];
        $options[''] = '';
        foreach ($items as $item) {
            $options[$item->id] = "{$item->name}";
        }
        return $options;
    }

    /**
     * Build options for select element
     * Of Screenings for a Specific Movie
     * Used in the Booking Page
     *
     * Parameter can be a list of Screenings or a Movie ID
     *
     * @param array $screeningsOrMovieId
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public static function optionsScreeningsForMovie($screeningsOrMovieId=[]) {

        if (is_numeric($screeningsOrMovieId)) {
            // Get the Screenings if a Movie ID is passed in
            $repository = app()->make(\Katzsimon\Cinema\Repositories\ScreeningRepository::class);
            $items = $repository->upcomingOfMovie($screenings??null);
        } else {
            $items = $screeningsOrMovieId;
        }

        $options = [];
        $options[''] = '';
        foreach ($items as $item) {
            $options[$item->id] = "{$item->theatre->cinema->name} - {$item->theatre->name} at {$item->datetime} ({$item->human_time})";
        }
        return $options;
    }



}
