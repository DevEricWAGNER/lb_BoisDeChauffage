<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StripeController extends Controller
{
    public $stripe_pk;
    public $stripe_sk;

    public function __construct()
    {
        $project = DB::connection('mysqlParams')->table('projects')->where('id', 1)->first();
        $this->stripe_pk = $project->stripe_key;
        $this->stripe_sk = $project->stripe_secret;
    }

    public function session(Request $request)
    {
        //$user = auth()->user();
        $productItems = [];

        \Stripe\Stripe::setApiKey($this->stripe_sk);

        foreach (session('cart') as $id => $details) {
            $product_name = $details['product_name'];
            $total = $details['price'];
            $quantity = $details['quantity'];

            $unit_amount = $total; // Multiplie par 100 pour obtenir les centimes

            $productItems[] = [
                'price_data' => [
                    'product_data' => [
                        'name' => $product_name,
                    ],
                    'currency' => 'EUR',
                    'unit_amount' => $unit_amount,
                ],
                'quantity' => $quantity
            ];
        }

        $checkoutSession = \Stripe\Checkout\Session::create([
            'line_items' => $productItems,
            'mode' => 'payment',
            'allow_promotion_codes' => true,
            'metadata' => [
                'user_id' => Auth::user()->id,
            ],
            'customer_email' => Auth::user()->email,
            'success_url' => route('success'),
            'cancel_url' => route('cancel'),
        ]);

        return redirect()->away($checkoutSession->url);
    }

    public function success()
    {
        $cart = session('cart', []);
        foreach ($cart as $id => $details) {
            unset($cart[$id]);
            session(['cart' => $cart]);
        }
        return "Thanks for your order. You have just completed your payment. The seller will reach out to you as soon as possible.";
    }

    public function cancel()
    {
        return view('cancel');
    }
}
