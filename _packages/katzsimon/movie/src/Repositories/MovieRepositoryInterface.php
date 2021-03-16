<?php

namespace Katzsimon\Movie\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Katzsimon\Base\Repositories\BaseRepositoryInterface;

interface MovieRepositoryInterface extends BaseRepositoryInterface
{


    /**
     * @return array
     */
    public function getGenres():array;


}
