<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cellier;

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
     * Sauvegarder le cellier ajouté.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|min:4|max:100',
        ]);

        Cellier::create([
            'nom' => $request->nom,
            'user_id' => auth()->user()->id
        ]);
   
        return response()->json(['status' => 'ok', 'message'=>'cellier créé avec succès']);
    }

    /**
     * Mise à jour d'un cellier.
     */
    public function update(Cellier $cellier, Request $request)
    {
        $request->validate([
            'nom' => 'required|string|min:4|max:100',
        ]);

        $cellier->update([
            'nom' => $request->nom
        ]);

        return response()->json(['status' => 'ok', 'message'=>'cellier modifié avec succès']);
    }

    /**
     * Supprimer un cellier.
     */
    public function destroy(Cellier $cellier)
    {
        $cellier->delete();
        return response()->json(['status' => 'ok', 'message'=>'cellier supprimé avec succès']);
    }
}
