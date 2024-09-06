<?php

namespace App\Http\Controllers;

use App\Models\Adress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Validation des données
        $validatedData = $request->validate([
            'country' => 'required|string',
            'line1' => 'required|string',
            'line2' => 'nullable|string',
            'postal_code' => 'required|string',
            'city' => 'required|string',
        ]);

        // Création de l'adresse
        $adress = new Adress();
        $adress->user_id = Auth::id(); // Associer l'adresse à l'utilisateur connecté
        $adress->country = $validatedData['country'];
        $adress->line1 = $validatedData['line1'];
        $adress->line2 = $validatedData['line2'];
        $adress->postal_code = $validatedData['postal_code'];
        $adress->city = $validatedData['city'];
        $adress->save();

        return redirect()->back();
    }


    /**
     * Display the specified resource.
     */
    public function show(Adress $adress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Adress $adress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Adress $adress)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Adress $adress)
    {
        //
    }
}
