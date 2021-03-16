<?php

namespace Tests\Race;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * This ideally needs to run in parallel with BookingRace1SuccessTest
 *
 * Class BookingRace2ErrorTest
 * @package Tests\Feature
 */
class BookingRace2ErrorTest extends TestCase
{

    protected $repositoryScreening = null;
    protected $repositoryMovie = null;
    protected $truncateTables = true;


    public function setUp():void
    {
        parent::setUp();

        $this->repositoryScreening = app()->make(\Katzsimon\Cinema\Repositories\ScreeningRepository::class);
        $this->repositoryMovie = app()->make(\Katzsimon\Movie\Repositories\MovieRepository::class);

        $this->setupUser();

    }

    public function tearDown():void
    {

        if ($this->truncateTables) $this->truncate();

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
     * Attempt to make a Booking for all the seats in the Theatre
     *
     * The booking process should wait while the first test is sleeping/running
     *
     * It should return an error as there should be no seats available
     * After the first test should have booked all the seats
     *
     */
    public function testBookingRace()
    {

        $movie = $this->repositoryMovie->findByCriteria(['name'=>'Race']);
        if (empty($movie)) {
            // Basically skip this test if
            $this->fail('Failing as it is not running in parallel with BookingRace1SuccessTest');
        } else {
            $screening = $this->repositoryScreening->findByCriteria(['movie_id'=>$movie->id]);

            if (empty($screening)) $this->assertTrue(false, 'Screening not found from BookingRace1SuccessTest');

            $movie = $screening->movie;
            $theatre = $screening->theatre;

            $seats = $theatre->max_seats;

            $bookingData = [
                'movie_id' => $movie->id,
                'screening_id' => $screening->id,
                'seats' => $seats,
                'pause' => 0
            ];

            $response = $this->postJson('/booking', $bookingData, ['FORCE_CONTENT_TYPE' => 'json'])
                ->assertStatus(200);
            $outputError = $response->json();

            // There should not be any available seats, as they have been booked by the first test
            $this->assertEquals('error', $outputError['status']);
            $this->assertEquals('There are not enough seats available. Please try again.', $outputError['message']);
        }

    }


}
