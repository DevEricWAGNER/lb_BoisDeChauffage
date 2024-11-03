<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Retrieves and prepares the user's shopping cart.
     *
     * This function retrieves the user's shopping cart from the session. If the cart does not exist in the session,
     * it fetches the cart from the database and constructs it. The function then calculates the total cost of the cart
     * and fetches the details of each product in the cart.
     *
     * @return \Illuminate\Contracts\View\View
     * @return array $cart An associative array representing the user's shopping cart.
     * @return float $total The total cost of the cart.
     * @return array $products An associative array containing the details of each product in the cart.
     */
    public function cart()
    {
        $userId = auth()->id();
        // get carts from user and if it is any create one and use it
        $cart = Cart::where('user_id', $userId)->first();
        if (!$cart) {
            $cart = Cart::create(['user_id' => $userId]);
        }

        $cart = CartProduct::where('cart_id', Auth::user()->carts[0]->id)->get();
        $total = 0;
        $products = [];
        if ($cart) {
            foreach ($cart as $product) {
                $productDetails = Product::where('id', $product->product_id)->first();

                $products[$product->product_id] = [
                    "product_id" => $productDetails->id,
                    "product_name" => $productDetails->product_name,
                    "product_description" => $productDetails->product_description,
                    "photo" => $productDetails->photo,
                    "price" => $productDetails->price,
                    "quantity" => $product->quantity,
                ];
                $total += $productDetails->price * $product->quantity;
            }
        }

        return view('cart', compact('total', 'products'));
    }

    /**
     * Adds a product to the user's shopping cart.
     *
     * This function validates the incoming request, checks if the user is authenticated,
     * fetches the product from the database, and updates the user's shopping cart in the session.
     * It also saves the updated cart to the database.
     *
     * @param Request $request The incoming request containing the product ID and quantity.
     * @return \Illuminate\Http\RedirectResponse Redirects to the shop page with a success message if the product is added successfully.
     * @return \Illuminate\Http\RedirectResponse Redirects to the login page if the user is not authenticated.
     */
    public function addToCart(Request $request)
    {
        // Validate request
        $request->validate([
            'product_id' => 'required|string',
            'quantity' => 'required|integer|min:1'
        ]);
        $product = Product::where('product_id', $request->product_id)->first();

        if (Auth::check()) {
            $carts = Auth::user()->carts;
            if ($carts->isEmpty()) {
                $cart = Cart::create([
                    'user_id' => Auth::id()
                ]);

                $cartProduct = new CartProduct();
                $cartProduct->cart_id = $cart->id;
                $cartProduct->product_id = $product->id;
                $cartProduct->quantity = $request->quantity;
                $cartProduct->save();
            } else {
                $cart = $carts[0];
                $cartProduct = CartProduct::where('cart_id', $cart->id)
                    ->where('product_id', $product->id)
                    ->first();

                if ($cartProduct) {
                    $cartProduct->quantity += $request->quantity;
                    $cartProduct->save();
                } else {
                    $cartProduct = new CartProduct();
                    $cartProduct->cart_id = $cart->id;
                    $cartProduct->product_id = $product->id;
                    $cartProduct->quantity = $request->quantity;
                    $cartProduct->save();
                }
            }

            return redirect()->back()->with('success', 'Product added to cart successfully!');
        } else {
            return redirect()->route('login');
        }
    }

    public function update(Request $request)
    {
        // Validate request
        $request->validate([
            'id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($request->id && $request->quantity) {
            $cart = CartProduct::where('cart_id', Auth::user()->carts[0]->id)
                ->where('product_id', $request->id)
                ->first();

            if ($cart) {
                $cart->quantity = $request->quantity;
                $cart->save();
            } else {
                return redirect()->route('cart')->with('error', 'Item not found in the cart.');
            }

            return redirect()->route("cart")->with('success', 'Cart updated successfully!');
        }
    }

    public function remove(Request $request)
    {
        if ($request->id) {
            $cart = CartProduct::where('cart_id', Auth::user()->carts[0]->id)
            ->where('product_id', $request->id)
            ->delete();

            return redirect()->route("cart")->with('success', 'Item removed from the cart.');
        }
    }
}