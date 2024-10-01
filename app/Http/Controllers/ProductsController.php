<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\StripeClient;

class ProductsController extends Controller
{

    public function shop() {
        $products = Product::all();
        return view('shop', ['products' => $products]);
    }

    public function getProducts()
    {
        $stripe = new StripeClient(app(StripeController::class)->stripe_sk);

        // Fetch all products from Stripe
        $stripeProducts = $stripe->products->all();
        $stripeProducts = $stripeProducts['data'];

        // Fetch all prices from Stripe
        $prices = $stripe->prices->all();
        $prices = $prices['data'];

        $productsWithPrices = [];

        // Fetch local products
        $localProducts = Product::all(); // Assuming you're using an Eloquent model named 'Product'

        // Match Stripe products with local products
        foreach ($stripeProducts as $product) {
            $productPrices = [];
            foreach ($prices as $price) {
                if ($price['product'] == $product['id']) {
                    $productPrices[] = $price;
                }
            }

            // Check if the product exists in the local database
            $localProduct = $localProducts->firstWhere('product_id', $product['id']);

            if ($localProduct) {
                // Match the product with local product details
                $productsWithPrices[$product['id']] = [
                    'product' => $product,
                    'prices' => $productPrices,
                    'local_product' => $localProduct,
                    'idBdd' => $localProduct->id,  // Adding local product ID
                ];
            }
        }

        // Prepare the products and prices for the shop view
        foreach ($productsWithPrices as $productId => $productData) {
            $products[$productId] = $productData['product'];
            $prices[$productId] = $productData['prices'];
            if ($productData['prices'] == []) {
                unset($productsWithPrices[$productId]);
            }
        }

        // Return the shop view with the prepared products, prices, and local products
        return view('shop', ['products' => $productsWithPrices, 'prices' => $prices]);
    }

}
