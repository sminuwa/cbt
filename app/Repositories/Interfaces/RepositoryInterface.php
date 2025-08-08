<?php

namespace App\Repositories\Interfaces;

interface RepositoryInterface
{
    /**
     * Find a model by its primary key
     */
    public function find(int $id);

    /**
     * Find a model by its primary key or throw an exception
     */
    public function findOrFail(int $id);

    /**
     * Get all models
     */
    public function all();

    /**
     * Create a new model
     */
    public function create(array $data);

    /**
     * Update a model
     */
    public function update(int $id, array $data);

    /**
     * Delete a model
     */
    public function delete(int $id): bool;

    /**
     * Find models by specified criteria
     */
    public function findBy(array $criteria);

    /**
     * Find a single model by specified criteria
     */
    public function findOneBy(array $criteria);

    /**
     * Count models by specified criteria
     */
    public function countBy(array $criteria): int;

    /**
     * Get paginated results
     */
    public function paginate(int $perPage = 15, array $criteria = []);
}

