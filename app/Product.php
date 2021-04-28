<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    
    /* один из вариантов */
    public function getCategory(){
        return Category::find($this->category_id);
    }

    public function getBrand(){
         return Brand::find($this->brand_id);
    }



     /* другой вариант (используем связи) */   
     /**
     * Связь «товар принадлежит» таблицы `products` с таблицей `categories`
     */
     public function category() {
        return $this->belongsTo(Category::class);
    }

    /**
     * Связь «товар принадлежит» таблицы `products` с таблицей `brands`
     */
    public function brand() {
        return $this->belongsTo(Brand::class);
    }
}
