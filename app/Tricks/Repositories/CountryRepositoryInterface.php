<?php

namespace Tricks\Repositories;

interface CountryRepositoryInterface
{
    /**
     * Get an array of key-value (id => name) pairs of all countries.
     *
     * @return array
     */
    public function listAll();

    /**
     * Find all countries.
     *
     * @param  string $orderColumn
     * @param  string $orderDir
     * @return \Illuminate\Database\Eloquent\Collection|\Tricks\Country[]
     */
    public function findAll($orderColumn = 'created_at', $orderDir = 'desc');

    /**
     * Find a country by id.
     *
     * @param  mixed $id
     * @return \Tricks\Country
     */
    public function findById($id);

    /**
     * Find all countries with the associated number of tricks.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findAllWithTrickCount();

    /**
     * Create a new country in the database.
     *
     * @param  array $data
     * @return \Tricks\Country
     */
    public function create(array $data);

    /**
     * Update the specified country in the database.
     *
     * @param  mixed $id
     * @param  array $data
     * @return \Tricks\Category
     */
    public function update($id, array $data);

    /**
     * Delete the specified country from the database.
     *
     * @param  mixed $id
     * @return void
     */
    public function delete($id);
}
