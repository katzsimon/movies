<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AuthAppBladeTest extends DuskTestCase
{

    protected $truncateTables = true;
    protected $repository = null;


    public function setUp():void
    {
        parent::setUp();
    }

    public function tearDown():void
    {
        if ($this->truncateTables) {
            DB::table('users')->truncate();
        }

        parent::tearDown();
    }

    /**
     * Create a User and check that login works
     *
     * @throws \Throwable
     *
     * @group blade
     */
    public function testLogin()
    {
        $user = \App\Models\User::factory()->create();

        $this->browse(function (Browser $browser) use($user) {

            $browser->visit('/login')
                ->assertSee('Login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->waitForText('Account', 10)
                ->assertSee('Account')
                ->clickLink('Logout')
                ->waitForText('Login', 5)
                ->assertSee('Login')
            ;

        });

    }


    /**
     * Tests User registration works and that the user appears in the database after Registration
     *
     * @throws \Throwable
     *
     * @group blade
     */
    public function testRegister()
    {
        $user = \App\Models\User::factory()->make();

        $this->browse(function (Browser $browser) use($user) {

            $browser->visit('/')
                ->assertSee('Register')
                ->clickLink('Register')
                ->waitForText('Email', 5)
                ->assertSee('Email')
                ->type('name', $user->name)
                ->type('email', $user->email)
                ->type('password', 'password')
                ->type('password_confirmation', 'password')
                ->press('Register')
                ->waitForText('Account', 10)
                ->assertSee('Account')
                ->clickLink('Logout')
                ->waitForText('Login', 5)
                ->assertSee('Login')
            ;

            $this->assertDatabaseHas('users', ['email'=>$user->email, 'name'=>$user->name]);
        });

    }
}
