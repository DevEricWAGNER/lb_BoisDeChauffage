<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        return redirect()->back();
    }
}
