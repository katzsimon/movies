<?php

namespace Katzsimon\Base\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;


class BaseRepository implements BaseRepositoryInterface
{
    /**
     * The Model associated to the Repository
     *
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }



    /**
     * Return an instance of the Model bound to the Repository
     *
     * @return Model
     */
    public function model(): Model
    {
        return $this->model;
    }



    /**
     * Finds a Model from its ID
     *
     * @param int $id
     * @return Model|null
     */
    public function find($id=0): ?Model
    {
        return $this->model->find($id);
    }


    /**
     * Get the first instance of the Model
     *
     * @return Model|null
     */
    public function first(): ?Model
    {
        return $this->model->first();
    }


    /**
     * Find a Model by its ID
     *
     * @param int $id
     * @param array|string[] $columns
     * @param array $relations
     * @return Model
     */
    public function findById(int $id, array $columns = ['*'], array $relations = []): Model
    {
        return $this->findByCriteria(['id' => $id], $columns, $relations);
    }


    /**
     * Custom query to find a specific Model
     *
     * @param array $criteria
     * @param array|string[] $columns
     * @param array $relations
     * @return Model|null
     */
    public function findByCriteria(array $criteria, array $columns = ['*'], array $relations = []): ?Model
    {
        return $this->newQuery()->select($columns)->with($relations)->where($criteria)->first();
    }


    /**
     * Build a custom query
     *
     * @param array $criteria
     * @param array $options
     * @return Collection
     */
    public function getByCriteria(array $criteria, $options=[]): Collection
    {
        $columns = $options['columns'] ?? ['*'];
        $relations = $options['columns'] ?? [];
        $orderBy = $options['orderBy'] ?? 'id desc';
        $orders = explode(' ', $orderBy);
        $orderColumn = $orders[0]??'id';
        $order = $orders[1]??'asc';
        return $this->newQuery()->select($columns)->with($relations)->where($criteria)->orderBy($orderColumn, $order)->get();
    }


    /**
     * Get a certain number of Model instances
     *
     * @param int $limit
     * @return Collection
     */
    public function limit(int $limit): Collection
    {
        return $this->newQuery()->limit($limit)->get();
    }


    /**
     * Get all instances or the Model
     *
     * @param string $order
     * @param array $relations
     * @return Collection
     */
    public function all($order='asc', array $relations = []): Collection
    {
        return $this->newQuery()->with($relations)->orderBy('id', $order)->get();
    }


    /**
     * Create an empty Model, with empty default attributes
     *
     * @return Model
     */
    public function empty(): Model
    {
        $model = new $this->model();
        $fillable = $this->model->getFillable();
        foreach ($fillable as $fill) {
            $model->$fill = '';
        }
        return $model;
    }


    /**
     * Create a new Model
     *
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model
    {
        return $this->newQuery()->create($attributes);
    }


    /**
     * Update a Model
     *
     * @param Model $model
     * @param array $attributes
     * @return Model
     */
    public function update(Model $model, array $attributes): Model
    {
        $model->update($attributes);
        return $model;
    }


    /**
     * Delete a Model
     *
     * @param Model $model
     * @throws \Exception
     */
    public function delete(Model $model): void
    {
        $model->delete();
    }

    /**
     * Empty the table
     */
    public function truncate(): void
    {
        $this->newQuery()->truncate();
    }


    /**
     * Return Query instance
     *
     * @return Builder
     */
    public function newQuery(): Builder
    {
        return $this->model->newQuery();
    }
}
