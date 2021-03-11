<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\DB;
use Tests\BaseRepositoryTest;

class ScreeningRepositoryTest extends BaseRepositoryTest
{

    /**
     * Test the Movie Repository
     */

    protected $repositoryMovie;

    public function setUp():void
    {
        parent::setUp();

        $this->repository = app()->make(\Katzsimon\Cinema\Repositories\ScreeningRepository::class);
        $this->repositoryMovie = app()->make(\Katzsimon\Movie\Repositories\MovieRepository::class);

        if ($this->truncateTables) {
            $this->repository->truncate();
            $this->repositoryMovie->truncate();
        }

    }



}
