<?php

namespace Katzsimon\Cinema\Repositories;

use App\Models\Cinema;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Katzsimon\Base\Repositories\BaseRepository;


class CinemaRepository extends BaseRepository implements CinemaRepositoryInterface
{

    /**
     * CinemaRepository constructor.
     *
     * @param Cinema $model
     */
    public function __construct(Cinema $model)
    {
        parent::__construct($model);
    }




}
