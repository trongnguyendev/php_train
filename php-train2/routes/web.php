<?php

use Core\Router;

Router::get('/', 'DashboardController@index');

Router::get('/import_receipts', 'Import_receiptsController@index');
Router::get('/import_receipts/create', 'Import_receiptsController@create');
Router::post('/import_receipts/create', 'Import_receiptsController@store');
Router::get('/import_receipts/edit/{id}', 'Import_receiptsController@edit');
Router::post('/import_receipts/edit/{id}', 'Import_receiptsController@update');
Router::get('/import_receipts/delete/{id}', 'Import_receiptsController@delete');

Router::get('/import_receipts/{id}', 'Import_receiptsController@indexItems');