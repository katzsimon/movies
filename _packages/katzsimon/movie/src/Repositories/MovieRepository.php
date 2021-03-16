<?php

namespace Katzsimon\Movie\Repositories;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Katzsimon\Base\Repositories\BaseRepository;


class MovieRepository extends BaseRepository implements MovieRepositoryInterface
{

    /**
     * MovieRepository constructor.
     *
     * @param Movie $model
     */
    public function __construct(Movie $model)
    {
        parent::__construct($model);
    }





    /**
     * Get the unique genres from the movies that are in the database
     *
     * @return array
     */
    public function getGenres():array {

        $results = Movie::select('genre', DB::raw('count(*) as count'))
            ->groupBy('genre')
            ->get();

        $genres[] = [
            'title'=>'All',
            'count'=>Movie::count()
        ];

        foreach ($results as $result) {
            if (!empty($result->genre)) {
                $genres[] = [
                    'title' => $result->genre,
                    'count' => $result->count
                ];
            }
        }


        return $genres;
    }




}
