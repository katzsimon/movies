<?php namespace App\Models;

class Model extends \Katzsimon\Base\Models\Model
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
