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


    /**
     * Get a list of the Cinemas, with their Upcoming Movies and Screenings
     * Used for the App / Cinemas page
     *
     * @return array
     */
    public function getCinemasWithMovies(): array
    {
        $results = DB::table('cinemas')
            ->leftJoin('theatres', 'cinemas.id', '=', 'theatres.cinema_id')
            ->leftJoin('screenings', 'theatres.id', '=', 'screenings.theatre_id')
            ->leftJoin('movies', 'screenings.movie_id', '=', 'movies.id')
            ->select('cinemas.name as cinema', 'cinemas.location as location', 'theatres.name as theatre', 'movies.name as movie', 'movies.id as movie_id')
            ->where('screenings.datetime', '>', Date('Y-m-d H:i:s'))
            ->get();

        $data = [];
        foreach ($results as $result) {
            if (!isset($data[$result->cinema])) $data[$result->cinema] = ['location'=>$result->location, 'movies'=>[]];
            if (!isset($data[$result->cinema]['movies'][$result->movie_id])) $data[$result->cinema]['movies'][$result->movie_id] = $result->movie;
        }

        return $data;

    }


}
