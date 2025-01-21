<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SendMailController;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register', ['title' => 'Inscription']);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Vérifier si un utilisateur avec cette adresse email existe et est désactivé
        $existingUser = User::where('email', $request->email)->where('is_active', false)->first();

        if ($existingUser) {
            // Générer un code de confirmation
            $confirmationCode = rand(100000, 999999);
            $existingUser->confirmation_code = $confirmationCode;
            $existingUser->save();

            // Envoyer l'email avec le code de confirmation

            SendMailController::reactivateAccount($existingUser->email, $confirmationCode);

            return redirect()->back()->with('status', 'Votre compte est désactivé. Un code de confirmation a été envoyé à votre email.');
        }

        // Créer un nouvel utilisateur si aucune correspondance
        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('home', absolute: false));
    }


}
