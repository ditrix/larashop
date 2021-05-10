<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    public function getProducts(){
        return Product::where('category_id',$this->id)->get();
    }
     /**
     * Связь «один ко многим» таблицы `categories` с таблицей `products`
     */
    public function products() {
        return $this->hasMany(Product::class);
    }

    // /** Возвращает список корневых категорий каталога товаров */
    // public static function roots() {
    //     return self::where('parent_id', 0)->get();
    // }

    public function children() {
        return $this->hasMany(Category::class, 'parent_id');
    }
    public static function roots() {
        return self::where('parent_id', 0)->with('children')->get();
    }
}
