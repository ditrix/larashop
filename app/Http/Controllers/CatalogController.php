<?php

namespace App\Http\Controllers;
use App\Brand;
use App\Product;
use App\Category;

use Illuminate\Http\Request;

class CatalogController extends Controller {
    //
    public function index(){
        $roots = Category::where('parent_id',0)->get();
        return view('catalog.index',compact('roots'));
    }
    public function category($slug){
        $category = Category::where('slug', $slug)->firstOrFail();
        //$products = $category->getProducts();
       // $products = $category->products();
        return view('catalog.category', compact('category'));

    }

    public function brand($slug) {
        $brand = Brand::where('slug', $slug)->firstOrFail();
        // $products = $brand->getProducts();
        // return view('catalog.brand', compact('brand', 'products'));
       
        return view('catalog.brand',compact('brand'));
    }

    public function product($slug){
        // $product = Product::select(
        //     'products.*',
        //     'categories.name as category_name',
        //     'categories.slug as category_slug',
        //     'brands.name as brand_name',
        //     'brands.slug as brand_slug'
        // )
        //     ->join('categories','products.category_id','=','categories.id')
        //     ->join('brands','products.brand_id','=','brands.id')
        //     ->where('products.slug',$slug)->firstOrFail();
        $product = Product::where('slug',$slug)->firstOrFail();
        $category = $product->getCategory();
        $brand = $product->getBrand();
        return view('catalog.product',compact('product','category','brand'));
    }
}
