<?php

namespace Tests\Feature;


class MovieTest extends \Tests\BaseCRUDTest
{


    public function setUp():void
    {

        $this->model = app()->make(\App\Models\Movie::class);
        $this->baseUrl = '/admin/movies';

        parent::setUp();

    }

}
