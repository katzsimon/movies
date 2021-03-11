<?php

namespace Katzsimon\Cinema\Repositories;

use App\Models\Cinema;
use Illuminate\Support\Collection;
use Katzsimon\Base\Repositories\BaseRepositoryInterface;

interface TheatreRepositoryInterface extends BaseRepositoryInterface
{

    /**
     * @param Cinema $parent
     * @param string $order
     * @return Collection
     */
    public function allFromCinema(Cinema $parent, $order='asc'): Collection;

}
