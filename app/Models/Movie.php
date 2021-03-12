<?php namespace App\Models;

class Movie extends \Katzsimon\Movie\Models\Movie
{

    public function screenings()
    {
        return $this->hasMany('App\Models\Screening', 'movie_id', 'id');
    }

    public function future_screenings()
    {
        return $this->hasMany('App\Models\Screening', 'movie_id', 'id')->where('datetime', '>=', Date('Y-m-d H:i:s'));
    }

}
