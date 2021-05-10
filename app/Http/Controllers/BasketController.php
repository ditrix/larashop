<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Basket;
use App\Models\Order;
use Cookie;

class BasketController extends Controller
{

    private $basket;

    public function __construct(){
       $this->basket =  Basket::getBasket();
    }

    
    public function index(Request $request){

        $basket_id = $request->cookie('basket_id');
      
        $products = [];    
        if(!empty($basket_id)){
            $backet  = Basket::find($basket_id);
            if($backet !== null){
                $products = $backet->products;
            }
        }
        // } else {
        //     abort(404);
        // }


        return view('basket.index',compact('products')); // форма ввода
    }

    public function checkout(){
        return view('basket.checkout'); // форма оформления
    }



    /**
     * Добавляет товар с идентификатором $id в корзину
     */
    public function add(Request $request, $id) {
        // dump($this->basket);
        // die;
        $quantity = $request->input('quantity') ?? 1;
        $this->basket->increase($id, $quantity);
        // выполняем редирект обратно на ту страницу,
        // где была нажата кнопка «В корзину»
        return back();
    }
    public function plus($id){   
        $this->basket->increase($id);
        return redirect()->route('basket.index');
    }


    public function minus($id){   
        $this->basket->decrease($id);
        return redirect()->route('basket.index');
    }

    public function remove($id){
        $this->basket->remove($id);
        return redirect()->route('basket.index');
    }

    public function clear(){
        $this->basket->delete();
        return redirect()->route('basket.index');
    }

    public function saveOrder(Request $request){
         // проверяем данные формы оформления
         $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|max:255',
            'address' => 'required|max:255',
        ]);

          // валидация пройдена, сохраняем заказ
        $basket = Basket::getBasket();
        $user_id = auth()->check() ? auth()->user()->id : null;
        $order = Order::create(
            $request->all() + ['amount' => $basket->getAmount(), 'user_id' => $user_id]
        );

        foreach ($basket->products as $product) {
            $order->items()->create([
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $product->pivot->quantity,
                'cost' => $product->price * $product->pivot->quantity,
            ]);
        }

        // уничтожаем корзину
        $basket->delete();

        return redirect()
            ->route('basket.success')
            ->with('success', 'Ваш заказ успешно размещен');        
    }    
      /**
     * Сообщение об успешном оформлении заказа
     */
    public function success(Request $request) {
        if ($request->session()->exists('order_id')) {
            // сюда покупатель попадает сразу после успешного оформления заказа
            $order_id = $request->session()->pull('order_id');
            $order = Order::findOrFail($order_id);
            return view('basket.success', compact('order'));
        } else {
            // если покупатель попал сюда случайно, не после оформления заказа,
            // ему здесь делать нечего — отправляем на страницу корзины
            return redirect()->route('basket.index');
        }
    }

}



    /*
        код при пустой модели

      // Добавляет товар с идентификатором $id в корзину
      // в реквесте количество. и кука-корзина.
      // т.е.  входніе данные $request->quantity $request->basket_id  $id
    public function _add(Request $request, $id){

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

            // альтернатива
            //$basket->products()->updateExistingPivot($product_id,['quantity', $quantity]);
            
        } else {
            $basket->products()->attach($id, ['quantity' => $quantity]); // просто добавляем
        }
        return back()->withCookie(cookie('basket_id', $basket_id, 525600)); // вернуться к странице с кукой
    }

    public function _plus(Request $request, $id){
        $basket_id = $request->cookie('basket_id');
        if(empty($basket_id)){
            abort(404);
        }
        $this->change($basket_id, $id, 1);
        return redirect()->route('basket.index')->withCookie(cookie('basket_id', $basket_id, 525600));
    }

    public function _minus(Request $request, $id){
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
    */

