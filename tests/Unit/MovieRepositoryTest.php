<?php

namespace Tests\Unit;

use Tests\BaseRepositoryTest;

class MovieRepositoryTest extends BaseRepositoryTest
{

    /**
     * Test the Movie Repository
     */

    public function setUp():void
    {
        parent::setUp();

        $this->repository = app()->make(\Katzsimon\Movie\Repositories\MovieRepository::class);
    }

}
