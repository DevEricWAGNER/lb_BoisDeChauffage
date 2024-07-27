<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{

    public function shop() {
        $products = Product::all();
        return view('shop', ['products' => $products]);
    }

    public function show(Request $request) {
        $product = Product::findOrFail($request->product_id);
        return view('show', ['product' => $product]);
    }

    public function cart()
    {
        $cart = session('cart', []);
        $total = 0;
        $products = [];

        foreach ($cart as $id => $details) {
            $product = Product::find($id);
            if ($product) {
                $products[$id] = $product;
                $total += $details['price'] * $details['quantity'];
            } else {
                unset($cart[$id]);
                session(['cart' => $cart]);
            }
        }

        return view('cart', compact('cart', 'total', 'products'));
    }


    public function addToCart(Request $request)
    {

        $product = Product::findOrFail($request->product_id);

        $cart = session()->get('cart', []);

        if(isset($cart[$request->product_id])) {
            $cart[$request->product_id]['quantity'] + $request->quantity;
        }  else {
            $cart[$request->product_id] = [
                "product_name" => $product->product_name,
                "product_description" => $product->product_description,
                "photo" => $product->photo,
                "price" => $product->price,
                "quantity" => $request->quantity
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product add to cart successfully!');
    }

    public function update(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            return redirect()->route("cart");
        }
    }

    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
                return redirect()->route("cart");
            }

        }
    }
}
