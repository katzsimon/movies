<?php

namespace Katzsimon\Cinema\Repositories;

use Katzsimon\Base\Repositories\BaseRepositoryInterface;

interface CinemaRepositoryInterface extends BaseRepositoryInterface
{

    /**
     * @return array
     */
    public function getCinemasWithMovies(): array;

}
