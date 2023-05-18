<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cellier;
use App\Models\Contenir;
use App\Models\Bouteille;

class CellierController extends Controller
{
    /**
     * Afficher la liste des celliers.
     */
    public function index()
    {
        return response()->json(
            Cellier::withCount('contenirs')
            ->where('user_id', auth()?->user()?->id)
            ->get()
        );
    }

    /**
     * Afficher la liste des bouteilles de cellier.
     */
    public function show(Request $request, Cellier $cellier)
    {
        $requete = Bouteille::where([['quantite', '>', 0], ['cellier_id', '=', $cellier->id]])
            ->join('contenirs', 'bouteilles.id', '=', 'contenirs.bouteille_id')
            ->join('celliers', 'celliers.id', '=', 'contenirs.cellier_id')
            ->with('pays:nom,id', 'type:nom,id')
            ->where('celliers.user_id', '=', auth()->user()->id)
            ->select('bouteilles.*', 'contenirs.*');
            if($request->filled('tri_par')){
                $requete->orderBy($request->tri_par);
            }

        return response()->json(
            $requete->get()
        );
        
    }

     /**
     * Afficher la liste des bouteilles archivées.
     */
    public function archive(Request $request)
    {
        $requete = Bouteille::where([['quantite', '=', 0]])
            ->join('contenirs', 'bouteilles.id', '=', 'contenirs.bouteille_id')
            ->join('celliers', 'celliers.id', '=', 'contenirs.cellier_id')
            ->with('pays:nom,id', 'type:nom,id')
            ->where('celliers.user_id', '=', auth()->user()->id);
            if($request->filled('tri_par')){
                $requete->orderBy($request->tri_par);
            }

        return response()->json(
            $requete->get()
        );
        
    } 

    /**
     * Sauvegarder le cellier ajouté.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|min:4|max:100',
        ]);

        $cellier = Cellier::create([
            'nom' => $request->nom,
            'user_id' => auth()->user()->id
        ]);
   
        return response()->json($cellier);
    }

    /**
     * Mise à jour d'un cellier.
     */
    public function update(Cellier $cellier, Request $request)
    {
        $request->validate([
            'nom' => 'required|string|min:4|max:100',
        ]);

        $cellier->where('user_id', '=', auth()->user()->id)
        ->update([
            'nom' => $request->nom
        ]);

        return response()->json(['status' => 'ok', 'message'=>'cellier modifié avec succès']);
    }

    /**
     * Supprimer un cellier.
     */
    public function destroy(Cellier $cellier)
    {

        Contenir::where('cellier_id', '=', $cellier->id)
        ->delete();
        
        $cellier->delete();
        return response()->json(['status' => 'ok', 'message'=>'cellier supprimé avec succès']);
    }
}
