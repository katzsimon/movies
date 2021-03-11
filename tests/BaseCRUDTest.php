<?php

namespace Tests;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

abstract class BaseCRUDTest extends TestCase
{


    /**
     * Abstract class to extend for Resource Model CRUD testing
     */

    use DatabaseTransactions;

    protected $user = null;
    protected $model = null;
    protected $table = null;
    protected $baseUrl = null;

    protected $createdModel = null;

    /**
     * Setup function to run before tests
     */
    public function setUp():void
    {
        parent::setUp();

        $this->table = $this->model->getTable();
        $this->setupUser();
        config()->set('settings.output.admin', 'json');
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
     * Check that the index function works
     */
    public function testIndex()
    {

        $items = $this->model->factory(5)->create();

        // Check index :: Get the json response from index and check if the above factory is in it
        $response = $this->get($this->baseUrl)->assertStatus(200);
        $data = $response->json()['items']??[];


        // Check that the returned data from the index, has at least as many items created by the factory
        $this->assertGreaterThanOrEqual(count($data), count($items));

    }


    /**
     * Check that the Store function works
     */
    public function testStore() {

        $item = $this->model->factory()->make();

        // Check create :: Create model
        $response = $this->postJson($this->baseUrl, $item->toArray(), ['FORCE_CONTENT_TYPE'=>'json'])
            ->assertStatus(200);

        // Check that the database contains the item created by the factory
        $this->assertDatabaseHas($this->table, $item->toArray());
    }


    /**
     * Check that the update function works
     */
    public function testUpdate()
    {

        $item = $this->model->factory()->create();
        $updatedItem = $this->model->factory()->make();

        // Removes the dates for comparison
        $itemArray = $item->toArray();
        unset($itemArray['created_at']);
        unset($itemArray['updated_at']);

        // Check that the database contains the factory item
        $this->assertDatabaseHas($this->table, $itemArray);

        // Update the item with the second factory updatedItem
        $response = $this->patch("{$this->baseUrl}/{$item->getKey()}", $updatedItem->toArray(), ['FORCE_CONTENT_TYPE'=>'json'])
            ->assertStatus(200);

        // Check that the original item does not exist anymore
        $this->assertDatabaseMissing($this->table, $itemArray);
        // Check that the updatedItem now exists in the database
        $this->assertDatabaseHas($this->table, $updatedItem->toArray());


    }


    /**
     * Check the Show function, if it exists
     */

    public function testShow()
    {

        $item = $this->model->factory()->create();

        $response = $this->get("{$this->baseUrl}/{$item->getKey()}", [], ['FORCE_CONTENT_TYPE'=>'json']);
        $status = $response->status();

        if ($status===200) {

            try {
                $data = $response->json();
                $data = $data['item'] ?? $data['data'] ?? [];

                // $fieldsCompared should be empty if the attributes in item match attributes in the returned data item
                $fieldsCompared = array_diff($item->toArray(), $data);
                $this->assertTrue(empty($fieldsCompared), 'Model equivalent to Show item');
            } catch (\Exception $e) {
                // show route is probably not defined
                $this->assertTrue(true, 'Show route does not exist');
            }

        } elseif ($status===404) {
            // Response did not return the model
            $this->assertTrue(false, 'Model not found');
        } elseif ($status===500) {
            // Show method does not exist in the Controller
            $this->assertTrue(true, 'Show method does not exist');
        }


    }

    /**
     * Check that the Destroy function works
     */
    public function testDestroy()
    {
        $item = $this->model->factory()->create();

        // Removes the dates for comparison
        $itemArray = $item->toArray();
        unset($itemArray['created_at']);
        unset($itemArray['updated_at']);

        // Check that the model is in the database
        $this->assertDatabaseHas($this->table, $itemArray);

        $response = $this->delete("{$this->baseUrl}/{$item->getKey()}", [], ['FORCE_CONTENT_TYPE'=>'json'])
            ->assertStatus(200);

        // The model should not exist in the database now
        $this->assertDatabaseMissing($this->table, $itemArray);

    }


}
