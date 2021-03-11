<?php

namespace Katzsimon\Cinema\Repositories;

use App\Models\Cinema;
use App\Models\Theatre;
use Illuminate\Support\Collection;
use Katzsimon\Base\Repositories\BaseRepository;


class TheatreRepository extends BaseRepository implements TheatreRepositoryInterface
{

    /**
     * TheatreRepository constructor.
     * @param Theatre $model
     */
    public function __construct(Theatre $model)
    {
        parent::__construct($model);
    }

}
