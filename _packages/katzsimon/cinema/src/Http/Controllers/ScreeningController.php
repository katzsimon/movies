<?php

namespace Katzsimon\Cinema\Http\Controllers;


use App\Http\Requests\AdminScreeningRequest;
use App\Models\Screening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Katzsimon\Cinema\Repositories\ScreeningRepositoryInterface;
use Katzsimon\Cinema\Resources\ScreeningResource;
use Katzsimon\Base\Http\Controllers\Controller;



class ScreeningController extends Controller
{

    protected $model = 'App\Models\Screening';
    protected $resource = 'Katzsimon\Cinema\Resources\ScreeningResource';
    protected $admin = true;


    public function __construct(ScreeningRepositoryInterface $repository) {
        $this->repository = $repository;
        parent::__construct();
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return false|\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Inertia\Response|mixed|string|null
     */
    public function index(Request $request)
    {
        $upcomingScreenings = $this->repository->upcomingScreenings('desc');
        $pastScreenings = $this->repository->pastScreenings('desc');

        $data = [
            'pastScreenings'=>ScreeningResource::collection($pastScreenings)->toArray(request()),
            'upcomingScreenings'=>ScreeningResource::collection($upcomingScreenings)->toArray(request())
        ];

        return $this->output(['view'=>"katzsimon::admin.{$this->ui['items']}.index", 'data'=>$data]);
    }


    /**
     * Display a listing of only the upcoming Screenings
     *
     * @param Request $request
     * @return false|\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Inertia\Response|mixed|string|null
     */
    public function indexUpcoming(Request $request)
    {

        $items = $this->repository->upcoming();

        return $this->output(['view'=>"katzsimon::admin.{$this->ui['items']}.index", 'items'=>$items]);
    }


    /**
     * Show the form for creating a new resource
     *
     * @param Screening $item
     * @return false|\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Inertia\Response|mixed|string|null
     */
    public function create(Screening $item)
    {

        $item = new ScreeningResource($item);

        $data = [
            'item'=>$item->toArray(request()),
            'movie_options'=>\App\Models\Movie::options(),
            'theatre_options'=>\App\Models\Theatre::options()
        ];

        return $this->output(['view'=>"katzsimon::admin.{$this->ui['items']}.create", 'data'=>$data]);
    }


    /**
     * Save the resource
     *
     * @param AdminScreeningRequest $request
     * @return false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function store(AdminScreeningRequest $request)
    {
        $item = $this->repository->create( $request->validated() );

        return $this->redirect(['route'=>"admin.{$this->ui['items']}.index"]);
    }


    /**
     * Display the specified resource.
     *
     * @param Screening $item
     * @return false|\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Inertia\Response|mixed|string|null
     */
    public function show(Screening $item)
    {
        //
        return $this->output(['item'=>$item]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Screening $item
     * @return false|\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Inertia\Response|mixed|string|null
     */
    public function edit(Screening $item)
    {
        //
        $data = [
            'item'=>new ScreeningResource($item),
            'movie_options'=>\App\Models\Movie::options(),
            'theatre_options'=>\App\Models\Theatre::options()
        ];

        return $this->output(['view'=>"katzsimon::admin.{$this->ui['items']}.edit", 'data'=>$data]);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param AdminScreeningRequest $request
     * @param Screening $item
     * @return false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function update(AdminScreeningRequest $request, Screening $item)
    {
        //
        $this->repository->update( $item, $request->validated() );

        return $this->redirect(['route'=>"admin.{$this->ui['items']}.index"]);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Screening $movie
     * @return false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     * @throws \Exception
     */
    public function destroy(Screening $movie)
    {
        //
        $movie->delete();

        return $this->redirect(['route'=>"admin.{$this->ui['items']}.index"]);

    }
}
