<?php

namespace Tests\Feature;


class ScreeningTest extends \Tests\BaseCRUDTest
{


    public function setUp():void
    {

        $this->model = app()->make(\App\Models\Screening::class);
        $this->baseUrl = '/admin/screenings';

        parent::setUp();

    }

}
