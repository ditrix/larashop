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

Route::get('/basket/index','BasketController@index')->name('basket.index');

Route::get('/basket/checkout','BasketController@checkout')->name('basket.checkout');


Route::post('/basket/add/{id}', 'BasketController@add')->where('id', '[0-9]+')->name('basket.add');
Route::post('/basket/plus/{id}', 'BasketController@plus')->where('id', '[0-9]+')->name('basket.plus');
Route::post('/basket/minus/{id}', 'BasketController@minus')->where('id', '[0-9]+')->name('basket.minus');
Route::post('/basket/clear', 'BasketController@clear')->name('basket.clear');
Route::post('/basket/remove/{id}', 'BasketController@remove')->where('id', '[0-9]+')->name('basket.remove');

Route::name('user.')->prefix('user')->group(function () {
    Route::get('index', 'UserController@index')->name('index');
    Auth::routes();
});

Route::post('/basket/saveorder','BasketController@saveOrder')->name('basket.saveorder');

Route::get('/basket/success', 'BasketController@success')->name('basket.success');

// Route::name('admin.')->prefix('admin')->group(function () {
//     Route::get('index', 'Admin\IndexController')->name('index');
// });

// это второй вариант указания пространства имен
// Route::namespace('Admin')->name('admin.')->prefix('admin')->group(function () {
//     Route::get('index', 'IndexController')->name('index');
// });
Route::group([
    'as' => 'admin.', // имя маршрута, например admin.index
    'prefix' => 'admin', // префикс маршрута, например admin/index
    'namespace' => 'Admin', // пространство имен контроллера
    'middleware' => ['auth', 'admin'] // один или несколько посредников
], function () {
    // главная страница панели управления
    Route::get('index', 'IndexController')->name('index');
    // CRUD-операции над категориями каталога
    Route::resource('category', 'CategoryController');
    //CRUD-операции над брендами каталога
    Route::resource('brand', 'BrandController');
});

//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

