<?php

// Defining menu structure here
// the items that need to appear when user is logged in should have logged_in set as true
return array(

	'menu' => array(
		array(
			'label' => 'Explora',
			'route' => 'browse.recent',
			'active' => array('/','popular','comments')
		),
	/*	array(
			'label' => 'Categories',
			'route' => 'browse.categories',
			'active' => array('categories*')
		),*/
		/*array(
			'label' => 'Ciudades',
			'route' => 'browse.ciudades',
			'active' => array('ciudadess*')
		),
	array(
			'label' => 'Paises',
			'route' => 'browse.countries',
			'active' => array('countries*')
		),
		array(
			'label' => 'Paises',
			'route' => 'browse.tags',
			'active' => array('tags*')
		),
		array(
			'label' => 'Pags',
			'route' => 'browse.pags',
			'active' => array('pags*')
		),
		*/
		array(
			'label' => 'Nuevo Registro',
			'route' => 'tricks.new',
			'active' => array('user/tricks/new'),
			// 'logged_in' => true
		),
		array(
			'label' => 'Nuevo País',
			'route' => 'tags.new',
			'active' => array('user/tags/new'),
			// 'logged_in' => true
		)

	),

	'browse' => array(
		array(
			'label' => 'Más recientes',
			'route' => 'browse.recent',
			'active' => array('/')
		),
		/*array(
			'label' => 'Most popular',
			'route' => 'browse.popular',
			'active' => array('popular')
		),*/
		/*array(
			'label' => 'Most commented',
			'route' => 'browse.comments',
			'active' => array('comments')
		),*/
	),

);
