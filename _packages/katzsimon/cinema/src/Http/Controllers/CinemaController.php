<?php

namespace Katzsimon\Cinema\Http\Controllers;


use App\Http\Requests\AdminCinemaRequest;
use App\Models\Cinema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Katzsimon\Base\Http\Controllers\Controller;
use Katzsimon\Cinema\Repositories\CinemaRepositoryInterface;


/**
 * Cinema CRUD
 *
 * Class CinemaController
 * @package Katzsimon\Cinema\Http\Controllers
 */
class CinemaController extends Controller
{

    protected $model = 'App\Models\Cinema';
    protected $resource = 'Katzsimon\Cinema\Resources\CinemaResource';
    protected $admin = true;


    public function __construct(CinemaRepositoryInterface $repository) {

        $this->repository = $repository;
        parent::__construct();

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Inertia\Response|void
     */
    public function index(Request $request)
    {
        $items = $this->repository->all();
        return $this->output(['view'=>"katzsimon::admin.{$this->ui['items']}.index", 'data'=>['items'=>$items]]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Inertia\Response|void
     */
    public function create(Cinema $item)
    {

        $item = $this->repository->empty();

        return $this->output(['view'=>"katzsimon::admin.{$this->ui['items']}.create", 'data'=>['item'=>$item]]);
        //return $this->output(['type'=>'inertia', 'data'=>$data, 'component'=>'katzsimon::movie::Cinema/Create']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AdminCinemaRequest $request
     * @return false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function store(AdminCinemaRequest $request)
    {
        //
        $item = $this->repository->create( $request->validated() );

        return $this->redirect(['route'=>"admin.{$this->ui['items']}.index"]);
    }

    /**
     * Display the specified resource.
     *
     * @param Cinema $item
     * @return false|\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Inertia\Response|mixed|string|null
     */
    public function show(Cinema $item)
    {
        //
        return $this->output(['item'=>$item]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Cinema $item
     * @return false|\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Inertia\Response|mixed|string|null
     */
    public function edit(Cinema $item)
    {
        //
        return $this->output(['view'=>"katzsimon::admin.{$this->ui['items']}.edit", 'data'=>['item'=>$item]]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AdminCinemaRequest $request
     * @param Cinema $item
     * @return false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function update(AdminCinemaRequest $request, Cinema $item)
    {
        //

        $this->repository->update( $item, $request->validated() );

        return $this->redirect(['route'=>"admin.{$this->ui['items']}.index"]);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Cinema $item
     * @return false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     * @throws \Exception
     */
    public function destroy(Cinema $item)
    {
        //
        $item->delete();

        return $this->redirect(['route'=>"admin.{$this->ui['items']}.index"]);
    }
}
