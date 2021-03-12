<?php

namespace Katzsimon\Cinema\Http\Controllers;

use App\Http\Requests\AdminBookingRequest;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Katzsimon\Cinema\Repositories\BookingRepositoryInterface;
use Katzsimon\Base\Http\Controllers\Controller;


/**
 * Admin CRUD for the Bookings
 *
 * Class BookingController
 * @package Katzsimon\Cinema\Http\Controllers
 */
class BookingController extends Controller
{

    protected $model = 'App\Models\Booking';
    protected $resource = 'Katzsimon\Cinema\Resources\BookingResource';
    protected $admin = true;


    public function __construct(BookingRepositoryInterface $repository) {
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
        $items = $this->repository->all('desc');

        return $this->output(['view'=>"katzsimon::admin.{$this->ui['items']}.index", 'items'=>$items]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Inertia\Response|void
     */
    public function create(Booking $item)
    {
        $item = $this->repository->empty();
        $data = [
            'item'=>$item,
            'user_options'=>\App\Models\User::options(),
            'screening_options'=>\App\Models\Screening::options(),
            'movie_options'=>\App\Models\Movie::options(),
        ];

        return $this->output(['view'=>"katzsimon::admin.{$this->ui['items']}.create", 'data'=>$data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\AdminBookingRequest  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|Redirect
     */
    public function store(AdminBookingRequest $request)
    {
        $item = $this->repository->create( $request->validated() );

        return $this->redirect(['route'=>"admin.{$this->ui['items']}.index"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Booking  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $item)
    {
        //
        return $this->output(['item'=>$item]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Booking  $item
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response|\Inertia\Response|void
     */
    public function edit(Booking $item)
    {
        //

        $data = [
            'item'=>$item,
            'user_options'=>\App\Models\User::options(),
            'screening_options'=>\App\Models\Screening::options(),
            'movie_options'=>\App\Models\Movie::options(),
        ];

        return $this->output(['view'=>"katzsimon::admin.{$this->ui['items']}.edit", 'data'=>$data]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\AdminBookingRequest  $request
     * @param  \App\Models\Booking  $item
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function update(AdminBookingRequest $request, Booking $item)
    {
        //
        $this->repository->update( $item, $request->validated() );

        return $this->redirect(['route'=>"admin.{$this->ui['items']}.index"]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Booking  $item
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function destroy(Booking $item)
    {
        //
        $item->delete();
        return $this->redirect(['route'=>"admin.{$this->ui['items']}.index"]);
    }

    /**
     * Cancel a Booking
     * Different from Deleting it, as it can only be deleted more than 60 minutes before its screening time
     *
     * @param Booking $item
     * @return false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function cancelBooking(Booking $item) {

        $cancelled = $item->cancelBooking();

        if ($cancelled) {
            $message = ['message'=>'The booking has been cancelled', 'type'=>'success'];
        } else {
            $message = ['message'=>'The booking can only be cancelled when the screening is more than 60 minutes in the future', 'type'=>'error'];
        }

        return $this->redirect(['route'=>"admin.{$this->ui['items']}.index", 'with'=>['message'=>json_encode($message)]]);

    }
}
