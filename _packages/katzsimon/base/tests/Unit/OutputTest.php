<?php

namespace Tests\Unit;

use Tests\TestCase;

class OutputTest extends TestCase
{

    protected $repository;

    public function setUp():void
    {
        parent::setUp();

        $this->repository = app()->make(\Katzsimon\Movie\Repositories\MovieRepository::class);
    }

    /**
     * Test automatic mapping of Models and Collections to Json/Arrays
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function testMappingData() {

        $controller = app()->make('Katzsimon\Base\Http\Controllers\Controller');

        $moviesCollection = $this->repository->model()->factory(3)->create();
        $movieModel = $this->repository->model()->factory(1)->create();

        // Input data with a collection and model
        $data = [
            'items'=>$moviesCollection,
            'item'=>$movieModel
        ];

        $output = $controller->output(['output'=>'json', 'data'=>$data]);

        // Check that the output has been mapped to json/arrays
        $this->assertJson($output);
        $jsonDecode = json_decode($output, true);
        $this->assertArrayHasKey('data', $jsonDecode);
        $this->assertArrayHasKey('item', $jsonDecode);

    }

    /**
     * Test that the redirect will detect a json request and return json instead of making a redirect
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function testOutputRedirect()
    {
        $controller = app()->make('Katzsimon\Base\Http\Controllers\Controller');

        $moviesCollection = $this->repository->model()->factory(3)->create();
        $movieModel = $this->repository->model()->factory(1)->create();

        // Input data with a collection and model
        $data = [
            'items'=>$moviesCollection,
            'item'=>$movieModel
        ];

        $output = $controller->redirect(['output'=>'json', 'data'=>$data]);

        // Check that the redirects outputs json/array for a with a json request and does not redirect
        $this->assertJson($output);
        $jsonDecode = json_decode($output, true);

        $this->assertArrayHasKey('items', $jsonDecode);
        $this->assertArrayHasKey('item', $jsonDecode);

        $output = $controller->getUI('\App\Models\Movie');
        $this->assertArrayHasKey('item', $output);
        $this->assertEquals($output['item'], 'movie');
    }

}
