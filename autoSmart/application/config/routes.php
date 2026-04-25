<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Auth
$route['login']  = 'auth/login';
$route['logout'] = 'auth/logout';

// Dashboard
$route['dashboard'] = 'dashboard/index';

// Category
$route['category']               = 'category/index';
$route['category/add']           = 'category/add';
$route['category/edit/(:num)']   = 'category/edit/$1';
$route['category/delete/(:num)'] = 'category/delete/$1';

// UOM
$route['uom']               = 'uom/index';
$route['uom/add']           = 'uom/add';
$route['uom/edit/(:num)']   = 'uom/edit/$1';
$route['uom/delete/(:num)'] = 'uom/delete/$1';

// Supplier
$route['supplier']               = 'supplier/index';
$route['supplier/add']           = 'supplier/add';
$route['supplier/edit/(:num)']   = 'supplier/edit/$1';
$route['supplier/delete/(:num)'] = 'supplier/delete/$1';

// Product
$route['product']               = 'product/index';
$route['product/add']           = 'product/add';
$route['product/edit/(:num)']   = 'product/edit/$1';
$route['product/delete/(:num)'] = 'product/delete/$1';

// Purchase
$route['purchase']             = 'purchase/index';
$route['purchase/add']         = 'purchase/add';
$route['purchase/view/(:num)'] = 'purchase/view/$1';

// Inventory / Sales Orders
$route['inventory']             = 'inventory/index';
$route['inventory/add']         = 'inventory/add';
$route['inventory/view/(:num)'] = 'inventory/view/$1';

// Stock
$route['stock']              = 'stock/index';
$route['stock/view/(:num)']  = 'stock/view/$1';

// Customers
$route['customers']               = 'customers/index';
$route['customers/add']           = 'customers/add';
$route['customers/edit/(:num)']   = 'customers/edit/$1';
$route['customers/delete/(:num)'] = 'customers/delete/$1';

// Users (admin only)
$route['users']               = 'users/index';
$route['users/add']           = 'users/add';
$route['users/edit/(:num)']   = 'users/edit/$1';
$route['users/delete/(:num)'] = 'users/delete/$1';
