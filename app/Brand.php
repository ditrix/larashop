<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    public function getProducts(){
        return Product::where('brand_id',$this->id)->get();
    }
    
    public function products(){
        return $this->hasMany(Product::class); 
    }
    
    // Возвращает список популярных брендов каталога товаров, пока просто  5 брендов с наибольшим кол-вом товаров
    public static function popular() {
        return self::withCount('products')->orderByDesc('products_count')->limit(5)->get();
    }
}
