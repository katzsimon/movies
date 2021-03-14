<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AuthAppVueTest extends DuskTestCase
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
     * @group vue
     */
    public function testLogin()
    {

        $this->browse(function (Browser $browser) {

            $user = \App\Models\User::factory()->create();

            $browser->visit('/login')
                ->assertSee('LOGIN')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('LOGIN')
                ->waitForText('ACCOUNT', 60)
                ->assertSee('ACCOUNT')
                ->clickLink('Logout')
                ->waitForText('LOGIN', 5)
                ->assertSee('LOGIN')
            ;

        });

    }


    /**
     * Tests User registration works and that the user appears in the database after Registration
     *
     * @throws \Throwable
     *
     * @group vue
     */
    public function testRegister()
    {


        $this->browse(function (Browser $browser) {

            $user = \App\Models\User::factory()->make();

            $browser->visit('/')
                ->assertSee('REGISTER')
                ->clickLink('Register')
                ->waitForText('Email', 5)
                ->assertSee('Email')
                ->type('name', $user->name)
                ->type('email', $user->email)
                ->type('password', 'password')
                ->type('password_confirmation', 'password')
                ->press('REGISTER')
                ->waitForText('ACCOUNT', 10)
                ->assertSee('ACCOUNT')
                ->clickLink('Logout')
                ->waitForText('LOGIN', 5)
                ->assertSee('LOGIN')
            ;

            $this->assertDatabaseHas('users', ['email'=>$user->email, 'name'=>$user->name]);
        });

    }
}
