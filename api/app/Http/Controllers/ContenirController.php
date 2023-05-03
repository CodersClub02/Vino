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
        if($request->has('recherche')){

            $predicate = [];
            if($request->cellier_id) array_push($predicate, ['cellier_id', '=', $request->cellier_id]);
            if($request->mot_cle) array_push($predicate, ['nom', 'like', '%' . $request->mot_cle . '%']);
            
            return response()->json(
                Bouteille::where($predicate)
                ->join('contenirs', 'bouteilles.id', '=', 'contenirs.bouteille_id')
                ->with('pays:nom,id', 'type:nom,id')
                ->get()
            );

        }else{

            return response()->json(
                Contenir::where([
                    ['cellier_id', '=', $request->id]
                    ])
                    ->get()
                );

        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'bouteille_id' => 'nullable|exists:bouteilles,id',
            'cellier_id' => 'required|exists:celliers,id',
            'date_achat' => 'date',
            'garder_jusqu_a' => 'date',
            'prix_paye' => 'numeric|min:0',
            'quantite' => 'integer|min:0',
            'mellisme' => 'integer|min:1900|max:2023',
            'nom' => 'required_if:source,autre|string',
            'format' => 'required_if:source,autre|string',
            'type_id' => 'required_if:source,autre|exists:types,id',
            'pays_id' => 'required_if:source,autre|exists:pays,id',
        ]);

        if($request->source == 'autre'){
            $nouvelleBouteille = Bouteille::firstOrCreate([
                'nom' => $request->nom,
                'type_id' => $request->type_id,
                'pays_id' => $request->pays_id,
                'format' => $request->format,
            ]);
            
            $request->bouteille_id = $nouvelleBouteille->id;
        }

        Contenir::create([
            'user_id' => auth()->user()->id,
            $request->only('bouteille_id', 'cellier_id', 'date_achat', 'garder_jusqu_a', 'prix_paye', 'quantite', 'mellisme')
        ]);
           
        return response()->json(['status' => 'ok', 'message'=>'Bouteille est créé avec succès']);
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
    public function update(Request $request, Contenir $contenir)
    {
         $request->validate([
            'cellier_id' => 'required|exists:celliers,id',
            'date_achat' => 'date',
            'garder_jusqu_a' => 'date',
            'notes' => 'nullable|integer|between:1,5',
            'commentaire' => 'nullable|string',
            'prix_paye' => 'numeric|min:0',
            'quantite' => 'integer|min:0',
            'mellisme' => 'integer|min:1900|max:2023'
        ]);

        $contenir->update([
            'user_id' => auth()->user()->id,
            $request->only('bouteille_id', 'cellier_id', 'date_achat', 'garder_jusqu_a', 'notes', 'commentaire', 'prix_paye', 'quantite', 'mellisme')
        ]);
        
           
        return response()->json(['status' => 'ok', 'message'=>'Bouteille est mise à jour avec succès']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( Contenir $contenir)
    {
        $contenir->delete();
        return response()->json(['status' => 'ok', 'message'=>'Bouteille est supprimée avec succès']);

    }

}
