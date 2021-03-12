<?php

namespace Katzsimon\Cinema\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class Theatre extends \App\Models\Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cinema_id',
        'name',
        'max_seats',
    ];

    protected $ui = [
        'item'=>'theatre',
        'parent'=>'cinema',
        'url_index'=>'/admin/cinemas/{params}/theatres'
    ];

    protected $with = ['cinema'];


    public function cinema()
    {
        return $this->belongsTo('App\Models\Cinema', 'cinema_id', 'id');
    }

    public function screenings()
    {
        return $this->hasMany('App\Models\Screening', 'theatre_id', 'id');
    }

    /**
     * Build the options for a select element
     *
     * @param array $options
     * @return array
     */
    public static function options($options=[]) {

        $items = Theatre::orderBy('name', 'asc')->orderBy('cinema_id')->with('cinema')->get();

        $options = [];
        $options[] = '';
        foreach ($items as $item) {
            $cinemaName = $item->cinema->name??'';
            $theatreName = $item->name??'';
            $options[$item->id] = "{$cinemaName} - {$theatreName}";
        }
        return $options;
    }



}
