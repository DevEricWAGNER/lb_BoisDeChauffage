<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function commandes() {
        $commandes = Payment::get();

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
        return view('admin.commandes', compact('groupedCommandes'));
    }

    public function changeStatus(Request $request) {
        $paymentId = $request->payment_id;
        $newStatus = $request->status;

        // Mise à jour de toutes les lignes avec le payment_id spécifié
        Payment::where('payment_id', $paymentId)
            ->update(['payment_status' => $newStatus]);

        return redirect()->back();
    }
}
