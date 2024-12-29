<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\StripeClient;

class AdminController extends Controller
{

    public function commandes() {
        if (Auth::user()) {
            if (Auth::user()->admin) {
                $commandes = Payment::orderBy('updated_at', 'desc')->get();

                // Regrouper les commandes par payment_id
                $groupedCommandes = $commandes->groupBy('payment_id')->map(function ($group) {
                    // Calculer le prix total pour chaque groupe
                    $totalPrice = $group->sum(function ($commande) {
                        return $commande->amount * $commande->quantity / 100;
                    });

                    return [
                        'items' => $group,
                        'totalPrice' => $totalPrice,
                    ];
                });
                return view('admin.commandes', ['title' => 'Admin', 'groupedCommandes' => $groupedCommandes]);
            }
        }
        return redirect(route('home'))->with('error', 'Vous ne pouvez pas accéder à cette page.');
    }

    public function changeStatus(Request $request) {
        $paymentId = $request->payment_id;
        $newStatus = $request->status;

        // Mise à jour de toutes les lignes avec le payment_id spécifié
        Payment::where('payment_id', $paymentId)
            ->update(['payment_status' => $newStatus]);
        $invoice = pathinfo(Payment::where('payment_id', $paymentId)->firstOrFail()->invoice, PATHINFO_FILENAME);
        SendMailController::sendUpdateCommand($invoice, $newStatus);
        return redirect()->back();
    }

    public function products() {
        if (Auth::user()) {
            if (Auth::user()->admin) {

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
                    // Skip archived products
                    if (!$product['active']) {
                        continue;
                    }

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
                            'idBdd' => $localProduct->id,
                            'sales_count' => $localProduct->sales_count
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

                return view('admin.products', ['title' => 'Admin', 'products' => $productsWithPrices, 'prices' => $prices]);
            }
        }
        return redirect(route('home'))->with('error', 'Vous ne pouvez pas accéder à cette page.');
    }

    public function getProductByProductId($id)
    {
        if (Auth::user() && Auth::user()->admin) {
            try {
                // Rechercher le produit localement
                $product = Product::where('product_id', $id)->firstOrFail();
                $stripe = new StripeClient(app(StripeController::class)->stripe_sk);
                $stripeProduct = $stripe->products->retrieve($id);

                return response()->json([
                    'success' => true,
                    'data' => [
                        'product_name' => $product->product_name,
                        'product_description' => $product->product_description,
                        'price' => $product->price / 100, // Conversion en euros
                        'photo' => $product->photo != "" ? $product->photo : $stripeProduct->images[0],
                        'sales_count' => $product->sales_count,
                    ],
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur : ' . $e->getMessage(),
                ], 404);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Vous ne pouvez pas accéder à cette ressource.',
        ], 403);
    }

    public function updateProductByProductId($productId, Request $request)
    {
        if (Auth::user() && Auth::user()->admin) {
            // Rechercher le produit localement
            $product = Product::where('id', $productId)->firstOrFail();

            // Mettre à jour les informations du produit localement
            $newPrice = $request['price'] * 100; // Conversion en centimes
            $product->update([
                'product_name' => $request['product_name'],
                'product_description' => $request['product_description'],
                'price' => $newPrice,
            ]);

            // Initialiser Stripe
            $stripe = new StripeClient(app(StripeController::class)->stripe_sk);

            // Mettre à jour les informations du produit sur Stripe
            $stripe->products->update($product["product_id"], [
                'name' => $request['product_name'],
                'description' => $request['product_description'],
            ]);

            // Vérifier si un tarif actif avec le même montant existe
            $prices = $stripe->prices->all([
                'product' => $product["product_id"],
                'active' => true,
            ]);

            $priceExists = false;
            if (!empty($prices->data)) {
                foreach ($prices->data as $price) {
                    if ($price->unit_amount == $newPrice && $price->currency == 'eur') {
                        $priceExists = true;
                        break;
                    }
                }

                // Archiver les anciens tarifs actifs s'ils ne correspondent pas au nouveau prix
                if (!$priceExists) {
                    foreach ($prices->data as $price) {
                        $stripe->prices->update($price->id, ['active' => false]);
                    }
                }
            }

            // Créer un nouveau tarif uniquement si nécessaire
            if (!$priceExists) {
                $stripe->prices->create([
                    'unit_amount' => $newPrice,
                    'currency' => 'eur', // Devise définie sur euros
                    'product' => $product["product_id"],
                ]);
            }

            return redirect()->back()->with('success', 'Produit et tarif mis à jour avec succès.');
        }

        return redirect(route('home'))->with('error', 'Vous ne pouvez pas accéder à cette page.');
    }

    public function deleteProductBYproductId($productId)
    {
        if (Auth::user() && Auth::user()->admin) {
            // Rechercher le produit localement
            $product = Product::where('id', $productId)->firstOrFail();

            // Initialiser Stripe
            $stripe = new StripeClient(app(StripeController::class)->stripe_sk);

            try {
                // Archiver le produit sur Stripe
                $stripe->products->update($product["product_id"], [
                    'active' => false,
                ]);

                // Supprimer le produit localement
                $product->delete();

                return redirect()->back()->with('success', 'Produit archivé sur Stripe et supprimé localement.');
            } catch (\Exception $e) {
                // Gestion des erreurs
                return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
            }
        }

        return redirect(route('home'))->with('error', 'Vous ne pouvez pas accéder à cette page.');
    }




}
