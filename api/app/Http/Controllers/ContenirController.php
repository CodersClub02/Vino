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
        $predicate = [['quantite', '>', 0], ['celliers.user_id', '=', auth()->user()->id]];

        if($request->has('recherche') || $request->has('filtre')){

            if($request->has('cellier_id')) array_push($predicate, ['cellier_id', '=', $request->cellier_id]);
            if($request->has('mot_cle')) array_push($predicate, ['bouteilles.nom', 'like', $request->mot_cle . '%']);
            if($request->has('notes')) array_push($predicate, ['notes', '=', $request->notes ]);
            if($request->has('type_id')) array_push($predicate, ['type_id', '=', $request->type_id ]);
            if($request->has('pays_id')) array_push($predicate, ['pays_id', '=', $request->pays_id ]);
            
            $requete = Bouteille::where($predicate)
            ->join('contenirs', 'bouteilles.id', '=', 'contenirs.bouteille_id')
            ->join('celliers', 'celliers.id', '=', 'contenirs.cellier_id')
            ->select('bouteilles.*', 'contenirs.*')
            ->with('pays:nom,id', 'type:nom,id');

        }else{
            array_push($predicate, ['cellier_id', '=', $request->id]);
            $requete = Contenir::where($predicate)
            ->join('celliers', 'celliers.id', '=', 'contenirs.cellier_id');
        }

        if($request->has('tri_par')){
            $requete->orderBy($request->tri_par);
        }
        return response()->json(
            $requete->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:200',
            'cellier_id' => 'required|exists:celliers,id',
            'date_achat' => 'required|date',
            'garder_jusqu_a' => 'required|integer|gte:2023',//date(Y)
            'prix_paye' => 'required|numeric|gte:0',
            'quantite' => 'required|integer|gte:0',
            'millesime' => 'nullable:integer|gte:1900|lte:2023',
            'format' => 'required_if:source,autre|string|max:20',
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
        }

        Contenir::create([
            'user_id' => auth()->user()->id,
            'bouteille_id' => Bouteille::where(
                'nom', $request->nom)->firstOrFail()->id,
            'cellier_id' => $request->cellier_id,
            'date_achat' => $request->date_achat,
            'garder_jusqu_a' => $request->garder_jusqu_a,
            'prix_paye' => $request->prix_paye,
            'quantite' => $request->quantite,
            'millesime' => $request->millesime
        ]);
           
        return response()->json(['status' => 'ok', 'message'=>'Bouteille est créé avec succès']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Contenir $contenir, Request $request)
    {
         $request->validate([
            'cellier_id' => 'required|exists:celliers,id,user_id,' . auth()->user()->id,
            'date_achat' => 'required|date',
            'garder_jusqu_a' => 'required|integer|gte:2023',//date(Y)',
            'notes' => 'nullable|integer|between:1,5',
            'commentaire' => 'nullable|string',
            'prix_paye' => 'numeric|gte:0',
            'quantite' => 'integer|gte:0',
            'millesime' => 'nullable:integer|gte:1900|lte:2023',
        ]);

        $contenir
        ->update([            
            'cellier_id' => $request->cellier_id,
            'bouteille_id' => Bouteille::where('nom', $request->nom)->firstOrFail()->id,
            'date_achat' => $request->date_achat,
            'garder_jusqu_a' => $request->garder_jusqu_a,
            'prix_paye' => $request->prix_paye,
            'quantite' => $request->quantite,
            'millesime' => $request->millesime,
            'notes' => $request->notes,
            'commentaire' => $request->commentaire,
        ]);
        
           
        return response()->json(['status' => 'ok', 'message'=>'Bouteille est mise à jour avec succès']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deplacerBouteilles(Request $request, Contenir $contenir)
    {
        
        Contenir::where('cellier_id', '=', $request->id)
        ->update([
            'cellier_id' => $request->cellier_cible,
        ]);

        return response()->json(['status' => 'ok', 'message'=>'Bouteilles déplacées avec succès']);

    }

    /**
     * Signaler erreur de bouteille
     */
    public function signaler(Request $request, Contenir $contenir)
    {
        $request->validate([
            'anomalie' => 'required|string|min:4|max:200',
        ]);

        $contenir->update([
            'anomalie' => $request->anomalie,
        ]);

        return response()->json(['status' => 'ok', 'message'=>'Bouteille signalée avec succès']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contenir $contenir)
    {
        $contenir->delete();
        return response()->json(['status' => 'ok', 'message'=>'Bouteille est supprimée avec succès']);
    }

}