<?php

namespace Katzsimon\Cinema\Http\Controllers;

use App\Http\Requests\AppBookingRequest;
use App\Models\Booking;
use App\Models\Movie;
use App\Models\Screening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Katzsimon\Cinema\Repositories\BookingRepositoryInterface;
use Katzsimon\Cinema\Repositories\ScreeningRepositoryInterface;
use Katzsimon\Cinema\Resources\BookingMovieResource;
use Katzsimon\Cinema\Resources\BookingResource;
use Katzsimon\Cinema\Resources\BookingScreeningResource;
use Katzsimon\Cinema\Resources\ScreeningResource;
use Katzsimon\Base\Http\Controllers\Controller;
use Katzsimon\Movie\Repositories\MovieRepositoryInterface;

/**
 * Controller to handle the booking methods for the app
 *
 * Class AppBookingController
 * @package Katzsimon\Cinema\Http\Controllers
 */
class AppBookingController extends Controller
{

    protected $model = 'App\Models\Screening';
    protected $resource = 'Katzsimon\Cinema\Resources\ScreeningResource';
    protected $repositoryScreening = null;
    protected $repositoryMovie = null;
    protected $repositoryBooking = null;


    /**
     * Bind the repositories needed
     *
     * AppBookingController constructor.
     * @param ScreeningRepositoryInterface $repositoryScreening
     * @param MovieRepositoryInterface $repositoryMovie
     * @param BookingRepositoryInterface $repositoryBooking
     */
    public function __construct(ScreeningRepositoryInterface $repositoryScreening,
                                MovieRepositoryInterface $repositoryMovie,
                                BookingRepositoryInterface $repositoryBooking
                                )
    {
        $this->repositoryScreening = $repositoryScreening;
        $this->repositoryMovie = $repositoryMovie;
        $this->repositoryBooking = $repositoryBooking;
        parent::__construct();
    }


    /**
     * Load the Booking page without selected Movie or Screening
     *
     * @param Request $request
     * @return false|\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Inertia\Response|mixed|string|null
     */
    public function booking(Request $request) {

        $upcomingMovies = $this->repositoryScreening->upcomingMovies();

        $data = [
            'item' => [],
            'movie_id'=>'',
            'screening_id'=>'',
            'movies' => BookingMovieResource::collection($upcomingMovies)->toArray(request()),
            'screenings' => [],
            'movie_options' => \App\Models\Screening::optionsUpcomingMovies($upcomingMovies),
            'screening_options' => [],
            'seat_options'=>[],
        ];

        return $this->output(['view'=>'katzsimon::app.bookings.booking_form', 'data'=>$data]);
    }


    /**
     * Load the Booking page for a specific Screening
     *
     * @param Request $request
     * @param Screening $screening
     * @return false|\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Inertia\Response|mixed|string|null
     */
    public function bookingScreening(Request $request, Screening $screening) {

        $upcomingMovies = $this->repositoryScreening->upcomingMovies();
        $upcomingScreenings = $this->repositoryScreening->upcomingOfMovie($screening->movie_id??null);

        $data = [
            'item'=>new ScreeningResource($screening),
            'movie_id'=>$screening->movie_id??'',
            'screening_id'=>$screening->id??'',
            'movies'=>BookingMovieResource::collection($upcomingMovies)->toArray(request()),
            'screenings'=>BookingScreeningResource::collection($upcomingScreenings)->toArray(request()),
            'movie_options'=>\App\Models\Screening::optionsUpcomingMovies($upcomingMovies),
            'screening_options' => \App\Models\Screening::optionsScreeningsForMovie($upcomingScreenings),
            'seat_options'=>$screening->optionsSeats(),
        ];

        return $this->output(['view'=>'katzsimon::app.bookings.booking_form', 'data'=>$data]);
    }


    /**
     * Load the Booking page for a specified Movie
     *
     * @param Request $request
     * @param Movie $movie
     * @return false|\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Inertia\Response|mixed|string|null
     */
    public function bookingMovie(Request $request, Movie $movie) {

        $upcomingMovies = $this->repositoryScreening->upcomingMovies();
        $upcomingScreenings = $this->repositoryScreening->upcomingOfMovie($movie->id);

        $data = [
            'movie_id'=>(string)$movie->id,
            'screening_id'=>'',
            'movies'=>BookingMovieResource::collection($upcomingMovies)->toArray(request()),
            'screenings'=>BookingScreeningResource::collection($upcomingScreenings)->toArray(request()),
            'movie_options' => \App\Models\Screening::optionsUpcomingMovies($upcomingMovies),
            'screening_options' => \App\Models\Screening::optionsScreeningsForMovie($upcomingScreenings),
            'seat_options' => [],
        ];


        return $this->output(['view'=>'katzsimon::app.bookings.booking_form', 'data'=>$data]);

    }


    /**
     * Handle the Booking Request
     *
     * Locks the Screening table while processing,
     * to prevent multiple users booking the same seats at the same time
     *
     * @param AppBookingRequest $request
     * @return false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function handleBooking(AppBookingRequest $request) {

        // Only used for testing
        $pause = $request->get('pause', 0);

        try {

            DB::beginTransaction();
            // Lock the screenings while processing the Booking
            DB::table('screenings')->where('id', $request->get('screening_id'))->lockForUpdate()->get();

            $screening = $this->repositoryScreening->find($request->get('screening_id'));

            // Pause here if this method is being tested
            if (config('app.debug')===true && $pause>0) sleep($pause);

            if ($request->get('seats')>$screening->seats_available) {
                // Not enough seats available
                $data = [
                    'status'=>'error',
                    'message'=>'There are not enough seats available. Please try again.',
                    'reference'=>null,
                ];

                DB::rollBack();

            } else {

                $booking = $this->repositoryBooking->create([
                    'user_id'=>$request->user()->id,
                    'screening_id'=>$request->get('screening_id'),
                    'seats'=>$request->get('seats')
                ]);


                DB::commit();

                // There are enough seats for the booking to proceed
                $data = [
                    'status'=>'success',
                    'message'=>'Booking successful',
                    'reference'=>$booking->reference,
                ];
            }

            $message = json_encode($data);

            return $this->redirect(['route'=>'account', 'data'=>$data, 'with'=>['message'=>$message]]);

        } catch (\Exception $e) {

            DB::rollBack();

            $data = [
                'status'=>'error',
                'message'=>'There was an error. Please try again.',
                'reference'=>null,
            ];

            $message = json_encode($data);

            return $this->redirect(['route'=>'account', 'data'=>$data, 'with'=>['message'=>$message]]);

        }

    }


    /**
     * Get the Bookings for the Authenticated User
     *
     * @param Request $request
     * @return false|\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Inertia\Response|mixed|string|null
     */
    public function userBookings(Request $request)
    {

        $bookingsFuture = $this->repositoryBooking->getByUserUpcoming($request->user()->id);
        $bookingsPast = $this->repositoryBooking->getByUserPast($request->user()->id);

        $data = [
            'bookingsFuture'=>BookingResource::collection($bookingsFuture),
            'bookingsPast'=>BookingResource::collection($bookingsPast),
            'authuser'=>Auth::user(),
            'requestuser'=>$request->user()
        ];

        return $this->output(['output'=>'json', 'data'=>$data]);
    }


    /**
     * Cancel a Booking
     *
     * @param Request $request
     * @param Booking $booking
     * @return false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function cancelBooking(Request $request, Booking $booking)
    {
        // Attempt to cancel a Booking
        $cancelled = $booking->cancelBooking();

        $data = [
            'status'=>$cancelled ? 'Booking Cancelled' : 'Cancellation Error',
            'message'=>$cancelled ? 'This booking has been cancelled' : 'The booking has not been cancelled, it is too close to the screening time.'
        ];

        $message = json_encode($data);

        return $this->redirect(['route'=>'account', 'data'=>$data, 'with'=>['message'=>$message]]);
    }




}
