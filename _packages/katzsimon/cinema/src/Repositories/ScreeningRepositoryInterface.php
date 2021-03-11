<?php

namespace Katzsimon\Cinema\Repositories;


use Illuminate\Database\Eloquent\Collection;
use Katzsimon\Base\Repositories\BaseRepositoryInterface;

interface ScreeningRepositoryInterface extends BaseRepositoryInterface
{

    /**
     * @param string $order
     * @return Collection
     */
    public function upcomingScreenings($order='asc'): Collection;

    /**
     * @param string $order
     * @return Collection
     */
    public function pastScreenings($order='asc'): Collection;

}
