<?php

namespace Tricks\Repositories;

interface CiudadRepositoryInterface
{
    /**
     * Get an array of key-value (id => name) pairs of all ciudades.
     *
     * @return array
     */
    public function listAll();

    /**
     * Find all ciudades.
     *
     * @param  string $orderColumn
     * @param  string $orderDir
     * @return \Illuminate\Database\Eloquent\Collection|\Tricks\Ciudad[]
     */
    //public function findAll($orderColumn = 'created_at', $orderDir = 'desc');
       // public function findAll($orderDir = 'desc');
    public function findAll();


    /**
     * Find a ciudad by id.
     *
     * @param  mixed $id
     * @return \Tricks\Ciudad
     */
    public function findById($id);

    /**
     * Find all ciudades with the associated number of tricks.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findAllWithTrickCount($per_page = 10);
    
    public function findAllWithCiudadCount($per_page = 10);

    /**
     * Create a new ciudad in the database.
     *
     * @param  array $data
     * @return \Tricks\Ciudad
     */
    public function create(array $data);

    /**
     * Update the specified ciudad in the database.
     *
     * @param  mixed $id
     * @param  array $data
     * @return \Tricks\Category
     */
    public function update($id, array $data);

    /**
     * Delete the specified ciudad from the database.
     *
     * @param  mixed $id
     * @return void
     */
    public function delete($id);
}
