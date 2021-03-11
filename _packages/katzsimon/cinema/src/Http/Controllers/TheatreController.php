<?php

namespace Katzsimon\Cinema\Http\Controllers;



use App\Http\Requests\AdminTheatreRequest;
use App\Models\Cinema;
use App\Models\Theatre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Katzsimon\Cinema\Repositories\TheatreRepositoryInterface;
use Katzsimon\Cinema\Resources\TheatreResource;
use Katzsimon\Base\Http\Controllers\Controller;

/**
 * Admin CRUD for Theatre Model
 *
 * Class TheatreController
 * @package Katzsimon\Cinema\Http\Controllers
 */
class TheatreController extends Controller
{

    protected $model = 'App\Models\Theatre';
    protected $resource = 'Katzsimon\Cinema\Resources\TheatreResource';
    protected $admin = true;

    public function __construct(TheatreRepositoryInterface $repository) {
        $this->repository = $repository;
        parent::__construct();
    }

    /**
     *
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Inertia\Response|void
     */
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Cinema|null $parent
     * @return false|\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Inertia\Response|mixed|string|null
     */
    public function index(Request $request, Cinema $parent=null)
    {
        $items = $this->repository->allFromCinema($parent, 'desc');

        $items = TheatreResource::collection($items)->toArray(request());

        return $this->output(['view'=>"katzsimon::admin.{$this->ui['items']}.index", 'parent'=>$parent, 'data'=>['items'=>$items, 'parent'=>$parent]]);
    }


    /**
     *
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Inertia\Response|void
     */
    /**
     * Show the form for creating a new resource.
     *
     * @param Theatre $item
     * @param Cinema|null $parent
     * @return false|\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Inertia\Response|mixed|string|null
     */
    public function create(Theatre $item, Cinema $parent=null)
    {
        $item = $this->repository->empty();

        return $this->output(['view'=>"katzsimon::admin.{$this->ui['items']}.create", 'parent'=>$parent, 'data'=>['item'=>$item, 'parent'=>$parent]]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AdminTheatreRequest $request
     * @param Cinema|null $parent
     * @return false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function store(AdminTheatreRequest $request, Cinema $parent=null)
    {
        //
        $item = $this->repository->create( $request->validated() );

        return $this->redirect(['route'=>"admin.{$this->ui['parent-items']}.{$this->ui['items']}.index", 'params'=>[$parent]]);
    }


    /**
     * Display the specified resource.
     *
     * @param Theatre $item
     * @return false|\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Inertia\Response|mixed|string|null
     */
    public function show(Theatre $item)
    {
        //
        return $this->output(['item'=>$item]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Cinema $parent
     * @param Theatre $item
     * @return false|\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Inertia\Response|mixed|string|null
     */
    public function edit(Cinema $parent, Theatre $item)
    {
        //
        $data = [
            'item'=>new TheatreResource($item),
            'cinema_options'=>\App\Models\Cinema::options(['parent'=>$parent])
        ];


        return $this->output(['view'=>"katzsimon::admin.{$this->ui['items']}.edit", 'parent'=>$parent, 'data'=>$data]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param AdminTheatreRequest $request
     * @param Cinema $parent
     * @param Theatre $item
     * @return false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function update(AdminTheatreRequest $request, Cinema $parent, Theatre $item)
    {
        //

        $this->repository->update( $item, $request->validated() );

        return $this->redirect(['route'=>"admin.{$this->ui['parent-items']}.{$this->ui['items']}.index", 'params'=>[$parent->id]]);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Cinema $parent
     * @param Theatre $item
     * @return false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     * @throws \Exception
     */
    public function destroy(Cinema $parent, Theatre $item)
    {
        //
        $item->delete();

        return $this->redirect(['route'=>"admin.{$this->ui['parent-items']}.{$this->ui['items']}.index", 'params'=>[$parent]]);

    }
}
