<?php

namespace Katzsimon\Cinema\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingMovieResource extends JsonResource
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
            'value' => $this->id,
            'text' => $this->name??'',
        ];
    }
}
