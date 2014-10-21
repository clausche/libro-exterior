<?php
 
namespace Tricks\Repositories\Eloquent;

use Tricks\Country;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Tricks\Services\Forms\CountryForm;
use Tricks\Exceptions\CountryNotFoundException;
use Tricks\Repositories\CountryRepositoryInterface;

class CountryRepository extends AbstractRepository implements CountryRepositoryInterface
{
    /**
     * Create a new DbCountryRepository instance.
     *
     * @param  \Tricks\Country $countries
     * @return void
     */
    public function __construct(Country $country)
    {
        $this->model = $country;
    }

    /**
     * Get an array of key-value (id => name) pairs of all countries.
     *
     * @return array
     */
    public function listAll()
    {
        $countries = $this->model->all();

        return $countries;
    }

    /**
     * Find all countries.
     *
     * @param  string  $orderColumn
     * @param  string  $orderDir
     * @return \Illuminate\Database\Eloquent\Collection|\Tricks\Country[]
     */
    public function findAll($orderColumn = 'created_at', $orderDir = 'desc')
    {
        $countries = $this->model
                     ->orderBy($orderColumn, $orderDir)
                     ->get();

        return $countries;
    }

    /**
     * Find a Country by id.
     *
     * @param  mixed  $id
     * @return \Tricks\Country
     */
    public function findById($id)
    {
        return $this->model->find($id);
    }

        /**
     * Find all the countries paginated.
     *
     * @param  integer $perPage
     * @return \Illuminate\Pagination\Paginator|\Tricks\Country[]
     */
    public function BuscaTodosPaginado($perPage = 3)
    {
        $countries = $this->model->paginate($perPage);

        return $countries;
    }

    /**
     * Find all tricks order by the creation date paginated.
     *
     * @param  integer $per_page
     * @return \Illuminate\Pagination\Paginator|\Tricks\Trick[]
     */
    public function listarPorPagina($per_page = 6)
    {
        return $this->paginate($per_page = 6);
    }

    /**
     * Find all countries with the associated number of tricks.
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Tricks\Country[]
     */
    public function findAllWithTrickCount($per_page=10)
    {
       /* return $this->model
                    ->leftJoin('Country_trick', 'countries.id', '=', 'Country_trick.Country_id')
                    ->leftJoin('tricks', 'tricks.id', '=', 'Country_trick.trick_id')
                    ->groupBy('countries.slug')
                    ->orderBy('trick_count', 'desc')

                    ->get([
                        'countries.name',
                        'countries.slug',
                        DB::raw('COUNT(tricks.id) as trick_count')
                    ]);
        
       */
        $countries = $this->model
                    ->select('countries.name','countries.spanish_name','countries.slug',DB::raw('COUNT(tricks.id) as trick_count'))
                    ->leftJoin('country_trick', 'countries.id', '=', 'country_trick.country_id')
                    ->leftJoin('tricks', 'tricks.id', '=', 'country_trick.trick_id')
                    ->groupBy('countries.slug')
                    ->orderBy('trick_count', 'desc')
                    
                    ->paginate($per_page)
                    /*->get([
                        'countries.name',
                        'countries.slug',
                        DB::raw('COUNT(tricks.id) as trick_count')
                    ])*/
                    ;
                    

        return $countries;



    }
    public function findAllCountriesWithTrickCount($per_page=10)
    {
       /* return $this->model
                    ->leftJoin('Country_trick', 'countries.id', '=', 'Country_trick.Country_id')
                    ->leftJoin('tricks', 'tricks.id', '=', 'Country_trick.trick_id')
                    ->groupBy('countries.slug')
                    ->orderBy('trick_count', 'desc')

                    ->get([
                        'countries.name',
                        'countries.slug',
                        DB::raw('COUNT(tricks.id) as trick_count')
                    ]);
        
       */
        $countries = $this->model
                    ->select('countries.name','countries.spanish_name','countries.slug',DB::raw('COUNT(tricks.id) as trick_count'))
                    ->leftJoin('country_trick', 'countries.id', '=', 'country_trick.country_id')
                    ->leftJoin('tricks', 'tricks.id', '=', 'country_trick.trick_id')
                    ->groupBy('countries.slug')
                    ->orderBy('trick_count', 'desc')
                    
                    ->paginate($per_page)
                    /*->get([
                        'countries.name',
                        'countries.slug',
                        DB::raw('COUNT(tricks.id) as trick_count')
                    ])*/
                    ;
                    

        return $countries;



    }

    /**
     * Create a new Country in the database.
     *
     * @param  array  $data
     * @return \Tricks\Country
     */
    public function create(array $data)
    {
        $country = $this->getNew();

        $country->name = $data['name'];
        $country->slug = Str::slug($country->name, '-');

        $country->save();

        return $country;
    }

    /**
     * Update the specified Country in the database.
     *
     * @param  mixed  $id
     * @param  array  $data
     * @return \Tricks\Category
     */
    public function update($id, array $data)
    {
        $country = $this->findById($id);

        $country->name = $data['name'];
        $country->slug = Str::slug($country->name, '-');

        $country->save();

        return $country;
    }

    /**
     * Delete the specified Country from the database.
     *
     * @param  mixed  $id
     * @return void
     */
    public function delete($id)
    {
        $country = $this->findById($id);

        $country->tricks()->detach();

        $country->delete();
    }

    /**
     * Get the Country create/update form service.
     *
     * @return \Tricks\Services\Forms\CountryForm
     */
    public function getForm()
    {
        return new CountryForm;
    }
}
