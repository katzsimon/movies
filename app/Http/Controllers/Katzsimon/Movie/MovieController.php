<?php namespace App\Http\Controllers\Katzsimon\Movie;

use App\Models\Movie;
use Illuminate\Http\Request;
use Katzsimon\Movie\Resources\MovieResource;

class MovieController extends \Katzsimon\Movie\Http\Controllers\MovieController
{

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
            $items = $this->repository->all('desc', ['screenings']);
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
