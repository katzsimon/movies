<?php

namespace Katzsimon\Cinema\Http\Controllers;



use App\Models\Movie;
use Illuminate\Http\Request;
use Katzsimon\Cinema\Repositories\BookingRepositoryInterface;
use Katzsimon\Cinema\Repositories\ScreeningRepositoryInterface;
use Katzsimon\Cinema\Repositories\TheatreRepositoryInterface;
use Katzsimon\Base\Http\Controllers\Controller;
use Katzsimon\Cinema\Repositories\CinemaRepositoryInterface;
use Katzsimon\Movie\Repositories\MovieRepositoryInterface;
use Katzsimon\Movie\Resources\MovieResource;


/**
 * Class that handles most of listing the Apps details
 * Cinemas...lists the Cinemas and what Movies are screening at them
 * Movies...lists the Movies and where/when they are Screening
 *
 * Class AppController
 * @package Katzsimon\Cinema\Http\Controllers
 */
class AppController extends Controller
{

    protected $model = 'App\Models\Screening';
    protected $resource = 'Katzsimon\Cinema\Resources\ScreeningResource';
    protected $repositoryScreening = null;
    protected $repositoryMovie = null;
    protected $repositoryBooking = null;
    protected $repositoryCinema = null;
    protected $repositoryTheatre = null;


    /**
     * Bind the needed Repositories
     *
     * AppController constructor.
     * @param ScreeningRepositoryInterface $repositoryScreening
     * @param MovieRepositoryInterface $repositoryMovie
     * @param BookingRepositoryInterface $repositoryBooking
     * @param CinemaRepositoryInterface $repositoryCinema
     * @param TheatreRepositoryInterface $repositoryTheatre
     */
    public function __construct(ScreeningRepositoryInterface $repositoryScreening,
                                MovieRepositoryInterface $repositoryMovie,
                                BookingRepositoryInterface $repositoryBooking,
                                CinemaRepositoryInterface $repositoryCinema,
                                TheatreRepositoryInterface $repositoryTheatre
    ) {
        $this->repositoryScreening = $repositoryScreening;
        $this->repositoryMovie = $repositoryMovie;
        $this->repositoryBooking = $repositoryBooking;
        $this->repositoryCinema = $repositoryCinema;
        $this->repositoryTheatre = $repositoryTheatre;
        parent::__construct();
    }


    /**
     * List all the Movies in the database
     *
     * @param Request $request
     * @return false|\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Inertia\Response|mixed|string|null
     */
    public function movies(Request $request) {

        $items = $this->repositoryScreening->upcomingMovies();

        $items = MovieResource::collection($items);

        return $this->output(['view'=>'katzsimon::app.screenings.movies', 'items'=>$items, 'resource'=>'Katzsimon\Movie\Resources\MovieResource' ]);
    }


    /**
     * List the Cinemas
     *
     * @param Request $request
     * @return false|\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Inertia\Response|mixed|string|null
     */
    public function indexCinemas(Request $request) {

        $data = [
            'data' => $this->repositoryCinema->getCinemasWithMovies(),
        ];

        return $this->output(['view'=>'katzsimon::app.cinemas.index', 'data'=>$data ]);
    }




    /**
     * Get the Upcoming Screenings of a specific movie.
     * To show the user where a Movie is screening
     *
     * @param Request $request
     * @param Movie $movie
     * @return false|\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Inertia\Response|mixed|string|null
     */
    public function upcomingMovieScreenings(Request $request, Movie $movie) {


        $data = [
            'items'=>$this->repositoryScreening->upcomingOfMovie($movie->id),
            'movie'=>new MovieResource($movie)
        ];
        return $this->output(['view'=>'katzsimon::app.screenings.index', 'data'=>$data]);
    }

    /**
     * Get a list of all the Upcoming Movies
     *
     * @param Request $request
     * @return false|\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Inertia\Response|mixed|string|null
     */
    public function upcomingMovies(Request $request)
    {

        $items = $this->repositoryScreening->upcomingMovies();

        $data = [
            'items' => MovieResource::collection($items)
        ];

        return $this->output(['view'=>'katzsimon::app.screenings.movies', 'data'=>$data, ]);
    }

}
