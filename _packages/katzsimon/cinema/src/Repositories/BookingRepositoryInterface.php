<?php

namespace Katzsimon\Cinema\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Katzsimon\Base\Repositories\BaseRepositoryInterface;

interface BookingRepositoryInterface extends BaseRepositoryInterface
{


    /**
     * @param int $limit
     * @param string $order
     * @return Collection
     */
    public function getUpcoming($limit=5, $order='asc'): Collection;


}
