<?php

 //DB::getQueryLog();
  

Event::listen('illuminate.query', function($sql) {
            var_dump($sql);
            
        });

# Route filters
Route::when('admin/*', 'admin');
Route::when('*', 'trick.view_throttle');

# Route patterns
Route::pattern('tag_slug', '[a-z0-9\-]+');
Route::pattern('ciudad_slug', '[a-z0-9\-]+');
Route::pattern('trick_slug', '[a-z0-9\-]+');

# Admin routes
Route::group([ 'prefix' => 'admin', 'namespace' => 'Controllers\Admin' ], function () {
    Route::controller('tags', 'TagsController', [
        'getIndex' => 'admin.tags.index',
        'getView'  => 'admin.tags.view'
    ]);

    Route::controller('countries', 'CountriesController', [
        'getIndex' => 'admin.countries.index',
        'getView'  => 'admin.countries.view'
    ]);

    Route::controller('ciudades', 'CiudadesController', [
        'getIndex' => 'admin.ciudades.index',
        'getView'  => 'admin.ciudades.view'
    ]);

    Route::controller('categories', 'CategoriesController', [
        'getIndex' => 'admin.categories.index',
        'getView'  => 'admin.categories.view'
    ]);

    Route::controller('users', 'UsersController');
});

Route::group([ 'namespace' => 'Controllers' ], function () {
    # Home routes
    Route::get('/', [ 'as' => 'browse.recent', 'uses' => 'BrowseController@getBrowseRecent' ]);
    Route::get('popular', [ 'as' => 'browse.popular', 'uses' => 'BrowseController@getBrowsePopular' ]);
    Route::get('comments', [ 'as' => 'browse.comments', 'uses' => 'BrowseController@getBrowseComments' ]);
    Route::get('about', [ 'as' => 'about', 'uses' => 'HomeController@getAbout' ]);

    #Pruebas##############################################-->
    Route::get('pags', [ 'as' => 'browse.pags', 'uses' => 'PruebaController@getPruebaIndex' ]);
    ######################################################-->

    #Pruebas##############################################-->
    Route::get('countries', [ 'as' => 'browse.countries', 'uses' => 'PruebaController@getCountryIndex' ]);
    ######################################################-->

    # Trick routes
    Route::get('tricks/{trick_slug?}', [ 'as' => 'tricks.show', 'uses' => 'TricksController@getShow' ]);
    Route::post('tricks/{trick_slug}/like', [ 'as' => 'tricks.like', 'uses' => 'TricksController@postLike' ]);
    
    # Country route
    #######################################################-->
    Route::get('countries/{trick_slug?}', [ 'as' => 'countries.show', 'uses' => 'CountriesController@getShow' ]);
    Route::post('countries/{trick_slug}/like', [ 'as' => 'countries.like', 'uses' => 'CountriesController@postLike' ]); 
    #######################################################-->

    # Browse routes
    Route::get('categories', [ 'as' => 'browse.categories', 'uses' => 'BrowseController@getCategoryIndex']);
    Route::get('categories/{category_slug}', [
        'as'   => 'tricks.browse.category',
        'uses' => 'BrowseController@getBrowseCategory'
    ]);
    Route::get('tags', [ 'as' => 'browse.tags', 'uses' => 'BrowseController@getTagIndex' ]);
    Route::get('tags/{tag_slug}', [ 'as' => 'tricks.browse.tag', 'uses' => 'BrowseController@getBrowseTag' ]);
    Route::get('ciudades', [ 'as' => 'browse.ciudades', 'uses' => 'BrowseController@getCiudadIndex' ]);
    //Route::get('ciudades/{ciudad_slug}', [ 'as' => 'tricks.browse.ciudad', 'uses' => 'BrowseController@getBrowseCiudad' ]);
    //Route::get('ciudades/{ciudad_slug}', [ 'as' => 'tricks.browse.ciudad', 'uses' => 'CiudadesController@getShow' ]);
    Route::get('ciudades/{ciudad_slug}', [ 'as' => 'tricks.browse.ciudad', 'uses' => 'BrowseController@getBrowseCiudad' ]);

    # Search routes
    Route::get('search', 'SearchController@getIndex');

    # Sitemap route
    //Route::get('sitemap', 'SitemapController@getIndex');
    //Route::get('sitemap.xml', 'SitemapController@getIndex');

    # Authentication and registration routes
    Route::get('login', [ 'as' => 'auth.login', 'uses' => 'AuthController@getLogin' ]);
    Route::post('login', 'AuthController@postLogin');
    Route::get('login/github', [ 'as' => 'auth.login.github', 'uses' => 'AuthController@getLoginWithGithub' ]);
    Route::get('register', [ 'as' => 'auth.register', 'uses' => 'AuthController@getRegister']);
    Route::post('register', 'AuthController@postRegister');
    Route::get('logout', [ 'as' => 'auth.logout', 'uses' => 'AuthController@getLogout' ]);

    # Password reminder routes
    Route::controller('password', 'RemindersController', [
        'getRemind' => 'auth.remind',
        'getReset'  => 'auth.reset'
    ]);

    # User profile routes
    Route::get('user', [ 'as' => 'user.index', 'uses' => 'UserController@getIndex' ]);
    Route::get('user/settings', [ 'as' => 'user.settings', 'uses' => 'UserController@getSettings' ]);
    Route::post('user/settings', 'UserController@postSettings');
    Route::get('user/favorites', [ 'as' => 'user.favorites', 'uses' => 'UserController@getFavorites' ]);
    Route::post('user/avatar', [ 'as' => 'user.avatar', 'uses' => 'UserController@postAvatar' ]);

    # Trick creation route
    Route::get('user/tricks/new', [ 'as' => 'tricks.new', 'uses' => 'UserTricksController@getNew' ]);
    Route::post('user/tricks/new', 'UserTricksController@postNew');

    #######################################-->
    # tags creation route
    Route::get('user/tags/new', [ 'as' => 'tags.new', 'uses' => 'UserTagsController@getNew' ]);
    Route::post('user/tags/new', 'UserTagsController@postNew');
    #######################################-->

    #######################################-->
    # ciudades creation route
    Route::get('user/ciudades/new', [ 'as' => 'ciudades.new', 'uses' => 'UserCiudadesController@getNew' ]);
    Route::post('user/ciudades/new', 'UserCiudadesController@postNew');
    #######################################-->
    
    # Trick editing route
    Route::get('user/tricks/{trick_slug}', [ 'as' => 'tricks.edit', 'uses' => 'UserTricksController@getEdit' ]);
    Route::post('user/tricks/{trick_slug}', 'UserTricksController@postEdit');

    #Tag editing route ################->
    Route::get('user/tags/{tag_slug}', [ 'as' => 'tags.edit', 'uses' => 'UserTagsController@getEdit' ]);
    Route::post('user/tags/{tag_slug}', 'UserTagsController@postEdit');
    ################################################->

    #Ciudad editing route ################->
    Route::get('user/ciudades/{ciudad_slug}', [ 'as' => 'ciudades.edit', 'uses' => 'UserCiudadesController@getEdit' ]);
    Route::post('user/ciudades/{ciudad_slug}', 'UserCiudadesController@postEdit');
    ################################################->

    # Trick delete route
    Route::get('user/tricks/{trick_slug}/delete', [ 'as' => 'tricks.delete', 'uses' => 'UserTricksController@getDelete' ]);

    # Feed routes
    /*Route::get('feed', [ 'as' => 'feed.atom', 'uses' => 'FeedsController@getAtom' ]);
    Route::get('feed.atom', [ 'uses' => 'FeedsController@getAtom' ]);
    Route::get('feed.xml', [ 'as' => 'feed.rss', 'uses' => 'FeedsController@getRss' ]);*/

    # This route will match the user by username to display their public profile
    # (if we want people to see who favorites and who posts what)
    Route::get('{user}', [ 'as' => 'user.profile', 'uses' => 'UserController@getPublic' ]);
});
