<?php

namespace Tests\Feature;

class BookingTest extends \Tests\BaseCRUDTest
{


    public function setUp():void
    {

        $this->model = app()->make(\App\Models\Booking::class);
        $this->baseUrl = '/admin/bookings';

        parent::setUp();

    }

}
