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


    public function getWithScreenings($order='asc'): Collection
    {
        return $this->newQuery()->with('future_screenings')->orderBy('id', $order)->get();
    }


    /**
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

    /**
     * @param array $order
     * @return Collection
     */
    public function upcomingMoviesScreening($order=[]): Collection
    {

        $orderField = $order[0] ?? 'datetime';
        $orderSort = $order[1] ?? 'asc';


        return $this->newQuery()->select('*', 'movies.id as id')
            ->where('movies.id', '>', 0)
            ->join('screenings', 'screenings.movie_id', '=', 'movies.id')
            ->groupBy('screenings.movie_id')
            ->get();

        //return Screening::where('datetime', '>=', Date('Y-m-d H:i:s'))->groupBy('movie_id')->with('movie')->orderBy($orderField, $orderSort)->get();
        //->where('time', '>=', Date('H:i:s'))
        //return $this->newQuery()->where('datetime', '>=', Date('Y-m-d H:i:s'))->orderBy('datetime', $order)->get();
        //return $this->newQuery()->where('date', '>=', Date('Y-m-d'))->orderBy('date', $order)->orderBy('time', $order)->get();
    }


}
