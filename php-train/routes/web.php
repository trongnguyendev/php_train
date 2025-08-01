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

Router::post('/product/search', 'ProductController@search');

Router::get('/stock', 'StockController@index');


Router::get('/warehouse', 'WarehouseController@index');
Router::get('/warehouse/create', 'WarehouseController@create');
Router::post('/warehouse/create', 'WarehouseController@store');
Router::get('/warehouse/edit/{id}', 'WarehouseController@edit');
Router::post('/warehouse/edit/{id}', 'WarehouseController@update');
Router::get('/warehouse/delete/{id}', 'WarehouseController@delete');


Router::get('/import_receipts', 'ImportReceiptsController@index');
Router::get('/import_receipts/create', 'ImportReceiptsController@create');
Router::post('/import_receipts/create', 'ImportReceiptsController@store');
Router::get('/import_receipts/edit/{id}', 'ImportReceiptsController@edit');
Router::post('/import_receipts/edit/{id}', 'ImportReceiptsController@update');
Router::get('/import_receipts/delete/{id}', 'ImportReceiptsController@delete');
Router::get('/import_receipts/{id}', 'ImportReceiptsController@indexItems');



Router::get('/product-group', 'ProductGroupController@index');
Router::get('/product-group/create', 'ProductGroupController@create');
Router::post('/product-group/create', 'ProductGroupController@store');
Router::get('/product-group/edit/{id}' , 'ProductGroupController@edit');
Router::post('/product-group/edit/{id}', 'ProductGroupController@update');
Router::get('/product-group/delete/{id}', 'ProductGroupController@delete');
Router::get('/product-group/{id}', 'ProductGroupController@indexItems');

Router::get('/export_receipts', 'ExportReceiptsController@index');
Router::get('/export_receipts/create', 'ExportReceiptsController@create');
Router::post('/export_receipts/create', 'ExportReceiptsController@store');
Router::get('/export_receipts/edit/{id}', 'ExportReceiptsController@edit');
Router::post('/export_receipts/edit/{id}', 'ExportReceiptsController@update');
Router::get('/export_receipts/delete/{id}', 'ExportReceiptsController@delete');
Router::get('/export_receipts/{id}', 'ExportReceiptsController@indexItems');



