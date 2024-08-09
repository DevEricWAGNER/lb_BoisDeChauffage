<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Order;
use App\Models\Payment;
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
        $stripe = new \Stripe\StripeClient($this->stripe_sk);
        $productItems = [];
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
        $response = $stripe->checkout->sessions->create([
            'line_items' => $productItems,
            'mode' => 'payment',
            'success_url' => route('success').'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('cancel'),
        ]);
        if(isset($response->id) && $response->id != ''){
            return redirect($response->url);
        } else {
            return redirect()->route('cancel');
        }
    }

    public function success(Request $request)
    {
        if(isset($request->session_id)) {

            $stripe = new \Stripe\StripeClient($this->stripe_sk);
            $response = $stripe->checkout->sessions->retrieve($request->session_id);
            //dd($response);
            foreach (session('cart') as $id => $details) {
                $product_name = $details['product_name'];
                $total = $details['price'];
                $quantity = $details['quantity'];

                $payment = new Payment();
                $payment->payment_id = $response->id;
                $payment->product_name = $product_name;
                $payment->quantity = $quantity;
                $payment->amount = $total;
                $payment->currency = $response->currency;
                $payment->customer_name = $response->customer_details->name;
                $payment->customer_email = $response->customer_details->email;
                $payment->payment_status = $response->status;
                $payment->payment_method = "Stripe";
                $payment->user_id = Auth::id();
                $payment->save();
            }

            $this->clearCart();
            return view('success');

        } else {
            return redirect()->route('cancel');
        }
    }

    private function clearCart()
    {
        // Supprimer les articles du panier de la base de données
        $userId = Auth::id();
        if ($userId) {
            // Supprimer les articles du panier de l'utilisateur actuel
            $cart = Cart::where('user_id', $userId)->first();

            if ($cart) {
                CartProduct::where('cart_id', $cart->id)
                            ->delete();
            }
            $cart->delete();
        }

        // Effacer également le panier de la session
        session()->forget('cart');
    }

    public function cancel()
    {
        return view('cancel');
    }
}
