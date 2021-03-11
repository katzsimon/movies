<?php

namespace Katzsimon\Movie\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Movie extends \App\Models\Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'name',
        'genre',
        'runtime',
        'rating',
        'description',
        'starring'
    ];

    protected $ui = [
        'item'=>'movie',
    ];

    public function screenings()
    {
        return $this->hasMany('App\Models\Screening', 'movie_id', 'id');
    }

    public function future_screenings()
    {
        return $this->hasMany('App\Models\Screening', 'movie_id', 'id')->where('datetime', '>=', Date('Y-m-d H:i:s'));
    }

    public static function options($options=[]) {
        $items = Movie::orderBy('name', 'asc')->get();

        $options = [];
        $options[''] = '';
        foreach ($items as $item) {
            $options[$item->id] = $item->name;
        }
        return $options;
    }

}
