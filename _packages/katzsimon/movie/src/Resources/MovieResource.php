<?php

namespace Katzsimon\Movie\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
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
            'genre' => $this->genre??'',
            'runtime' => $this->runtime??'',
            'rating' => $this->rating??'',
            'starring' => $this->starring??'',
            'description' => $this->description??'',
            'screening_count' => count($this->future_screenings)
        ];
    }
}
