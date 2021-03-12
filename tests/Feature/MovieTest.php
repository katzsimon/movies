<?php

namespace Tests\Feature;


class MovieTest extends \Tests\BaseCRUDTest
{


    public function setUp():void
    {

        $this->model = app()->make(\App\Models\Movie::class);
        $this->baseUrl = '/admin/movies';

        parent::setUp();

    }


    /**
     * Check that the index method returns with the extended Screening relationship
     */
    public function testIndexWithScreenings()
    {

        $movie = $this->model->factory()->create();
        $screening = \App\Models\Screening::factory()->movie($movie->id)->create();


        // Check index :: Get the json response from index and check if the above factory is in it
        $response = $this->get($this->baseUrl)->assertStatus(200);
        $data = $response->json()['data']??[];

        // Check that the returned data from the index, has at least as many items created by the factory
        $this->assertGreaterThan(0, $data[0]['screening_count']);
    }


    public function testDeleteWithScreenings()
    {


        // Create a Movie & Screening
        $movie = $this->model->factory()->create();
        $screening = \App\Models\Screening::factory()->movie($movie->id)->create();


        // Check that Movie & Screening are in the database
        $movieArray = $movie->toArray();
        unset($movieArray['created_at']);
        unset($movieArray['updated_at']);
        // Check that the model is in the database
        $this->assertDatabaseHas($this->table, $movieArray);

        $screeningArray = $screening->toArray();
        unset($screeningArray['created_at']);
        unset($screeningArray['updated_at']);
        $this->assertDatabaseHas($screening->getTable(), $screeningArray);


        // Delete the Movie with its Screening
        $response = $this->delete("{$this->baseUrl}/{$movie->getKey()}/screenings", [], ['FORCE_CONTENT_TYPE'=>'json'])
            ->assertStatus(200);

        // Check that the Movie and Screening are not in the database now
        $this->assertDatabaseMissing($this->table, $movieArray);
        $this->assertDatabaseMissing($screening->getTable(), $screeningArray);

    }



}
