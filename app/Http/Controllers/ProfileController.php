<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Adress;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'title' => 'Profile',
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->is_active = false;
        $user->save();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function commandes()
    {
        $user = Auth::user();
        $commandes = $user->payments;

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

        return view('commandes', ['title' => 'Commandes', 'groupedCommandes' => $groupedCommandes]);
    }

    public function showDetailsCommande($id)
    {
        // Récupérer les détails de la commande en utilisant l'ID du paiement
        $commandeLines = Payment::where('payment_id', $id)->get();

        // Vérifiez si la commande existe
        if (!$commandeLines) {
            return response()->json(['error' => 'Commande non trouvée'], 404);
        }

        $progress = "0%";
        if ($commandeLines[0]->payment_status == 'complete') {
            $progress = "40%";
        } else if ($commandeLines[0]->payment_status == 'expedie') {
            $progress = "65%";
        } else if ($commandeLines[0]->payment_status == 'livraison') {
            $progress = "90%";
        } else if ($commandeLines[0]->payment_status == 'livre') {
            $progress = "100%";
        }

        // Convertir la progression en pourcentage pour comparer avec les positions des cercles
        $progressPercent = (int) rtrim($progress, '%');

        // Points marqués avec légendes
        $points = [
            ['position' => '25%', 'check' => $progressPercent >= 25, 'label' => 'Commandé'],
            ['position' => '50%', 'check' => $progressPercent >= 50, 'label' => 'Expédié'],
            ['position' => '75%', 'check' => $progressPercent >= 75, 'label' => 'En cours de livraison'],
            ['position' => '100%', 'check' => $progressPercent >= 100, 'label' => 'Livré'],
        ];

        $address = Adress::where('id', $commandeLines[0]->adress_id)->first()->get();
        $address = $address[0];
        $adress = $address->line1 . ", " . $address->postal_code . " " . $address->city;

        // Formater la barre de progression avec des points marqués et des légendes
        $html = "<div class='px-4 py-5'>
            <div class='py-2'>Adresse de livraison : " . $adress . "</div>
            <div class='relative w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700'>
                <!-- Barre de progression -->
                <div class='absolute top-0 left-0 h-2.5 rounded-full bg-blue-600' style='width: {$progress}'></div>
        ";

        foreach ($points as $point) {
            $checkmark = $point['check'] ? "relative flex items-center justify-center w-6 h-6 bg-blue-600 rounded-full" : "relative flex items-center justify-center w-6 h-6 bg-gray-200 rounded-full";

            $html .= "
                <div class='absolute' style='left: {$point['position']}; transform: translateX(-50%) translateY(-15%);'>
                    <div class='" . $checkmark . "'>
                        <svg xmlns='http://www.w3.org/2000/svg' class='absolute w-4 h-4 text-white transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><path d='M5 12l5 5L19 7' /></svg>
                    </div>
                    <span class='block mt-1 text-sm text-center text-gray-600' style='transform: translateX(-25%);'>{$point['label']}</span>
                </div>
            ";
        }

        $html .= "</div></div>";

        $total = 0;

        foreach ($commandeLines as $line) {
            // Vérifiez que $line->amount est un nombre
            $price = ($line->quantity * $line->amount) / 100;
            $total = $total + $price;

            // Concaténer correctement les chaînes
            $html .= '
                <article class="flex flex-col items-end justify-between w-full gap-2 px-4 py-6 border-b border-gray-700 lg:flex-row">
                    <h2 class="text-xl font-bold">' . htmlspecialchars($line->product_name) . '</h2>
                    <p>Quantité: ' . htmlspecialchars($line->quantity) . '</p>
                    <div class="flex items-center gap-10">
                        <h3 class="flex flex-col text-sm font-bold">Prix : <span>' . number_format($line->amount / 100, 2) . ' €</span></h3>
                        <h3 class="flex flex-col text-sm font-bold">Prix total : <span>' . number_format($price, 2) . ' €</span></h3>
                    </div>
                </article>
            ';
        }
        $html .= "
                <div class='flex flex-col items-end gap-5'>
                    <div class='space-y-2 text-right'>
                        <h4 class='text-2xl'>Sous total: <span class='font-bold'>" . number_format($total , 2 ) . " €</span></h4>
                    </div>
                </div>";
        $html .= "</div>";

        // Retourner les données au format JSON
        return response()->json(['html' => $html]);
    }

    public function adresses() {
        $adresses = Auth::user()->adresses;
        $shippingAdresses = $adresses->filter(function ($adresse) {
            return $adresse->address_type === 'shipping';
        });
        $html = "";

        if ($shippingAdresses->isNotEmpty()) {
            $html .= "<div class='relative overflow-x-auto shadow-md sm:rounded-lg'><table class='w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400' id='tableAdresses'><thead class='text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400'><tr><th scope=\"col\" class=\"p-4\"></th><th scope=\"col\" class=\"px-6 py-3\">Adresse ligne 1</th><th scope=\"col\" class=\"px-6 py-3\">Adresse ligne 2</th><th scope=\"col\" class=\"px-6 py-3\">Code Postal</th><th scope=\"col\" class=\"px-6 py-3\">Ville</th><th scope=\"col\" class=\"px-6 py-3\">Pays</th></tr></thead><tbody>";
            foreach ($shippingAdresses as $adresse) {
                $html .= "<tr class=\"bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600\">";
                $html .= "<td class=\"w-4 p-4\"><div class=\"flex items-center\"><input id=\"selectForShipping_" . $adresse->id . "\" type=\"radio\" name='selectForShipping' class=\"w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600\" value='" . $adresse->id . "'><label for=\"checkbox-table-search-1\" class=\"sr-only\">checkbox</label></div></td>";
                $html .= "<th scope=\"row\" class=\"px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white\"><label for='selectForShipping_" . $adresse->id . "'>" . htmlspecialchars($adresse->line1) . "</label></th>";
                $html .= "<td class=\"px-6 py-4\"><label for='selectForShipping_" . $adresse->id . "'>" . htmlspecialchars($adresse->line2) . "</label></td>";
                $html .= "<td class=\"px-6 py-4\"><label for='selectForShipping_" . $adresse->id . "'>" . htmlspecialchars($adresse->postal_code) . "</label></td>";
                $html .= "<td class=\"px-6 py-4\"><label for='selectForShipping_" . $adresse->id . "'>" . htmlspecialchars($adresse->city) . "</label></td>";
                $html .= "<td class=\"px-6 py-4\"><label for='selectForShipping_" . $adresse->id . "'>" . htmlspecialchars($adresse->country) . "</label></td>";
                $html .= "</tr>";
            }
            $html .= "</tbody></table></div><br><button class='px-5 py-2.5 text-sm font-medium text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 btnNewAdress'>Ajouter une nouvelle adresse</button>";
        }

        return response()->json(['html' => $html]);
    }

    public function confirmReactivation()
    {

        $email = $_GET["email"];
        $code = $_GET["code"];

        $user = User::where('email', $email)
                    ->where('confirmation_code', $code)
                    ->where('is_active', false)
                    ->first();

        if ($user) {
            // Réactiver l'utilisateur
            $user->is_active = true;
            $user->confirmation_code = null; // Supprimer le code de confirmation
            $user->save();

            // Connecter l'utilisateur
            Auth::login($user);

            return redirect()->route('home')->with('status', 'Votre compte a été réactivé avec succès.');
        }

        return redirect()->back()->withErrors(['confirmation_code' => 'Code de confirmation invalide ou utilisateur introuvable.']);
    }



}
