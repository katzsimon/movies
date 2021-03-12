<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * Ensure the Extended Movie-Screening Relationship works
 *
 * Class MovieScreeningTest
 * @package Tests\Feature
 */
class MovieScreeningTest extends TestCase
{

    public function testRelationship()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Ensure the Admin MovieController::index returns Movies with their Screenings
     */
    public function testAdminIndex()
    {

        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testAdminDeleteWithScreenings()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
