<?php

namespace Katzsimon\Cinema\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CinemaResource extends JsonResource
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
            'name' => $this->name,
            'location' => $this->location,
            'theatres_count' => $this->theatres_count
        ];
    }
}
