<?php

namespace Katzsimon\Cinema\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class ScreeningResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        try {
            $datetime = Carbon::parse("{$this->datetime}:00");
        } catch(\Exception $e) {
            $datetime = Carbon::now();
        }

        $cinemaName = $this->theatre->cinema->name??'';
        $theatreName = $this->theatre->name??'';

        return [
            'id' => $this->id,
            'cinema_id' => $this->theatre->cinema_id??'',
            'theatre_id' => $this->theatre_id??'',
            'movie_id' => $this->movie_id??'',
            'date' => $datetime->format('Y-m-d'),
            'time' => $datetime->format('H:i'),
            'datetime_formatted' => $datetime->format('H:i \\o\\n l, j F Y'),
            'datetime' => $this->datetime,
            'movie_name' => $this->movie->name??'',
            'cinema_name' => $this->theatre->cinema->name??'',
            'theatre_name' => $this->theatre->name??'',
            'cinema_theatre_name' => $cinemaName."<br>".$theatreName,
            'seats_available'=>$this->seats_available
        ];
    }
}
