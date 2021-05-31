<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{

    protected $fillable = [
        'name',
        'slug',
        'content',
        'image',
    ];
    
    public function products(){
        return $this->hasMany(Product::class); 
    }
    
    // Возвращает список популярных брендов каталога товаров, пока просто  5 брендов с наибольшим кол-вом товаров
    public static function popular() {
        return self::withCount('products')->orderByDesc('products_count')->limit(5)->get();
    }
}
