<?php

namespace Katzsimon\Movie\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;
use Katzsimon\Movie\Repositories\MovieRepositoryInterface;


/**
 * Handle Movie functions for the App
 *
 * Class AppController
 * @package Katzsimon\Movie\Http\Controllers
 */
class AppController extends Controller
{

    protected $model = 'App\Models\Movie';
    protected $resource = 'Katzsimon\Movie\Resources\MovieResource';

    public function __construct(MovieRepositoryInterface $repository) {
        $this->repository = $repository;
        parent::__construct();
    }




    /**
     * Get information about a specific movie
     * @param Request $request
     * @param Movie $movie
     * @return false|\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Inertia\Response|mixed|string|null
     */
    public function movie(Request $request, Movie $movie)
    {
        $item = $this->repository->findById($movie->id);

        return $this->output(['view'=>'katzsimon::app.movie.show', 'item'=>$item]);
    }

}
