<?php

namespace Controllers\Admin;

use Controllers\BaseController;
use Tricks\Repositories\CountryRepositoryInterface;

class CountriesController extends BaseController
{
    /**
     * Country repository.
     *
     * @var \Tricks\Repositories\CountryRepositoryInterface
     */
    protected $countries;

    /**
     * Create a new CountriesController instance.
     *
     * @param  \Tricks\Repositories\CountryRepositoryInterface  $countries
     * @return void
     */
    public function __construct(CountryRepositoryInterface $countries)
    {
        parent::__construct();

        $this->countries = $countries;
    }

    /**
     * Show the countries index page.
     *
     * @return \Response
     */
    public function getIndex()
    {
        $countries = $this->countries->findAll();

        $this->view('admin.countries.list', compact('countries'));
    }

    /**
     * Delete a country from the database.
     *
     * @param  mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDelete($id)
    {
        $this->countries->delete($id);

        return $this->redirectRoute('admin.countries.index');
    }

    /**
     * Show the country edit form.
     *
     * @param  mixed $id
     * @return \Response
     */
    public function getView($id)
    {
        $country = $this->countries->findById($id);

        $this->view('admin.countries.edit', compact('country'));
    }

    /**
     * Handle the creation of a country.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postIndex()
    {
        $form = $this->countries->getForm();

        if (! $form->isValid()) {
            return $this->redirectRoute('admin.countries.index')
                        ->withErrors($form->getErrors())
                        ->withInput();
        }

        $country = $this->countries->create($form->getInputData());

        return $this->redirectRoute('admin.countries.index');
    }

    /**
     * Handle the editing of a country.
     *
     * @param  mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postView($id)
    {
        $form = $this->countries->getForm();

        if (! $form->isValid()) {
            return $this->redirectRoute('admin.countries.view', $id)
                        ->withErrors($form->getErrors())
                        ->withInput();
        }

        $country = $this->countries->update($id, $form->getInputData());

        return $this->redirectRoute('admin.countries.view', $id);
    }
}
