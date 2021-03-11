<?php

namespace Katzsimon\Movie\Http\Controllers;


use App\Http\Requests\AdminMovieRequest;
use App\Models\Movie;
use Illuminate\Http\Request;
use Katzsimon\Base\Http\Controllers\Controller;
use Katzsimon\Movie\Repositories\MovieRepositoryInterface;
use Katzsimon\Movie\Resources\MovieResource;


/**
 * Movie CRUD for Admin Section
 *
 * Class MovieController
 * @package Katzsimon\Movie\Http\Controllers
 */
class MovieController extends Controller
{

    protected $admin = true;
    protected $model = 'App\Models\Movie';
    protected $resource = 'Katzsimon\Movie\Resources\MovieResource';

    public function __construct(MovieRepositoryInterface $repository) {
        $this->repository = $repository;
        parent::__construct();
    }

    /**
     * List all the movies
     * With a distinct list of the Movie Genres for filtering
     *
     * @param Request $request
     * @param string $genre
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Inertia\Response|void
     */
    public function index(Request $request, $genre='')
    {
        if (empty($genre) || $genre==='All') {
            $items = $this->repository->all('desc');
        } else {
            $items = $this->repository->getByCriteria(['genre'=>$genre], ['orderBy'=>'id desc']);
        }

        $genres = $this->repository->getGenres();

        $data = [
            'data'=>MovieResource::collection($items)->toArray(request()),
            'genres'=>$genres,
        ];

        return $this->output(['view'=>'katzsimon::admin.movies.index', 'data'=>$data]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @param Movie $item
     * @return false|\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Inertia\Response|mixed|string|null
     */
    public function create(Movie $item)
    {
        $item = $this->repository->empty();

        return $this->output(['view'=>'katzsimon::admin.movies.create', 'data'=>['item'=>$item]]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param AdminMovieRequest $request
     * @return false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function store(AdminMovieRequest $request)
    {

        $item = $this->repository->create( $request->validated() );

        return $this->redirect(['route'=>'admin.movies.index', 'item'=>$item]);
    }

    /**
     * Show the specific resource
     *
     * @param Movie $item
     * @return false|\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Inertia\Response|mixed|string|null
     */
    public function show(Movie $item)
    {
        //
        return $this->output(['view'=>'katzsimon::admin.movies.show', 'item'=>$item]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Movie $item
     * @return false|\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Inertia\Response|mixed|string|null
     */
    public function edit(Movie $item)
    {
        //
        return $this->output(['view'=>'katzsimon::admin.movies.edit', 'item'=>$item]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AdminMovieRequest $request
     * @param Movie $item
     * @return false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function update(AdminMovieRequest $request, Movie $item)
    {
        //
        $item = $this->repository->update( $item, $request->validated() );

        return $this->redirect(['route'=>'admin.movies.index', 'item'=>$item]);
    }

    /**
     * Delete the Movie
     * THe movie can only be deleted if it has no Screenings
     *
     * @param Request $request
     * @param Movie $item
     * @return false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     * @throws \Exception
     */
    public function destroy(Request $request, Movie $item)
    {
        //
        $item->delete();
        return $this->redirect(['route' => 'admin.movies.index', 'item' => $item]);

    }

    /**
     * Delete the Movie with its Screenings
     *
     * @param Request $request
     * @param Movie $item
     * @return false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     * @throws \Exception
     */
    public function destroyWithScreenings(Request $request, Movie $item)
    {
        //
        $item->screenings()->delete();
        $item->delete();
        return $this->redirect(['route' => 'admin.movies.index', 'item' => $item, 'with'=>['message'=>"Movie has been deleted with it's Screenings"]]);

    }

}
