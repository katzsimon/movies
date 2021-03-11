<?php

namespace Katzsimon\Cinema\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TheatreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'name' => $this->name??'',
            'cinema_id' => $this->cinema->id??'',
            'cinema_name' => $this->cinema->name??'',
            'theatre_name' => $this->name,
            'max_seats' => $this->max_seats??0
        ];
    }
}
