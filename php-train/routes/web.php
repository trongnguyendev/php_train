<?php

use Core\Router;

Router::get('/', 'DashboardController@index');

Router::get('/login', 'AuthController@showLogin');

Router::get('/employee', 'EmployeeController@index');
Router::get('/employee/create', 'EmployeeController@create');
Router::post('/employee/create', 'EmployeeController@store');
Router::get('/employee/edit/{id}', 'EmployeeController@edit');
Router::post('/employee/edit/{id}', 'EmployeeController@update');
Router::get('/employee/delete/{id}', 'EmployeeController@delete');

Router::get('/customer', 'CustomerController@index');
Router::get('/customer/create', 'CustomerController@create');
Router::post('/customer/create', 'CustomerController@store');
Router::get('/customer/edit/{id}', 'CustomerController@edit');
Router::post('/customer/edit/{id}', 'CustomerController@update');
Router::get('/customer/delete/{id}', 'CustomerController@delete');

Router::get('/login', 'AuthController@showLogin');
Router::post('/login', 'AuthController@postLogin');