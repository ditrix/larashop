<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    /** Связь «многие ко многим» таблицы `baskets` с таблицей `products` */
    public function products() {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }

    /* Увеличивает кол-во товара $id в корзине на величину $count
    */
   public function increase($id, $count = 1) {
       $this->change($id, $count);
   }

   /**
    * Уменьшает кол-во товара $id в корзине на величину $count
    */
   public function decrease($id, $count = 1) {
       $this->change($id, -1 * $count);
   }

   /**
     * Изменяет количество товара $id в корзине на величину $count;
     * если товара еще нет в корзине — добавляет этот товар; $count
     * может быть как положительным, так и отрицательным числом
     */
   public function change($id, $count = 0){
       if($count == 0){
           return;
       }
       if($this->products->contains($id)){
            $pivotRow = $this->products()->where('product_id',$id)->first()->pivot;
            $quantity = $pivotRow->quantity + $count;
            if($quantity > 0){
                $pivotRow->update(['quantity' => $quantity]);
            } else {
                $pivotRow->delete();
            }    
       } else {
           if($count > 0){
               $this->products()->attach($id,['quantity' => $count]);
           }
       }
       $this->touch();
   }

   public function remove($id){
    // удаляем товар из корзины (разрушаем связь)
        $this->products()->detach($id);
    // обновляем поле `updated_at` таблицы `baskets`
        $this->touch();
   }
}
