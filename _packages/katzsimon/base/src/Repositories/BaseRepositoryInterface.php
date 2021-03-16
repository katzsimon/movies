<?php

namespace Katzsimon\Base\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

interface BaseRepositoryInterface
{


    /**
     * @param int $id
     * @return Model|null
     */
    public function find($id=0): ?Model;

    /**
     * @return Model|null
     */
    public function first(): ?Model;

    /**
     * @param int $id
     * @param array|string[] $columns
     * @param array $relations
     * @return Model
     */
    public function findById(int $id, array $columns = ['*'], array $relations = []): Model;

    /**
     * @param array $criteria
     * @param array $columns
     * @param array $relations
     * @return Model
     * @throws ModelNotFoundException
     */
    public function findByCriteria(array $criteria, array $columns = ['*'], array $relations = []): ?Model;

    /**
     * @param array $criteria
     * @param array $options
     * @return Collection
     */
    public function getByCriteria(array $criteria, $options=[]): Collection;

    /**
     * @return Collection
     */
    public function limit(int $limit): Collection;

    /**
     * @param string $order
     * @param array $relations
     * @return Collection
     */
    public function all($order='asc', array $relations = []): Collection;

    /**
     * @return Model
     */
    public function empty(): Model;

    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model;

    /**
     * @param Model $model
     * @param array              $attributes
     * @return Model
     */
    public function update(Model $model, array $attributes): Model;

    /**
     * @param Model $model
     * @return void
     */
    public function delete(Model $model): void;

    /**
     *
     */
    public function truncate(): void;

    /**
     * @return Builder
     */
    public function newQuery(): Builder;
}
