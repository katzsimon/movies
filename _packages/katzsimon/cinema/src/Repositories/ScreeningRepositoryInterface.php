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

    /**
     * @param array $order
     * @return Collection
     */
    public function upcomingMovies($order=[]): Collection;

    /**
     * @param null $movieId
     * @param string $order
     * @return Collection
     */
    public function upcomingOfMovie($movieId=null, $order='asc'): Collection;


    /**
     * @param int $limit
     * @return Collection
     */
    public function featuredMovies($limit=3): Collection;
}
