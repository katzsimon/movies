<?php

namespace Katzsimon\Cinema\Http\Controllers;

use App\Http\Requests\AdminMovieRequest;
use App\Models\Booking;
use App\Models\Movie;
use App\Models\Screening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Katzsimon\Base\Http\Controllers\Controller;
use Katzsimon\Movie\Repositories\MovieRepositoryInterface;

/**
 * Allows Running Factories from the Admin section
 *
 * Class FactoryController
 * @package Katzsimon\Cinema\Http\Controllers
 */
class FactoryController extends Controller
{

    protected $admin = true;


    /**
     * Create Screening models
     * Can specify the number of Movies to create with the Screenings
     *
     * @param Request $request
     * @param Screening $item
     * @param Movie $movie
     * @return false|\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Inertia\Response|mixed|string|null
     */
    public function makeScreenings(Request $request, Screening $item, Movie $movie)
    {
        $numberScreening = $request->get('numberScreening', 1);
        $numberMovie = intval($request->get('numberMovie', 1));

        for($i=1; $i<=$numberMovie; $i++) {
            $movie = $movie->factory()->create();
            $outputs = $item->factory($numberScreening)->movie($movie->id)->create();
        }

        return $this->output(['view'=>'katzsimon::admin.dashboard', 'message'=>['type'=>'success', 'message'=>"{$numberScreening} Screenings Created"]]);

    }


    /**
     * Create Booking models
     * Can specify whether the Bookings will be in the past or future
     *
     * @param Request $request
     * @param Booking $item
     * @return false|\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Inertia\Response|mixed|string|null
     */
    public function makeBookings(Request $request, Booking $item)
    {
        $numberBooking = $request->get('numberBooking', 1);
        $past = $request->get('past', '');


        if ($past==='1') {
            $outputs = $item->factory($numberBooking)->past()->create();
        } else {
            $outputs = $item->factory($numberBooking)->create();
        }

        return $this->output(['view'=>'katzsimon::admin.dashboard', 'message'=>['type'=>'success', 'message'=>"{$numberBooking} Bookings Created"]]);

    }

}
