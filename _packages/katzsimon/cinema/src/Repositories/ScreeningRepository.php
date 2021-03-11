<?php

namespace Katzsimon\Cinema\Repositories;

use App\Models\Movie;
use App\Models\Screening;
use Illuminate\Database\Eloquent\Collection;
use Katzsimon\Base\Repositories\BaseRepository;


class ScreeningRepository extends BaseRepository implements ScreeningRepositoryInterface
{

    /**
     * ScreeningRepository constructor.
     * @param Screening $model
     * @param Movie $movie
     */
    public function __construct(Screening $model, Movie $movie)
    {
        $this->movie = $movie;
        parent::__construct($model);
    }

}
