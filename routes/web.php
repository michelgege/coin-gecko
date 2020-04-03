<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|*/

Route::get('/', 'GetCurrenciesController@getCurrencies');

Route::get('/currency/{id}', 'GetCurrencyController@getCurrency');

Route::get('/portfolio', 'PortfolioController@index')->name('portfolio');

Route::post('/portfolio-insert', 'PortfolioController@insert')->name('portfolio-insert');


