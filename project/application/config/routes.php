<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'landingpage';
$route['sobre'] = 'landingpage/sobre';
$route['contato'] = 'landingpage/contato';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/*********************************************/

//PAINEL
$route['painel'] = 'painel';

//CLIENTE
$route['painel/clientes'] = 'client';
$route['painel/clientes/novo'] = 'client/page_create';
$route['painel/clientes/create']['post'] = 'client/create';
$route['painel/clientes/update']['post'] = 'client/update';
$route['painel/clientes/status']['post'] = 'client/status';
$route['painel/clientes/update/(:any)'] = 'client/page_update';
$route['painel/clientes/delete'] = 'client/delete';

// LIVROS
$route['painel/livros'] = 'book/page_index';
$route['painel/livros/novo'] = 'book/page_create';
$route['painel/livros/pesquisa'] = 'book/page_filter';
$route['painel/livros/create']['post'] = 'book/create';
$route['painel/livros/update']['post'] = 'book/update';
$route['painel/livros/filter']['post'] = 'book/filter';
$route['painel/livros/update/(:any)'] = 'book/page_update';
$route['painel/livros/delete'] = 'book/delete';
$route['painel/livros/(:num)'] = 'book/page_index/$1';

//CATEGORIA LIVROS
$route['painel/categorias'] = 'bookCategories';
$route['painel/categorias/novo'] = 'bookCategories/page_create';
$route['painel/categorias/create']['post'] = 'bookCategories/create';
$route['painel/categorias/update']['post'] = 'bookCategories/update';
$route['painel/categorias/delete'] = 'bookCategories/delete';
$route['painel/categorias/update/(:any)'] = 'bookCategories/page_update';

//LIVROS ALUGADOS
$route['painel/livros-locado'] = 'bookLeased';
$route['painel/livros-locado/novo'] = 'bookLeased/page_create';
$route['painel/livros-locado/create']['post'] = 'bookLeased/create';
$route['painel/livros-locado/update']['post'] = 'bookLeased/update';

/*********************************************/

//PAGINA PRINCIPAL DO SITE
$route['(:any)'] = 'landingpage/index/$1';