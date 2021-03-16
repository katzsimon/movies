<?php

namespace Katzsimon\Cinema\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Booking extends \App\Models\Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'screening_id',
        'reference',
        'seats'
    ];

    protected $ui = [
        'item'=>'booking',
    ];

    protected $cancelMinutesThreshold = 60;

    // Always used with the Screening to display the needed information
    protected $with = ['screening'];

    public function screening()
    {
        return $this->hasOne('App\Models\Screening', 'id', 'screening_id');
    }

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public static function boot()
    {
        parent::boot();

        static::saving(function($item) {
            if (empty($item->reference)) {
                // Create a random reference if it is empty
                $item->reference = Str::random(8);
            }
        });

    }

    /**
     * Only cancel the Booking if it is more than $cancelMinutesThreshold minutes in the Future
     *
     * Set $deleteBooking to false to only check if it can be cancelled but not actually cancel it
     *   Used to check if the "Cancel Booking" button should be showed
     *
     * @param bool $deleteBooking
     * @return bool
     * @throws \Exception
     */
    public function cancelBooking($deleteBooking=true) {


        if (empty($this->screening)) {
            if ($deleteBooking) {
                $this->delete();
                return true;
            } else {
                return false;
            }
        }

        $datetimeBooking = Carbon::parse("{$this->screening->datetime}:00");
        $now = Carbon::now();

        // Check if the Screening time is more than 60 minutes in the future
        $diff = $now->diffInMinutes($datetimeBooking, false);
        if ($diff>$this->cancelMinutesThreshold) {
            // Only cancel the Booking is more than 60 minutes in the future
            if($deleteBooking) $this->delete();
            return true;
        }

        // Don't cancel the booking if the screening is in the next 60 minutes
        return false;

    }


    /**
     * Check if the Booking can be cancelled
     *
     * @return bool
     * @throws \Exception
     */
    public function getCanCancelAttribute() {
        return $this->cancelBooking(false);
    }


}
