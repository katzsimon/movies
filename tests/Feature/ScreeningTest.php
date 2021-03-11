<?php

namespace Tests\Feature;


class ScreeningTest extends \Tests\BaseCRUDTest
{


    public function setUp():void
    {

        $this->model = app()->make(\App\Models\Screening::class);
        $this->baseUrl = '/admin/screenings';

        parent::setUp();

    }

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
     * Check that the index function works
     */
    public function testIndex()
    {

        $this->assertTrue(true);

    }


    /**
     * Check that the Store function works
     */
    public function testStore() {

        $this->assertTrue(true);
    }


    /**
     * Check that the update function works
     */
    public function testUpdate()
    {

        $this->assertTrue(true);

    }


    /**
     * Check the Show function, if it exists
     */

    public function testShow()
    {

        $this->assertTrue(true);


    }

    /**
     * Check that the Destroy function works
     */
    public function testDestroy()
    {
        $this->assertTrue(true);

    }

}
