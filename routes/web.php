<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


// маршрут для главной страницы без указания метода
Route::get('/', 'IndexController')->name('index');

Route::get('/catalog/index','CatalogController@index')->name('catalog.index');
Route::get('/catalog/category/{slug}','CatalogController@category')->name('catalog.category');
Route::get('/catalog/brand/{slug}','CatalogController@brand')->name('catalog.brand');
Route::get('/catalog/product/{slug}','CatalogController@product')->name('catalog.product');
