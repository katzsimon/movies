<?php

namespace Katzsimon\Cinema\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Katzsimon\Cinema\Repositories\ScreeningRepository;
use Laravel\Sanctum\HasApiTokens;

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

        $items = Screening::orderBy('date', 'asc')->orderBy('time', 'asc')->get();

        $options = [];
        $options[] = '';
        foreach ($items as $item) {
            $options[$item->id] = "{$item->theatre->cinema->name} - {$item->theatre->name} - {$item->movie->name} - {$item->datetime} ({$item->human_time})";
        }
        return $options;

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


}
