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
Router::get('/stock/create', 'StockController@create');
Router::post('/stock/create', 'StockController@store');
Router::get('/stock/edit/{id}', 'StockController@edit');
Router::post('/stock/edit/{id}', 'StockController@update');
Router::get('/stock/delete/{id}', 'StockController@delete');


Router::get('/warehouse', 'WarehouseController@index');
Router::get('/warehouse/create', 'WarehouseController@create');
Router::post('/warehouse/create', 'WarehouseController@store');
Router::get('/warehouse/edit/{id}', 'WarehouseController@edit');
Router::post('/warehouse/edit/{id}', 'WarehouseController@update');
Router::get('/warehouse/delete/{id}', 'WarehouseController@delete');