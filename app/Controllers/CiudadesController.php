<?php

namespace Controllers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Tricks\Repositories\TrickRepositoryInterface;
use Tricks\Repositories\CiudadRepositoryInterface;
use Tricks\Repositories\CategoryRepositoryInterface;

class CiudadesController extends BaseController
{
    /**
     * Trick repository.
     *
     * @var \Tricks\Repositories\TrickRepositoryInterface
     */
    protected $tricks;

    protected $ciudades;

    protected $categories;


    /**
     * Create a new TricksController instance.
     *
     * @param \Tricks\Repositories\TrickRepositoryInterface  $tricks
     * @return void
     */
    public function __construct(CiudadRepositoryInterface $ciudades, 
                                TrickRepositoryInterface $tricks,
                                CategoryRepositoryInterface $categories
                                )
    {
        parent::__construct();

        $this->ciudades = $ciudades;
        $this->tricks = $tricks;
        $this->categories = $categories;
        
    }

    /**
     * Show the single trick page.
     *
     * @param  string $slug
     * @return \Response
     */
    public function getShow($slug = null)
    {
        if (is_null($slug)) {
            return $this->redirectRoute('home');
        }

        $ciudad = $this->ciudades->findBySlug($slug);
        $trick = $this->tricks->findAll();
        $category = $this->categories->findAll();
        

        if (is_null($ciudad)) {
            return $this->redirectRoute('home');
        }

        //Event::fire('trick.view', $ciudad);

        //$next = $this->tricks->findNextTrick($trick);
        //$prev = $this->tricks->findPreviousTrick($trick);

        $this->view('ciudades.single', compact('ciudad', 'trick', 'category'));
    }

    /**
     * Handle the liking of a trick.
     *
     * @param  string $slug
     * @return \Response
     */
    /*public function postLike($slug)
    {
        if (! Request::ajax() || ! Auth::check()) {
            $this->redirectRoute('browse.recent');
        }

        $trick = $this->tricks->findBySlug($slug);

        if (is_null($trick)) {
            return Response::make('error', 404);
        }

        $user = Auth::user();

        $voted = $trick->votes()->whereUserId($user->id)->first();

        if(!$voted) {

            $user = $trick->votes()->attach($user->id, [
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime
            ]);
            $trick->vote_cache = $trick->vote_cache + 1;

        } else {
            $trick->votes()->detach($voted->id);
            $trick->vote_cache = $trick->vote_cache - 1;
        }

        $trick->save();

        return Response::make($trick->vote_cache, 200);
    }
*/
}
