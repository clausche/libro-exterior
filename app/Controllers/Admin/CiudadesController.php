<?php

namespace Controllers\Admin;

use Controllers\BaseController;
use Tricks\Repositories\CiudadRepositoryInterface;

class CiudadesController extends BaseController
{
    /**
     * Ciudad repository.
     *
     * @var \Tricks\Repositories\CiudadRepositoryInterface
     */
    protected $ciudades;

    /**
     * Create a new CiudadesController instance.
     *
     * @param  \Tricks\Repositories\CiudadRepositoryInterface  $ciudades
     * @return void
     */
    public function __construct(CiudadRepositoryInterface $ciudades)
    {
        parent::__construct();

        $this->ciudades = $ciudades;
    }

    /**
     * Show the ciudades index page.
     *
     * @return \Response
     */
    public function getIndex()
    {
        $ciudades = $this->ciudades->findAll();

        $this->view('admin.ciudades.list', compact('ciudades'));
    }

    /**
     * Delete a ciudad from the database.
     *
     * @param  mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDelete($id)
    {
        $this->ciudades->delete($id);

        return $this->redirectRoute('admin.ciudades.index');
    }

    /**
     * Show the ciudad edit form.
     *
     * @param  mixed $id
     * @return \Response
     */
    public function getView($id)
    {
        $ciudad = $this->ciudades->findById($id);

        $this->view('admin.ciudades.edit', compact('ciudad'));
    }

    /**
     * Handle the creation of a ciudad.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postIndex()
    {
        $form = $this->ciudades->getForm();

        if (! $form->isValid()) {
            return $this->redirectRoute('admin.ciudades.index')
                        ->withErrors($form->getErrors())
                        ->withInput();
        }

        $ciudad = $this->ciudades->create($form->getInputData());

        return $this->redirectRoute('admin.ciudades.index');
    }

    /**
     * Handle the editing of a ciudad.
     *
     * @param  mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postView($id)
    {
        $form = $this->ciudades->getForm();

        if (! $form->isValid()) {
            return $this->redirectRoute('admin.ciudades.view', $id)
                        ->withErrors($form->getErrors())
                        ->withInput();
        }

        $ciudad = $this->ciudades->update($id, $form->getInputData());

        return $this->redirectRoute('admin.ciudades.view', $id);
    }
}
