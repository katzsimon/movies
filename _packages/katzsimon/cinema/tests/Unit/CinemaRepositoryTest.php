<?php

namespace Tests\Unit;

use Tests\BaseRepositoryTest;

class CinemaRepositoryTest extends BaseRepositoryTest
{

    /**
     * Test the Movie Repository
     */

    public function setUp():void
    {
        parent::setUp();

        $this->repository = app()->make(\Katzsimon\Cinema\Repositories\CinemaRepository::class);
    }


}
