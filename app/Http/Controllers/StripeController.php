<?php

namespace App\Http\Controllers;

use App\Models\Adress;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\StripeClient;

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
        $stripe = new StripeClient($this->stripe_sk);

        $adress = Adress::find($request->adress_id);

        // 1. Créer un client Stripe avec l'adresse de livraison
        $customer = $stripe->customers->create([
            'email' => Auth::user()->email,
            'name' => Auth::user()->firstname.' '.Auth::user()->lastname,
            'phone' => Auth::user()->phone,
            'address' => [
                'line1' => $adress->line1,
                'line2' => $adress->line2,
                'city' => $adress->city,
                'postal_code' => $adress->postal_code,
                'country' => $adress->country,
            ],
            'shipping' => [
                'name' => Auth::user()->firstname.' '.Auth::user()->lastname,
                'address' => [
                    'line1' => $adress->line1,
                    'line2' => $adress->line2,
                    'city' =>  $adress->city,
                    'postal_code' => $adress->postal_code,
                    'country' => $adress->country,
                ],
            ],
        ]);

        // 2. Calculer le coût de la livraison (exemple)
        $startingPoint = '123 Main St, Paris, FR';
        $destinationPoint = $adress->line1 . ", " . $adress->city . ", " . $adress->country;
        $distanceInKm = $this->calculateDistance($startingPoint, $destinationPoint);
        $deliveryCost = $distanceInKm * 0.50 * 100; // Convertir en centimes

        // 3. Créer les items de produit pour Stripe
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
                'quantity' => $quantity,
            ];
        }

        // 4. Créer la session Stripe
        $response = $stripe->checkout->sessions->create([
            'customer' => $customer->id, // Associer le client créé à la session
            'line_items' => $productItems,
            'mode' => 'payment',
            'success_url' => route('success').'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('cancel'),
            'shipping_address_collection' => [
                'allowed_countries' => ['FR'], // Limité à la France dans cet exemple
            ],
            'shipping_options' => [
                [
                    'shipping_rate_data' => [
                        'type' => 'fixed_amount',
                        'fixed_amount' => [
                            'amount' => $deliveryCost, // Utiliser le coût de livraison calculé
                            'currency' => 'EUR',
                        ],
                        'display_name' => 'Livraison calculée en fonction de la distance',
                    ],
                ],
            ],
        ]);

        // 5. Rediriger l'utilisateur vers la page de paiement Stripe
        if(isset($response->id) && $response->id != ''){
            return redirect($response->url);
        } else {
            return redirect()->route('cancel');
        }
    }

    private function calculateDistance($startingPoint, $destinationPoint)
    {

        $distanceInKm = 100;

        return $distanceInKm;
    }

    public function success(Request $request)
    {
        if(isset($request->session_id)) {

            $stripe = new StripeClient($this->stripe_sk);
            $response = $stripe->checkout->sessions->retrieve($request->session_id);
            //dd($response);
            $adress = Adress::where('line1', $response->shipping_details->address->line1)->where('city', $response->shipping_details->address->city)->where('postal_code', $response->shipping_details->address->postal_code)->first()->get();
            $adress_id = $adress[0]->id;
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
                $payment->adress_id = $adress_id;
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
