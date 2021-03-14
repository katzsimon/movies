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

class AppUpcomingMoviesVueTest extends DuskTestCase
{

    protected $truncateTables = true;
    protected $repositoryScreening = null;


    public function setUp():void
    {
        parent::setUp();

        $this->repositoryScreening = app()->make(\Katzsimon\Cinema\Repositories\ScreeningRepository::class);
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
     * Check that only upcoming movies show
     *
     * @return void
     *
     * @group vue
     */
    public function testUpcomingMovies()
    {
        // These can possibly have the same movie names, run again if fails
        $screeningsFuture = $this->repositoryScreening->model()->factory(1)->create();
        $screeningsPast = $this->repositoryScreening->model()->factory(1)->past()->create();


        $movieFuture = $screeningsFuture->first()->movie;
        $moviePast = $screeningsPast->first()->movie;


        $this->browse(function (Browser $browser) use($movieFuture, $moviePast) {

            $browser->visit('/upcoming-movies')
                    ->waitForText($movieFuture->name, 15)
                    ->assertSee($movieFuture->name)
                    ->assertDontSee($moviePast->name)
            ;
        });

    }

}
