<?php

namespace Katzsimon\Cinema\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class BookingScreeningResource extends JsonResource
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

        return [
            'value' => $this->id,
            'text' => $datetime->format('H:i \\o\\n l, j F Y')." at {$this->theatre->cinema->name}, {$this->theatre->name}",
        ];
    }
}
