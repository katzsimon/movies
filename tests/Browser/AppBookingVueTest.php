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

class AppBookingVueTest extends DuskTestCase
{

    protected $truncateTables = true;
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
     *
     * @group vue
     */
    public function testMakeBooking()
    {


        $this->browse(function (Browser $browser) {

            $user = \App\Models\User::factory()->create();
            $movie = $this->repositoryMovie->model()->factory()->create();
            $screening = $this->repositoryScreening->model()->factory()->movie($movie->id)->create();

            $browser->visit('/login')
                ->assertSee('LOGIN')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('LOGIN')
                ->waitForText('ACCOUNT', 60)
                ->pause(500)
                ->clickLink('Make a Booking')
                ->waitForText('Make a Booking', 10)
                ->click('#selectMovie .v-select') // Find and select the Vuetify Select
                ->pause(500);
                // Need to interact with Vuetify components by sending key strokes
                $browser->driver->getKeyboard()->sendKeys(\Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
                $browser->driver->getKeyboard()->sendKeys(\Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
                $browser->driver->getKeyboard()->sendKeys(\Facebook\WebDriver\WebDriverKeys::ENTER);
                $browser->pause(500);
                $browser->driver->getKeyboard()->sendKeys(\Facebook\WebDriver\WebDriverKeys::TAB);
                $browser->driver->getKeyboard()->sendKeys(\Facebook\WebDriver\WebDriverKeys::SPACE);
                $browser->pause(500);
                $browser->driver->getKeyboard()->sendKeys(\Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
                $browser->driver->getKeyboard()->sendKeys(\Facebook\WebDriver\WebDriverKeys::ENTER);
                $browser->pause(500);
                $browser->driver->getKeyboard()->sendKeys(\Facebook\WebDriver\WebDriverKeys::TAB);
                $browser->driver->getKeyboard()->sendKeys(\Facebook\WebDriver\WebDriverKeys::SPACE);
                $browser->pause(500);
                $browser->driver->getKeyboard()->sendKeys(\Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
                $browser->driver->getKeyboard()->sendKeys(\Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
                $browser->driver->getKeyboard()->sendKeys(\Facebook\WebDriver\WebDriverKeys::ENTER);

                $browser->press('BOOK NOW')
                        ->waitForText('Booking successful', 10)
                        ->assertSee('Booking successful');

                $browser->driver->getKeyboard()->sendKeys(\Facebook\WebDriver\WebDriverKeys::TAB);
                $browser->driver->getKeyboard()->sendKeys(\Facebook\WebDriver\WebDriverKeys::TAB);
                $browser->driver->getKeyboard()->sendKeys(\Facebook\WebDriver\WebDriverKeys::TAB);
                $browser->driver->getKeyboard()->sendKeys(\Facebook\WebDriver\WebDriverKeys::SPACE);
                $browser
                        ->pause(500)
                        ->clickLink('Logout')
                        ->waitForText('LOGIN', 5)
                        ->assertSee('LOGIN')
                ;

        });
    }


    /**
     * Check that a booking will fail without all the required inputs
     *
     * @throws \Throwable
     *
     * @group vue
     */
    public function testMakeBookingIncorrect()
    {


        $this->browse(function (Browser $browser) {
            $user = \App\Models\User::factory()->create();
            $movie = $this->repositoryMovie->model()->factory()->create();
            $screening = $this->repositoryScreening->model()->factory()->movie($movie->id)->create();

            $browser->visit('/login')
                ->assertSee('LOGIN')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('LOGIN')
                ->waitForText('ACCOUNT', 60)
                ->pause(500)
                ->clickLink('Make a Booking')
                ->waitForText('Make a Booking', 10)

                ->click('#selectMovie .v-select')
                ->pause(500);
            $browser->driver->getKeyboard()->sendKeys(\Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
            $browser->driver->getKeyboard()->sendKeys(\Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
            $browser->driver->getKeyboard()->sendKeys(\Facebook\WebDriver\WebDriverKeys::ENTER);
            $browser->pause(500);
            $browser->press('BOOK NOW')
                ->waitForText('is required', 10)
                ->assertSee('is required')
            ;

        });
    }

}
