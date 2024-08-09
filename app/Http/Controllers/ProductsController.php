<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $userId = auth()->id();
        $cart = session('cart');

        // Si le panier n'existe pas dans la session
        if (!$cart) {
            // Cherche le panier dans la base de données
            $dbCart = Cart::with('products')->where('user_id', $userId)->first();

            if ($dbCart) {
                // Construit le panier à partir de la base de données
                $cart = [];
                foreach ($dbCart->products as $product) {
                    $cart[$product->pivot->product_id] = [
                        'product_name' => $product->product_name,
                        'product_description' => $product->product_description,
                        'photo' => $product->photo,
                        'price' => $product->price,
                        'quantity' => $product->pivot->quantity
                    ];
                }
                // Met le panier dans la session
                session(['cart' => $cart]);
            }
        }

        $total = 0;
        $products = [];

        // Vérifie les produits dans le panier
        foreach ($cart as $id => $details) {
            $product = Product::find($id);
            if ($product) {
                $products[$id] = $product;
                $total += $details['price'] * $details['quantity'];
            } else {
                // Nettoie les produits invalides du panier
                unset($cart[$id]);
                session(['cart' => $cart]);
            }
        }

        return view('cart', compact('cart', 'total', 'products'));
    }

    public function addToCart(Request $request)
    {
        // Validate request
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if (Auth::check()) {
            $product = Product::findOrFail($request->product_id);

            $cart = session()->get('cart', []);

            if (isset($cart[$request->product_id])) {
                // Increment the quantity
                $cart[$request->product_id]['quantity'] += $request->quantity;
            } else {
                // Add new product to the cart
                $cart[$request->product_id] = [
                    "product_name" => $product->product_name,
                    "product_description" => $product->product_description,
                    "photo" => $product->photo,
                    "price" => $product->price,
                    "quantity" => $request->quantity
                ];
            }

            session()->put('cart', $cart);

            // Save cart to the database
            $this->saveCartToDatabase($request->product_id, $request->quantity);

            return redirect()->back()->with('success', 'Product added to cart successfully!');
        } else {
            return redirect()->route('login');
        }
    }

    /**
     * Save cart details to the database.
     */
    private function saveCartToDatabase($productId, $quantity)
    {
        if (!$productId) {
            throw new \InvalidArgumentException('Product ID cannot be null.');
        }

        $userId = Auth::id();
        $cart = Cart::firstOrCreate(['user_id' => $userId]);

        // Update or create a cart product entry
        CartProduct::updateOrCreate(
            ['cart_id' => $cart->id, 'product_id' => $productId],
            ['quantity' => DB::raw('quantity + ' . intval($quantity))]
        );
    }

    public function update(Request $request)
    {
        // Validate request
        $request->validate([
            'id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($request->id && $request->quantity) {
            $cart = session()->get('cart', []);
            if (isset($cart[$request->id])) {
                // Update the quantity in the session
                $cart[$request->id]['quantity'] = $request->quantity;
                session()->put('cart', $cart);

                // Update the cart in the database
                $this->saveCartToDatabase($request->id, $request->quantity);

                return redirect()->route("cart")->with('success', 'Cart updated successfully!');
            } else {
                return redirect()->route('cart')->with('error', 'Item not found in the cart.');
            }
        }
    }

    public function remove(Request $request)
    {
        // Validate request
        $request->validate([
            'id' => 'required|integer|exists:products,id',
        ]);

        if ($request->id) {
            $cart = session()->get('cart', []);
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);

                // Remove the cart item from the database
                $this->removeCartItemFromDatabase($request->id);

                return redirect()->route("cart")->with('success', 'Item removed from the cart.');
            } else {
                return redirect()->route('cart')->with('error', 'Item not found in the cart.');
            }
        }
    }

    private function removeCartItemFromDatabase($productId)
    {
        $userId = Auth::id();
        $cart = Cart::where('user_id', $userId)->first();

        if ($cart) {
            CartProduct::where('cart_id', $cart->id)
                        ->where('product_id', $productId)
                        ->delete();
        }
    }
}
