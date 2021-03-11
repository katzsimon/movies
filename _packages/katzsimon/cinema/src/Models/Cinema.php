<?php

namespace Katzsimon\Cinema\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Cinema extends \App\Models\Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'location',
        'name',
    ];

    protected $ui = [
        'item'=>'cinema',
    ];

    // Cinemas and Theatres are usually always used together
    protected $withCount = ['theatres'];

    public function theatres()
    {
        return $this->hasMany('App\Models\Theatre', 'cinema_id', 'id');
    }


    /**
     * Build options for select element
     *
     * @param array $options
     * @return array
     */
    public static function options($options=[]) {

        $items = Cinema::orderBy('name', 'asc')->get();

        $options = [];
        $options[] = '';
        foreach ($items as $item) {
            $options[$item->id] = $item->name;
        }
        return $options;
    }

}
