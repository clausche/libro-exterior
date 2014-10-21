<?php
 
namespace Controllers;

use Tricks\Repositories\TagRepositoryInterface;
use Tricks\Repositories\CountryRepositoryInterface;
use Tricks\Repositories\CiudadRepositoryInterface;
use Tricks\Repositories\TrickRepositoryInterface;
use Tricks\Repositories\CategoryRepositoryInterface;

class PruebaController extends BaseController
{
    /**
     * Category repository.
     *
     * @var \Tricks\Repositories\CategoryRepositoryInterface
     */
    protected $categories;

    /**
     * Tags repository.
     *
     * @var \Tricks\Repositories\TagRepositoryInterface
     */
    protected $tags;

    protected $countries;

    /**
     * Ciudades repository.
     *
     * @var \Tricks\Repositories\CiudadRepositoryInterface
     */
    protected $ciudades;

    /**
     * Trick repository.
     *
     * @var \Tricks\Repositories\TrickRepositoryInterface
     */
    protected $tricks;

    /**
     * Create a new BrowseController instance.
     *
     * @param  \Tricks\Repositories\CategoryRepositoryInterface  $categories
     * @param  \Tricks\Repositories\TagRepositoryInterface  $tags
     * @param  \Tricks\Repositories\CiudadesRepositoryInterface  $ciudades     
     * @param  \Tricks\Repositories\TrickRepositoryInterface  $tricks
     * @return void
     */
    public function __construct(
        CategoryRepositoryInterface $categories,
        CountryRepositoryInterface $countries,
        TagRepositoryInterface $tags,
        CiudadRepositoryInterface $ciudades,
        TrickRepositoryInterface $tricks
    ) {
        parent::__construct();

        $this->categories = $categories;
        $this->countries = $countries;
        $this->tags       = $tags;
        $this->ciudades   = $ciudades;
        $this->tricks     = $tricks;
    }

    /**
     * Show the categories index.
     *
     * @return \Response
     */
    public function getCategoryIndex()
    {
        $categories = $this->categories->findAllWithTrickCount();

        $this->view('browse.categories', compact('categories'));
    }

    /**
     * Show the countries index.
     *
     * @return \Response
     */
    public function getCountryIndex()
    {
        $countries = $this->countries->findAllCountriesWithTrickCount();

        $this->view('browse.countries', compact('countries'));
    }

    /**
     * Show the browse by category page.
     *
     * @param  string  $category
     * @return \Response
     */
    public function getBrowseCategory($category)
    {
        list($category, $tricks) = $this->tricks->findByCategory($category);

        $type      = \Lang::get('browse.category', array('category' => $category->name));
        $pageTitle = \Lang::get('browse.browsing_category', array('category' => $category->name));

        $this->view('browse.index', compact('tricks', 'type', 'pageTitle'));
    }

    /**
     * Show the tags index.
     *
     * @return \Response
     */
    public function getTagIndex($per_page=10)
    {
        $tags = $this->tags->findAllWithTrickCount($per_page=10);
        //$page = $this->tags->BuscaTodosPaginado();
        

        $this->view('browse.pags', compact('tags','page'));
    }

    public function getPruebaIndex()
    {
        $tags = $this->tags->findAllWithTrickCount();
        //$page = Country::all();
        
        $this->view('browse.pags', compact('tags'));
    }

    /*public function getCountryIndex()
    {
        $countries = $this->tags->findAllWithTrickCount();
        //$page = Country::all();
        
        $this->view('browse.countries', compact('countries'));
    }*/

/**
     * Show the ciudades index.
     *
     * @return \Response
     */
    public function getCiudadIndex()
    {
        $ciudades = $this->ciudades->findAllWithTrickCount();

        $this->view('browse.ciudades', compact('ciudades'));
    }

    /**
     * Show the browse by tag page.
     *
     * @param  string  $tag
     * @return \Response
     */
    public function getBrowseTag($tag)
    {
        list($tag, $tricks) = $this->tricks->findByTag($tag);

        $type      = \Lang::get('browse.tag', array('tag' => $tag->name));
        $pageTitle = \Lang::get('browse.browsing_tag', array('tag' => $tag->name));

        $this->view('browse.index', compact('tricks', 'type', 'pageTitle'));
    }

    /**
     * Show the browse by ciudad page.
     *
     * @param  string  $ciudad
     * @return \Response
     */
    public function getBrowseCountry($country)
    {
        list($country, $tricks) = $this->tricks->findByCountry($country);

        $type      = \Lang::get('browse.country', array('country' => $country->name));
        $pageTitle = \Lang::get('browse.browsing_country', array('country' => $country->name));

        $this->view('browse.index', compact('tricks', 'type', 'pageTitle'));
    }

    /**
     * Show the browse by ciudad page.
     *
     * @param  string  $ciudad
     * @return \Response
     */
    public function getBrowseCiudad($ciudad)
    {
        list($ciudad, $tricks) = $this->tricks->findByCiudad($ciudad);

        $type      = \Lang::get('browse.ciudad', array('ciudad' => $ciudad->name));
        $pageTitle = \Lang::get('browse.browsing_ciudad', array('ciudad' => $ciudad->name));

        $this->view('browse.index', compact('tricks', 'type', 'pageTitle'));
    }

    /**
     * Show the browse recent tricks page.
     *
     * @return \Response
     */
    public function getBrowseRecent()
    {
        $tricks = $this->tricks->findMostRecent();

        $type      = \Lang::get('browse.recent');
        $pageTitle = \Lang::get('browse.browsing_most_recent_tricks');

        $this->view('browse.index', compact('tricks', 'type', 'pageTitle'));
    }

    /**
     * Show the browse popular tricks page.
     *
     * @return \Response
     */
    public function getBrowsePopular()
    {
        $tricks = $this->tricks->findMostPopular();

        $type      = \Lang::get('browse.popular');
        $pageTitle = \Lang::get('browse.browsing_most_popular_tricks');

        $this->view('browse.index', compact('tricks', 'type', 'pageTitle'));
    }

    /**
     * Show the browse most commented tricks page.
     *
     * @return \Response
     */
    public function getBrowseComments()
    {
        $tricks = $this->tricks->findMostCommented();

        $type      = \Lang::get('browse.most_commented');
        $pageTitle = \Lang::get('browse.browsing_most_commented_tricks');

        $this->view('browse.index', compact('tricks', 'type', 'pageTitle'));
    }
}
