<?php

namespace Tests\Feature;

class CinemaTest extends \Tests\BaseCRUDTest
{


    public function setUp():void
    {

        $this->model = app()->make(\App\Models\Cinema::class);
        $this->baseUrl = '/admin/cinemas';

        parent::setUp();

    }

}
