<?php

namespace Katzsimon\Cinema\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class BookingResource extends JsonResource
{


    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $theatreName = $this->screening->theatre->name??'Theatre does not exist anymore';
        $cinemaName = $this->screening->theatre->cinema->name??'Cinema does not exist anymore';
        $movieName = $this->screening->movie->name??'Movie does not exist anymore';
        $humanTime = $this->screening->human_time??'';
        $userName = $this->user->name??'';
        $userEmail = $this->user->email??'';
        return [
            'id' => $this->id,
            'user_id' => $this->user_id??0,
            'user_name' => $this->user->name??'',
            'user_email' => $this->user->email??'',
            'user_details' => "{$userName}<br>{$userEmail}",
            'screening_id' => $this->screening_id??0,
            'screening_movie'=>$movieName,
            'movie_name'=>$movieName,
            'screening_cinema'=>$cinemaName,
            'screening_theatre'=>$theatreName,
            'screening_cinema_theatre'=>"{$cinemaName}<br>{$theatreName}",
            'screening_when'=>Carbon::parse($this->datetime)->format("Y-m-d \\a\\t H:i")." ({$humanTime})",
            'movie_id'=>$this->screening->movie_id??'',
            'datetime'=>$this->screening->datetime??'',
            'can_cancel'=>$this->screening->can_cancel??false,
            'seats' => $this->seats??0,
            'reference' => $this->reference??'',
        ];
    }
}
