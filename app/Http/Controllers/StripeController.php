<?php

namespace App\Http\Controllers;

use App\Models\Adress;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Distance;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use Google\Service\BigtableAdmin\Split;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Stripe\StripeClient;

class StripeController extends Controller
{
    public $stripe_pk;
    public $stripe_sk;

    public function __construct()
    {
        $this->stripe_pk = env('STRIPE_PUBLIC_KEY');
        $this->stripe_sk = env('STRIPE_PRIVATE_KEY');
    }

    public function createProducts(Request $request)
    {
        if (Auth::user() && Auth::user()->admin) {
            $stripe = new StripeClient(app(StripeController::class)->stripe_sk);

            try {
                $price = "";
                $priceInCents = 0;
                if (isset($request["price"])) {
                    $price = $request["price"];

                    // Remplacer la virgule par un point si elle est présente
                    $price = str_replace(',', '.', $price);

                    // Vérifier si c'est un nombre valide
                    if (is_numeric($price)) {
                        // Multiplier par 100 et convertir en entier pour obtenir le montant en centimes
                        $priceInCents = (int) round($price * 100);
                    } else {
                        throw new Exception("Le prix fourni n'est pas un nombre valide.", 1);
                    }
                } else {
                    throw new Exception("Aucun prix fourni", 1);
                }
                if ($priceInCents != 0) {
                    // Stocker l'image
                    $imagePath = $request->hasFile('image')
                        ? $request->file('image')->store('products', 'public')
                        : null;

                    // Créer le produit sur Stripe
                    $stripeProduct = $stripe->products->create([
                        'name' => $request['name'],
                        'description' => $request['description'] ?? null,
                        'images' => $imagePath ? [asset('storage/' . $imagePath)] : null,
                    ]);

                    // Créer un prix sur Stripe
                    $stripePrice = $stripe->prices->create([
                        'unit_amount' => $priceInCents,
                        'currency' => 'eur',
                        'product' => $stripeProduct->id,
                    ]);
                    dd($request['name'], $request['description'], $priceInCents, $stripeProduct->id, $imagePath ? asset('storage/' . $imagePath) : null);

                    // Stocker le produit localement
                    $product = Product::create([
                        'product_name' => $request['name'],
                        'product_description' => $request['description'],
                        'price' => $priceInCents,
                        'product_id' => $stripeProduct->id,
                        'photo' => $imagePath ? asset('storage/' . $imagePath) : null,
                        'sales_count' => 0,
                    ]);
                } else {
                    throw new Exception("Le prix ne peux pas être inferieur ou égal à 0", 1);
                }

                return redirect()->back()->with('success', 'Produit créé avec succès.');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Erreur : ' . $e->getMessage());
            }
        }

        return redirect(route('home'))->with('error', 'Vous ne pouvez pas accéder à cette page.');
    }

    public function session(Request $request)
    {
        $stripe = new \Stripe\StripeClient($this->stripe_sk);

        $adress = Adress::find($request->adress_id);

        $customers = $stripe->customers->all();
        $customerFound = false;
        $customerId = '';
        foreach ($customers->data as $customer) {
            if($customer->email == Auth::user()->email) {
                $customerFound = true;
                $customerId = $customer->id;
                break;
            }
        }

        if (!$customerFound) {
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
        } else {
            $customer = $stripe->customers->retrieve($customerId);
            // if customer shipping adress is = to the one in the request, we don't need to update it else we update it
            if ($customer->shipping->address->line1!= $adress->line1 ||
                $customer->shipping->address->line2!= $adress->line2 ||
                $customer->shipping->address->city!= $adress->city ||
                $customer->shipping->address->postal_code!= $adress->postal_code ||
                $customer->shipping->address->country!= $adress->country) {
                $customer = $stripe->customers->update($customerId, [
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
            }
        }

        // 2. Calculer le coût de la livraison (exemple)
        $startingPoint = '12 rue de la charrue 67300 Schiltigheim';
        $destinationPoint = $adress->line1 . ", " . $adress->city . ", " . $adress->country;
        $distanceInKm = $this->calculateDistance($startingPoint, $destinationPoint);
        $deliveryCost = $distanceInKm * 0.50 * 100; // Convertir en centimes


        // 3. Créer les items de produit pour Stripe
        $productItems = [];
        $panier = CartProduct::where('cart_id', Auth::user()->carts[0]->id)->get();
        foreach ($panier as $product) {
            $productDetails = Product::where('id', $product->product_id)->first();
            $product_name = $productDetails->product_name;
            $unit_amount = $productDetails->price;
            $quantity = $product->quantity;
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
    private function getCoordinates($address)
    {
        $apiKey = 'U1nVuAAdWyALz14Xi9p0St8yCYTQPApj'; // Replace with your actual TomTom API key
        $encodedAddress = urlencode($address);
        $url = "https://api.tomtom.com/search/2/geocode/$encodedAddress.json?key=$apiKey";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);

        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);

        if (!empty($data['results']) && isset($data['results'][0]['position'])) {
            $latitude = $data['results'][0]['position']['lat'];
            $longitude = $data['results'][0]['position']['lon'];
            return "$latitude,$longitude";
        }

        return null; // Return null if coordinates could not be found
    }


    private function calculateDistance($startingPoint, $destinationPoint)
    {
        $apiKey = 'U1nVuAAdWyALz14Xi9p0St8yCYTQPApj'; // Replace with your actual TomTom API key

        // Convert addresses to coordinates
        $startingCoordinates = $this->getCoordinates($startingPoint);
        $destinationCoordinates = $this->getCoordinates($destinationPoint);

        // If either of the coordinates is not found, return null
        if (!$startingCoordinates || !$destinationCoordinates) {
            return null;
        }

        // Build the URL for the TomTom Routing API
        $url = sprintf(
            'https://api.tomtom.com/routing/1/calculateRoute/%s:%s/json?routeType=shortest&key=%s',
            $startingCoordinates,
            $destinationCoordinates,
            $apiKey
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);

        $response = curl_exec($ch);
        curl_close($ch);

        $responseData = json_decode($response, true);

        if (isset($responseData['routes'][0]['summary']['lengthInMeters'])) {
            $distanceInMeters = $responseData['routes'][0]['summary']['lengthInMeters'];
            $distanceInKm = $distanceInMeters / 1000;

            $mappings = Distance::orderBy('threshold')->get(); // Get the distance mappings

            // Default value for distances greater than or equal to 1000 km
            $mappedDistance = $mappings->last()->mapped_value; // Get the last mapping as default

            // Find the appropriate mapped value based on distance
            foreach ($mappings as $mapping) {
                if ($distanceInKm < $mapping->threshold) {
                    $mappedDistance = $mapping->mapped_value; // Set mapped value based on the mapping
                    break; // Exit loop once the range is found
                }
            }

            return $mappedDistance;
        }

        return null; // Return null if the distance could not be calculated
    }


    public function success(Request $request)
    {
        if(isset($request->session_id)) {

            $stripe = new StripeClient($this->stripe_sk);
            $response = $stripe->checkout->sessions->retrieve($request->session_id);
            $customerId = $response->customer;
            $shippingCost = $response->total_details->amount_shipping ?? 0;
            $adress = Adress::where('line1', $response->shipping_details->address->line1)->where('city', $response->shipping_details->address->city)->where('postal_code', $response->shipping_details->address->postal_code)->first();
            $adress_id = $adress->id;

            $panier = CartProduct::where('cart_id', Auth::user()->carts[0]->id)->get();
            if (!$panier->isEmpty()) {
                $products = [];
                $nb_articles = 0;

                foreach ($panier as $product) {
                    $quantity = $product->quantity;
                    $products[] = $product->product_id . "," . $quantity;
                }

                $invoice = $this->createInvoiceFromSession($customerId, $request->session_id, $products, $shippingCost);

                $tva_bool = false;
                if ($invoice->tax != null) {
                    $tva_bool = true;
                }
                $address = $invoice->customer_shipping->address;
                $shipping_adress1 = $address->postal_code . " " . $address->city;
                $shipping_adress2 = $address->line1 . " " . $address->line2;
                $shipping_adress3 = $address->country;

                $pdf = Controller::downloadInvoice($invoice->invoice_pdf, $invoice->number);

                foreach ($panier as $product) {
                    $productDetails = Product::where('id', $product->product_id)->first();
                    $product_name = $productDetails->product_name;
                    $unit_amount = $productDetails->price;
                    $quantity = $product->quantity;
                    $nb_articles += $quantity;

                    $payment = new Payment();
                    $payment->payment_id = $response->id;
                    $payment->product_name = $product_name;
                    $payment->quantity = $quantity;
                    $payment->amount = $unit_amount;
                    $payment->currency = $response->currency;
                    $payment->customer_name = $response->customer_details->name;
                    $payment->customer_email = $response->customer_details->email;
                    $payment->payment_status = $response->status;
                    $payment->payment_method = "Stripe";
                    $payment->adress_id = $adress_id;
                    $payment->invoice = $pdf;
                    $payment->user_id = Auth::id();
                    $payment->save();
                    $products[] = $product->product_id . "," . $quantity;

                    $productInfos = Product::find($product->product_id);
                    $productInfos->sales_count = $productInfos->sales_count + $quantity;
                    $productInfos->save();
                }

                $this->clearCart();

                SendMailController::sendInvoice(
                    $pdf,
                    $invoice->hosted_invoice_url,
                    $invoice->number,
                    $nb_articles,
                    ($invoice->total - $response->shipping_cost->amount_total),
                    $response->shipping_cost->amount_total,
                    $tva_bool,
                    $invoice->tax,
                    $invoice->total,
                    $shipping_adress1,
                    $shipping_adress2,
                    $shipping_adress3
                );
            }
            return view('success');

        } else {
            return redirect()->route('cancel');
        }
    }

    private function createInvoiceFromSession($customerId, $sessionId, $products, $shippingCost)
    {
        $stripe = new \Stripe\StripeClient($this->stripe_sk);


        $customer = $stripe->customers->retrieve($customerId);

        $invoice = $stripe->invoices->create([
            'customer' => $customer->id,
            'auto_advance' => true,
        ]);

        $lineItems = $stripe->checkout->sessions->allLineItems($sessionId)->data;
        foreach ($products as $product_infos) {
            $product = explode(",",$product_infos)[0];
            $quantity = explode(",",$product_infos)[1];
            $productId = Product::where('id', $product)->first()->product_id;
            $product = $stripe->products->retrieve($productId);

            $prices = $stripe->prices->all();
            $prices = $prices['data'];

            $priceId = null;

            foreach ($prices as $price) {
                if ($price['product'] == $productId && $price['active']) {
                    $priceId = $price["id"];
                }
            }



            $invoiceItem = $stripe->invoiceItems->create([
                'invoice' => $invoice->id,
                'customer' => $customer->id,
                'quantity' => $quantity,
                'price' => $priceId,
                'currency' => 'eur',
            ]);

        }

        if ($shippingCost > 0) {
            $stripe->invoiceItems->create([
                'invoice' => $invoice->id,
                'customer' => $customer->id,
                'amount' => $shippingCost, // montant en centimes, ex: 500 pour 5.00 EUR
                'currency' => 'eur',
                'description' => 'Frais de livraison',
            ]);
        }

        // Finaliser et payer la facture automatiquement
        $invoice->finalizeInvoice();

        // invoice set as paid
        $invoice->pay();

        return $invoice;
    }

    private function clearCart()
    {
        CartProduct::where('cart_id', Auth::user()->carts[0]->id)->delete();
    }

    public function cancel()
    {
        return view('cancel');
    }
}
