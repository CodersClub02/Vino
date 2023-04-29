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
        $request->validate([
            'bouteille_id' => 'exists:bouteilles,id',
            'cellier_id' => 'required|exists:celliers,id',
            'date_achat' => 'date',
            'garder_jusqu_a' => 'date',
            'notes' => 'integer',
            'commentaire' => 'commentaire',
            'prix_paye' => 'numeric',
            'quantite' => 'integer',
            'mellisme' => 'integer|min:1900|max:2023'
        ]);

        Contenir::create([
            'user_id' => auth()->user()->id,
            'bouteille_id' => $request->bouteille_id,
            'cellier_id' => $request->cellier_id,
            'date_achat' => $request->date_achat,
            'garder_jusqu_a' => $request->garder_jusqu_a,
            'notes' => $request->notes,
            'commentaire' => $request->commentaire,
            'prix_paye' => $request->prix_paye,
            'quantite' => $request->quantite,
            'mellisme' => $request->mellisme
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
