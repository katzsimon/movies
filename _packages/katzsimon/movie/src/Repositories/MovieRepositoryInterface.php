<?php

namespace Katzsimon\Movie\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Katzsimon\Base\Repositories\BaseRepositoryInterface;

interface MovieRepositoryInterface extends BaseRepositoryInterface
{



    public function getGenres():array;

    public function upcomingMoviesScreening($order=[]): Collection;
}
