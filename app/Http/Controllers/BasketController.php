<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Basket;

class BasketController extends Controller
{
    
    public function index(Request $request){

        $basket_id = $request->cookie('basket_id');
      
        $products = [];    
        if(!empty($basket_id)){
            $backet  = Basket::find($basket_id);
            //var_dump($backet); die;
            if($backet !== null){
                $products = $backet->products;
            }
        }
        // } else {
        //     abort(404);
        // }


        return view('backet.index',compact('products')); // форма ввода
    }

    public function checkout(){
        return view('backet.checkout'); // форма оформления
    }

      // Добавляет товар с идентификатором $id в корзину
      // в реквесте количество. и кука-корзина.
      // т.е.  входніе данные $request->quantity $request->basket_id  $id
    public function add(Request $request, $id){

        $basket_id = $request->cookie('basket_id');
     
        $quantity = $request->quantity ?? 1;   
        
        if(empty($basket_id)) {
            
            $basket = Basket::create();
           
            $basket_id = $basket->id; 
        } else {
            //$basket = Basket::findOrFail($basket_id);
            $basket = Basket::find($basket_id);
            if($basket == null){
                $basket = Basket::create();
            } else {
            $basket->touch(); // обновдение updated_at
            }
        }

        if($basket->products->contains($id)){  // если корзина уже содержит продукт
            
            // получить запись из связующ таблицы (чтобы изменить quantity)
            $pivotRow = $basket->products()->where('product_id',$id)->first()->pivot;
            $quantity = $pivotRow->quantity + $quantity;
            $pivotRow->update(['quantity'=>$quantity]);

            /* альтернатива
            $basket->products()->updateExistingPivot($product_id,['quantity', $quantity]);
            */
        } else {
            $basket->products()->attach($id, ['quantity' => $quantity]); // просто добавляем
        }
        return back()->withCookie(cookie('basket_id', $basket_id, 525600)); // вернуться к странице с кукой
    }
    public function plus(Request $request, $id){

        $basket_id = $request->cookie('basket_id');
        
        if(empty($basket_id)){
            abort(404);
        }
        
        $this->change($basket_id, $id, 1);
        return redirect()->route('basket.index')->withCookie(cookie('basket_id', $basket_id, 525600));
    }

    public function minus(Request $request, $id){
        
        $basket_id = $request->cookie('basket_id');
        if(empty($basket_id)){
            abort(404);
        }
        $this->change($basket_id, $id, -1);
        return redirect()->route('basket.index')->withCookie(cookie('basket_id', $basket_id, 525600));
    }
    public function change($basket_id, $product_id, $count = 0){
        if($count == 0){
            return;
        }
        
        $basket = Basket::findOrFail($basket_id);
        
        if($basket->products->contains($product_id)){
           
            $pivotRow = $basket->products()->where('product_id',$product_id)->first()->pivot;
            $quantity = $pivotRow->quantity + $count; 
            if($quantity > 0){
                // обновить кол-во
                $pivotRow->update(['quantity' => $quantity]);
               
                $basket->touch();
            } else {
                // удалить товар из корзины
                $pivotRow->delete();    
            }
        }
    }
}
