<?php namespace App\Http\Controllers\Katzsimon\Base;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Katzsimon\Cinema\Repositories\BookingRepositoryInterface;
use Katzsimon\Cinema\Repositories\ScreeningRepositoryInterface;
use Katzsimon\Cinema\Resources\BookingResource;
use Katzsimon\Movie\Resources\MovieResource;

class AppController extends \Katzsimon\Base\Http\Controllers\AppController
{

    public $repositoryBooking;
    public $repositoryScreening;

    public function __construct(BookingRepositoryInterface $repositoryBooking, ScreeningRepositoryInterface $repositoryScreening) {
        $this->repositoryBooking = $repositoryBooking;
        $this->repositoryScreening = $repositoryScreening;
        parent::__construct();
    }

    /**
     * Show the Home page
     * List the Users Upcoming Bookings if they have
     * List some featured Movies
     *
     * @return false|\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Inertia\Response|mixed|string|null
     */
    public function home(Request $request) {

        $userId = 0;
        if (Auth::check()) {
            $userId = Auth::id();
        } elseif ($request->user()) {
            $userId = $request->user()->id;
        }

        if ($userId>0) {
            $upcomingBookings = $this->repositoryBooking->getByUserUpcoming($userId);
            $upcomingBookingsResource = BookingResource::collection($upcomingBookings)->toArray(request());
        } else {
            $upcomingBookingsResource = [];
        }

        $movies = $this->repositoryScreening->featuredMovies();

        $data = [
            'upcomingBookings'=>$upcomingBookingsResource,
            'movies' => MovieResource::collection($movies)->toArray(request())
        ];

        return $this->output(['view'=>'katzsimon::pages.app.home', 'data'=>$data]);

    }


    /**
     * Show the user account page
     * List all the Bookings for the User
     *
     * @param Request $request
     * @return false|\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Inertia\Response|mixed|string|null
     */
    public function account(Request $request) {

        $upcomingBookings = $this->repositoryBooking->getByUserUpcoming(Auth::id());
        $pastBookings = $this->repositoryBooking->getByUserPast(Auth::id());

        $data = [
            'upcomingBookings'=>BookingResource::collection($upcomingBookings)->toArray(request()),
            'pastBookings'=>BookingResource::collection($pastBookings)->toArray(request()),
            'user'=>Auth::user()
        ];

        return $this->output(['view'=>'katzsimon::pages.app.account', 'data'=>$data, 'with2'=>['message'=>json_encode(['message'=>'testing', 'status'=>'success'])] ]);

    }

}
