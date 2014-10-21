<?php

namespace Tricks\Repositories\Eloquent;

use Tricks\User;
use Tricks\Trick;
use Tricks\Ciudad;
use Tricks\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Tricks\Services\Forms\CiudadForm;
use Tricks\Services\Forms\CiudadEditForm;
use Illuminate\Database\Eloquent\Collection;
use Tricks\Exceptions\CiudadNotFoundException;
use Tricks\Repositories\TrickRepositoryInterface;
use Tricks\Repositories\CiudadRepositoryInterface;

class CiudadRepository extends AbstractRepository implements CiudadRepositoryInterface
{
    /**
     * Create a new DbCiudadRepository instance.
     *
     * @param  \Tricks\Ciudad $ciudades
     * @return void
     */
    public function __construct(Ciudad $ciudad)
    {
        $this->model = $ciudad;
    }

    /**
     * Get an array of key-value (id => name) pairs of all ciudades.
     *
     * @return array
     */
    /*public function listAll()
    {
        $ciudades = $this->model->lists('name', 'id');

        return $ciudades;
    }*/
    public function listAll()
    {
        $ciudades = $this->model->orderBy('name', 'asc')->lists('name', 'id');
        return $ciudades;
    }

    /**
     * Find all ciudades.
     *
     * @param  string  $orderColumn
     * @param  string  $orderDir
     * @return \Illuminate\Database\Eloquent\Collection|\Tricks\Ciudad[]
     */
    /*public function findAll($orderColumn = 'created_at', $orderDir = 'desc')
    {
        $ciudades = $this->model
                     ->orderBy($orderColumn, $orderDir)
                     ->get();

        return $ciudades;
    }
*/
    public function findAll()
    {
        $ciudades = $this->model
                     
                     ->get();

        return $ciudades;
    }

    /**
     * Find a ciudad by id.
     *
     * @param  mixed  $id
     * @return \Tricks\Ciudad
     */
    public function findById($id)
    {
        return $this->model->find($id);
    }

    /**
     * Find all ciudades with the associated number of tricks.
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Tricks\Ciudad[]
     */
    public function findAllWithTrickCount($per_page = 10)
    {
        return $this->model
                    ->select('ciudad.name','ciudad.slug',DB::raw('COUNT(tricks.id) as trick_count'))
                    ->leftJoin('ciudad_trick', 'ciudades.id', '=', 'ciudad_trick.ciudad_id')
                    ->leftJoin('tricks', 'tricks.id', '=', 'ciudad_trick.trick_id')
                    ->groupBy('ciudades.slug')
                    ->orderBy('trick_count', 'desc')
                    ->paginate($per_page);
    }

    public function findAllWithCiudadCount($per_page = 10)
    {
        return $this->model
                    ->select('ciudades.name','ciudades.slug',DB::raw('COUNT(tricks.id) as trick_count'))
                    ->leftJoin('ciudad_trick', 'ciudades.id', '=', 'ciudad_trick.ciudad_id')
                    ->leftJoin('tricks', 'tricks.id', '=', 'ciudad_trick.trick_id')
                    ->groupBy('ciudades.slug')
                    ->orderBy('trick_count', 'desc')
                    ->paginate($per_page);
    }

    /**
     * Find a ciudades by the given slug.
     *
     * @param  string $slug
     * @return \Tricks\Ciudad
     */
    public function findBySlug($slug)
    {
        return $this->model->whereSlug($slug)->first();
    }

    /**
     * Create a new ciudad in the database.
     *
     * @param  array  $data
     * @return \Tricks\Ciudad
     */
    public function create(array $data)
    {
        $ciudad = $this->getNew();

        $ciudad->name = $data['name'];
        $ciudad->slug = Str::slug($ciudad->name, '-');

        $ciudad->save();

        return $ciudad;
    }

    /**
     * Update the ciudad in the database.
     *
     * @param  \Tricks\Ciudad $ciudad
     * @param  array $data
     * @return \Tricks\Ciudad
     */
    public function edit(Ciudad $ciudad, array $data)
    {
        //$tag->user_id = $data['user_id'];
        $ciudad->name       = e($data['name']);
        $ciudad->slug        = Str::slug($data['slug'], '-');
        //$ciudad->spanish_name = e($data['spanish_name']);
        //$ciudad->iso2 = e($data['iso2']);
        //$tag->code        = $data['code'];

        $ciudad->save();

        //$tag->tags()->sync($data['tags']);
        //$tag->ciudades()->sync($data['ciudades']);
        //$tag->categories()->sync($data['categories']);

        return $ciudad;
    }

    /**
     * Update the specified ciudad in the database.
     *
     * @param  mixed  $id
     * @param  array  $data
     * @return \Tricks\Category
     */
    public function update($id, array $data)
    {
        $ciudad = $this->findById($id);

        $ciudad->name = $data['name'];
        $ciudad->slug = Str::slug($ciudad->name, '-');

        $ciudad->save();

        return $ciudad;
    }

    /**
     * Delete the specified ciudad from the database.
     *
     * @param  mixed  $id
     * @return void
     */
    public function delete($id)
    {
        $ciudad = $this->findById($id);

        $ciudad->tricks()->detach();

        $ciudad->delete();
    }

    /**
     * Get the ciudad create/update form service.
     *
     * @return \Tricks\Services\Forms\CiudadForm
     */
    public function getForm()
    {
        return new CiudadForm;
    }
    /**
     * Get the ciudad edit form service.
     *
     * @return \Tricks\Services\Forms\CiudadEditForm
     */
    public function getEditForm($id)
    {
        return new CiudadEditForm($id);
    }
}
