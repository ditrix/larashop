<?php

namespace App\Providers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Basket;
use View;
use Illuminate\Support\ServiceProvider;

// описание в 7.txt

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('layout.part.roots', function($view) {
            $view->with(['items' => Category::roots()]);
        });
        
        View::composer('layout.part.brands', function($view) {
            $view->with(['items' => Brand::popular()]);
        });

        View::composer('layout.site', function($view) {
            $view->with(['positions' => Basket::getBasket()->products->count()]);
        });

    }
}
