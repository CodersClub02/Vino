<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contenir;
use App\Models\Bouteille;


class ContenirController extends Controller
{
        /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return response()->json(
            Contenir::where([
                ['cellier_id', '=', $request->id]
            ])->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->cellier_id=1;
        $request->validate([
            'bouteille_id' => 'exists|bouteilles',
            'cellier_id' => 'required|exists|celliers',
            'date_achat' => 'date',
            'garder_jusqu_a' => 'date',
            'notes' => 'string',
            'prix_paye' => 'number',
            'quantite' => 'string',
            'mellisme' => 'integer|min:1900|max:2023'
        ]);

        Contenir::create([
            'nom' => $request->nom,
            'user_id' => auth()->user()->id
        ]);
           
        return response()->json(['status' => 'ok', 'message'=>'cellier créé avec succès']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

}
