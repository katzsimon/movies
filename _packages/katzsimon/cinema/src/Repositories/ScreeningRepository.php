<?php

namespace Katzsimon\Cinema\Repositories;

use App\Models\Movie;
use App\Models\Screening;
use Illuminate\Database\Eloquent\Collection;
use Katzsimon\Base\Repositories\BaseRepository;


class ScreeningRepository extends BaseRepository implements ScreeningRepositoryInterface
{
    protected $movie;

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


    /**
     * Get the all the Upcoming Screenings
     *
     * @param string $order
     * @return Collection
     */
    public function upcomingScreenings($order='asc'): Collection
    {
        return $this->newQuery()->where('datetime', '>=', Date('Y-m-d H:i:s'))->orderBy('datetime', $order)->get();
    }


    /**
     * Get all the Past Screenings
     *
     * @param string $order
     * @return Collection
     */
    public function pastScreenings($order='asc'): Collection
    {
        return $this->newQuery()->where('datetime', '<', Date('Y-m-d H:i:s'))->orderBy('datetime', $order)->get();
    }

    /**
     * Return Movies that have Upcoming Screening
     *
     * @param array $order
     * @return Collection
     */
    public function upcomingMovies($order=[]): Collection
    {

        $orderField = $order[0] ?? 'datetime';
        $orderSort = $order[1] ?? 'asc';

        return $this->movie->newQuery()->select('*', 'movies.id as id')
            ->with('screenings')
            ->join('screenings', 'screenings.movie_id', '=', 'movies.id')
            ->where('screenings.datetime', '>=', Date('Y-m-d H:i:s'))
            ->groupBy('screenings.movie_id')
            ->get();

    }

    /**
     * Return all Upcoming Screenings of a particular Movie
     *
     * @param null $movieId
     * @param string $order
     * @return Collection
     */
    public function upcomingOfMovie($movieId=null, $order='asc'): Collection
    {
        return $this->newQuery()->where('movie_id', $movieId)->where('datetime', '>=', Date('Y-m-d H:i:s'))->orderBy('datetime', $order)->get();
    }

    /**
     * Get some Featured Movies
     * These are just Movies taken at random
     * Used in the App Home page
     *
     * @param int $limit
     * @return Collection
     */
    public function featuredMovies($limit=3): Collection
    {
        return $this->movie->newQuery()->select('*', 'movies.id as id')
            ->with('screenings')
            ->join('screenings', 'screenings.movie_id', '=', 'movies.id')
            ->where('screenings.datetime', '>=', Date('Y-m-d H:i:s'))
            ->groupBy('screenings.movie_id')
            ->orderByRaw('RAND()')
            ->limit($limit)
            ->get();
    }

}
