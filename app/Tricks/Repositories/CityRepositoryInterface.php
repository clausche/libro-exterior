<?php

namespace Tricks\Repositories;

interface CityRepositoryInterface
{
    /**
     * Get an array of key-value (id => name) pairs of all tags.
     *
     * @return array
     */
    public function listAll();

    /**
     * Find all tags.
     *
     * @param  string $orderColumn
     * @param  string $orderDir
     * @return \Illuminate\Database\Eloquent\Collection|\Tricks\Tag[]
     */
    public function findAll($orderColumn = 'created_at', $orderDir = 'desc');

    /**
     * Find a tag by id.
     *
     * @param  mixed $id
     * @return \Tricks\Tag
     */
    public function findById($id);

    /**
     * Find all tags with the associated number of tricks.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findAllWithTrickCount();

    /**
     * Find all the tricks paginated.
     *
     * @param  integer $perPage
     * @return \Illuminate\Pagination\Paginator|\Tricks\Trick[]
     */
                            
    public function findAllPaginated($perPage = 9);

    /**
     * Create a new tag in the database.
     *
     * @param  array $data
     * @return \Tricks\Tag
     */
    public function create(array $data);

    /**
     * Update the specified tag in the database.
     *
     * @param  mixed $id
     * @param  array $data
     * @return \Tricks\Category
     */
    public function update($id, array $data);

    /**
     * Delete the specified tag from the database.
     *
     * @param  mixed $id
     * @return void
     */
    public function delete($id);
}
