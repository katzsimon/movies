<?php

namespace Katzsimon\Movie\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;


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
