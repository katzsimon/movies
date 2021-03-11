<?php

namespace Tests\Unit;

use Tests\BaseRepositoryTest;

class BookingRepositoryTest extends BaseRepositoryTest
{

    public function setUp():void
    {
        parent::setUp();

        $this->repository = app()->make(\Katzsimon\Cinema\Repositories\BookingRepository::class);
    }



}
