<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;

abstract class BaseRepositoryTest extends TestCase
{


    /**
     * Abstract class to extend for Resource Model CRUD testing
     */

    use DatabaseTransactions;


    protected $repository = null;
    protected $skipBaseTests = false;   // Allow these base tests to be skipped, if needed
    protected $truncateTables = true;



    /**
     * Setup function to run before tests
     */
    public function setUp():void
    {
        parent::setUp();

    }


    public function testModel()
    {
        if ($this->skipBaseTests) $this->markTestSkipped('Skipping Base Tests');

        $model = $this->repository->model();

        $this->assertTrue($model instanceof \Illuminate\Database\Eloquent\Model, 'Model function does not return an Eloquent model');
    }

    /**
     * Test creating a new Model
     */
    public function testCreate()
    {
        if ($this->skipBaseTests) $this->markTestSkipped('Skipping Base Tests');

        // Make Model data
        $item = $this->repository->model()->factory()->make();
        // Save the data to the database
        $model = $this->repository->create($item->toArray());

        // Compare that the model data matches the database model
        $this->assertTrue( $this->matchModels($item, $model) );
    }

    /**
     * Test that updating a model works
     */
    public function testUpdate()
    {
        if ($this->skipBaseTests) $this->markTestSkipped('Skipping Base Tests');

        // Create the original Model
        $item = $this->repository->model()->factory()->create();
        // Make new Model data (without saving to the database) **
        $updatedItem = $this->repository->model()->factory()->make();

        // Save the original MOdel values in an array
        $original = $item->toArray();

        // Update the original Model
        $model = $this->repository->update($item, $updatedItem->toArray());

        // Check that the original does not match the new Model
        $this->assertFalse( $this->matchArrays($original, $model->toArray()) );
        // Check that the new Model matches the new Model data **
        $this->assertTrue( $this->matchModels($updatedItem, $model) );
    }

    /**
     * Test that the find method, with the Models defined key
     * default key = id
     */
    public function testFind()
    {
        if ($this->skipBaseTests) $this->markTestSkipped('Skipping Base Tests');

        $item = $this->repository->model()->factory()->create();

        $model = $this->repository->find($item->getKey());

        $this->assertTrue( $this->matchModels($item, $model) );
    }

    /**
     * Test that the limit method only returns a subset of items
     */
    public function testLimit()
    {
        if ($this->skipBaseTests) $this->markTestSkipped('Skipping Base Tests');

        $this->repository->model()->factory(5)->create();

        $items = $this->repository->limit(2);

        $this->assertEquals(count($items), 2);

    }


    /**
     * Test that the empty method returns a model with attributes, but they have no values
     */
    public function testEmpty()
    {
        if ($this->skipBaseTests) $this->markTestSkipped('Skipping Base Tests');

        $item = $this->repository->empty();

        $this->assertTrue( $this->hasEmptyAttributes($item) );

    }


    /**
     * Compare 2 Models by checking if all the attributes in the Source exist in the Target
     * Once a Model is created/saved, new attributes can exist, so this takes that into account for comparison
     *
     * @param null $source
     * @param null $target
     * @return bool
     */
    public function matchModels($source=null, $target=null)
    {
        if (is_null($source) || is_null($target)) return false;

        $attributes = $source->getAttributes();

        foreach ($attributes as $key=>$value) {
            if ($source->$key!=$target->$key) return false;
        }

        return true;
    }

    /**
     * Compares 2 Arrays, by checking that all fields in the Source exist in the Target
     * Returns true as long as the source fields exist in the target,
     * Target can have additional fields
     *
     * @param null $source
     * @param null $target
     * @return bool
     */
    public function matchArrays($source=null, $target=null)
    {
        if (is_null($source) || is_null($target) || !is_array($source) || !is_array($target)) return false;
        // Get the difference between the source and target
        $fieldsCompared = array_diff($source, $target);
        // If empty than all source fields exist in target
        return empty($fieldsCompared);
    }

    /**
     * Checks that all the attributes in a Model are empty
     *
     * @param null $source
     * @return bool
     */
    public function hasEmptyAttributes($source=null)
    {
        $attributes = $source->getAttributes();
        foreach ($attributes as $attribute) {
            if (!empty($attribute)) return false;
        }
        return true;
    }

}
