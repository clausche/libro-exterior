<?php

namespace Tricks\Services\Forms;

class CiudadEditForm extends AbstractForm
{
    /**
     * The id of the trick.
     *
     * @var mixed
     */
    protected $id;

    /**
     * The validation rules to validate the input data against.
     *
     * @var array
     */
    protected $rules = [
        'name'         => 'required|min:4|unique:tags,name',
        'slug'         => 'required|min:4',
       // 'spanish_name' => 'required',
       // 'iso2'         => 'required'
        //'ciudades'      => 'required'
        //'code'          => 'required'

    ];

    public function __construct($id)
    {
        parent::__construct();

        $this->id = $id;
    }

    /**
     * Get the prepared validation rules.
     *
     * @return array
     */
    protected function getPreparedRules()
    {
        $this->rules['name'] .= ',' . $this->id;

        return $this->rules;
    }

    /**
     * Get the prepared input data.
     *
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, [
            'name', 'slug'//, 'spanish_name', 'iso2'//, 'code'
            //'ciudades'

            ]);
    }
}
