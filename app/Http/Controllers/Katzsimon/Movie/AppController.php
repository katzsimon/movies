<?php namespace App\Http\Controllers\Katzsimon\Movie;

use Illuminate\Cache\Repository;
use Illuminate\Http\Request;
use Katzsimon\Cinema\Repositories\ScreeningRepositoryInterface;

class AppController extends \Katzsimon\Movie\Http\Controllers\AppController
{



    /**
     * List all the Movies
     * Include the Screening data if it exists
     *
     * @param Request $request
     * @return false|\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Inertia\Response|mixed|string|null
     */
    public function movies(Request $request, ScreeningRepositoryInterface $repositryScreening)
    {

        $items = $repositryScreening->upcomingMovies();

        return $this->output(['view'=>'katzsimon::app.movie.index', 'items'=>$items]);
    }

}
