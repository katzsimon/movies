<?php

namespace Tests\Browser;

use Facebook\WebDriver\WebDriverKeys;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AppBookingTest extends DuskTestCase
{

    protected $truncateTables = false;
    protected $repositoryScreening = null;
    protected $repositoryMovie = null;


    public function setUp():void
    {
        parent::setUp();

        $this->repositoryScreening = app()->make(\Katzsimon\Cinema\Repositories\ScreeningRepository::class);
        $this->repositoryMovie = app()->make(\Katzsimon\Movie\Repositories\MovieRepository::class);
    }

    public function tearDown():void
    {

        if ($this->truncateTables) {
            DB::table('screenings')->truncate();
            DB::table('movies')->truncate();
            DB::table('cinemas')->truncate();
            DB::table('theatres')->truncate();
        }

        parent::tearDown();

    }


    /**
     * Check that a logged in User can make a Booking Successfully
     *
     * @throws \Throwable
     */
    public function testMakeBooking()
    {


        $this->browse(function (Browser $browser) {
            $user = \App\Models\User::factory()->create();
            $movie = $this->repositoryMovie->model()->factory()->create();
            $screening = $this->repositoryScreening->model()->factory()->movie($movie->id)->create();

            $browser->loginAs($user)
                ->visit('/')
                ->waitForText('Account', 10)
                ->assertSee('Account')
                ->visit('/booking')
                ->waitForText('Make a Booking', 10)
                ->select('movie_id', $movie->id)
                ->pause(500)
                ->select('screening_id', $screening->id)
                ->pause(500)
                ->select('seats', '2')
                ->pause(500)
                ->press('Book Now')
                ->waitForText('Upcoming Bookings', 10)
                ->assertSee('Upcoming Bookings')
            ;

        });
    }


    /**
     * Check that a booking will fail without all the required inputs
     * 
     * @throws \Throwable
     */
    public function testMakeBookingIncorrect()
    {


        $this->browse(function (Browser $browser) {
            $user = \App\Models\User::factory()->create();
            $movie = $this->repositoryMovie->model()->factory()->create();
            $screening = $this->repositoryScreening->model()->factory()->movie($movie->id)->create();

            $browser->loginAs($user)
                ->visit('/')
                ->waitForText('Account', 10)
                ->assertSee('Account')
                ->visit('/booking')
                ->waitForText('Make a Booking', 10)
                ->select('movie_id', $movie->id)
                ->pause(500)
                ->press('Book Now')
                ->waitForText('is required', 10)
                ->assertSee('is required')
            ;

        });
    }

}
