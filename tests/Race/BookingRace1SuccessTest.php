<?php

namespace Tests\Race;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;


/**
 * This ideally needs to run in parallel with BookingRace2ErrorTest
 *
 * Class BookingRace1SuccessTest
 * @package Tests\Feature
 */
class BookingRace1SuccessTest extends TestCase
{

    protected $repositoryScreening = null;
    protected $repositoryMovie = null;
    protected $truncateTables = true;


    public function setUp():void
    {
        parent::setUp();

        if ($this->truncateTables) $this->truncate();

        $this->repositoryScreening = app()->make(\Katzsimon\Cinema\Repositories\ScreeningRepository::class);
        $this->repositoryMovie = app()->make(\Katzsimon\Movie\Repositories\MovieRepository::class);

        $this->setupUser();

    }

    public function tearDown():void
    {
        parent::tearDown();
    }

    public function truncate()
    {
        if ($this->truncateTables) {
            DB::table('bookings')->truncate();
            DB::table('screenings')->truncate();
            DB::table('movies')->truncate();
            DB::table('cinemas')->truncate();
            DB::table('theatres')->truncate();
            DB::table('users')->truncate();
        }
    }

    /**
     * Create a user for authentication if needed
     *
     * Uses existing user model if exists, otherwise creates a new one
     */
    protected function setupUser()
    {
        $user = \App\Models\User::first();

        if (empty($user)) {
            $this->user = \App\Models\User::factory()->create();
        } else {
            $this->user = $user;
        }

        $this->actingAs($this->user);
    }


    /**
     * Make a Booking for all the seats in the Theatre
     *
     * This test will sleep during the booking process
     *
     * It should return a successful booking
     *
     */
    public function testBookingRace()
    {

        $movie = $this->repositoryMovie->findByCriteria(['name'=>'Race']);
        if (empty($movie)) {
            $movie = $this->repositoryMovie->model()->factory()->make();
            $movie->name = 'Race';
            $movie->save();
        }

        $screening = $this->repositoryScreening->model()->factory()->movie($movie->id)->create();

        $theatre = $screening->theatre;

        $seats = $theatre->max_seats;

        $bookingData = [
            'movie_id'=>$movie->id,
            'screening_id'=>$screening->id,
            'seats'=>$seats,
            'pause'=>10 // Adding in a delay for the booking process
        ];

        $response = $this->postJson('/booking', $bookingData, ['FORCE_CONTENT_TYPE'=>'json'])
            ->assertStatus(200);
        $outputSuccess = $response->json();

        // This should have booked all the seats, making the second test fail
        $this->assertEquals('success', $outputSuccess['status']);


    }


}
