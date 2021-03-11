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
                $item->reference = Str::random(8);
            }
        });

    }



}
