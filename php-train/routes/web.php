<?php

use Core\Router;

Router::get('/', 'DashboardController@index');

Router::get('/employee', 'EmployeeController@index');
Router::get('/employee/create', 'EmployeeController@create');
Router::post('/employee/create', 'EmployeeController@store');
Router::get('/employee/edit/{id}', 'EmployeeController@edit');
Router::post('/employee/edit/{id}', 'EmployeeController@update');
Router::get('/employee/delete/{id}', 'EmployeeController@delete');

Router::get('/login', 'AuthController@showLogin');
Router::post('/login', 'AuthController@postLogin');
Router::get('/logout', 'AuthController@logout');

Router::get('/customer', 'CustomerController@index');
Router::get('/customer/create', 'CustomerController@create');
Router::post('/customer/create', 'CustomerController@store');
Router::get('/customer/edit/{id}' , 'CustomerController@edit');
Router::post('/customer/edit/{id}', 'CustomerController@update');
Router::get('/customer/delete/{id}', 'CustomerController@delete');


Router::get('/user', 'UserController@index');
Router::get('/user/create', 'UserController@create');
Router::post('/user/create', 'UserController@store');
Router::get('/user/edit/{id}' , 'UserController@edit');
Router::post('/user/edit/{id}', 'UserController@update');
Router::get('/user/delete/{id}', 'UserController@delete');

Router::get('/product', 'ProductController@index');
Router::get('/product/create', 'ProductController@create');
Router::post('/product/create', 'ProductController@store');
Router::get('/product/edit/{id}', 'ProductController@edit');
Router::post('/product/edit/{id}', 'ProductController@update');
Router::get('/product/delete/{id}', 'ProductController@delete');

Router::get('/stock', 'StockController@index');


Router::get('/warehouse', 'WarehouseController@index');
Router::get('/warehouse/create', 'WarehouseController@create');
Router::post('/warehouse/create', 'WarehouseController@store');
Router::get('/warehouse/edit/{id}', 'WarehouseController@edit');
Router::post('/warehouse/edit/{id}', 'WarehouseController@update');
Router::get('/warehouse/delete/{id}', 'WarehouseController@delete');


Router::get('/import_receipts', 'Import_receiptsController@index');
Router::get('/import_receipts/create', 'Import_receiptsController@create');
Router::post('/import_receipts/create', 'Import_receiptsController@store');
Router::get('/import_receipts/edit/{id}', 'Import_receiptsController@edit');
Router::post('/import_receipts/edit/{id}', 'Import_receiptsController@update');
Router::get('/import_receipts/delete/{id}', 'Import_receiptsController@delete');


Router::get('/import_items', 'Import_itemsController@index');
Router::get('/import_items/create', 'Import_itemsController@create');
Router::post('/import_items/create', 'Import_itemsController@store');
Router::get('/import_items/edit/{id}', 'Import_itemsController@edit');
Router::post('/import_items/edit/{id}', 'Import_itemsController@update');
Router::get('/import_items/delete/{id}', 'Import_itemsController@delete');