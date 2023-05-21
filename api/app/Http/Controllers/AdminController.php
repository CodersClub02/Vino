<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Bouteille;
use App\Models\Cellier;
use App\Models\Contenir;
use App\Models\Anomalie;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * @author Hanane
     * Renvoyer la liste de tous les membres non administrateur
     */
    public function membres()
    {
        if( auth()->user()->est_admin != 1){
            return response()->json(['status' => 'not ok', 'message'=>'non autorisé']);
        }
         return response()->json(
            User::withCount('contenirs', 'celliers')
            ->whereNot('id', auth()?->user()?->id)
            ->paginate(20)            
        );
    }

    /**
     * @author Saddek
     * Renvoyer la liste des signalements de bouteilles
     */
    public function signalements()
    {
        if( auth()->user()->est_admin != 1){
            return response()->json(['status' => 'not ok', 'message'=>'non autorisé']);
        }

         return response()->json(
            Cellier::join('contenirs', 'celliers.id', '=', 'contenirs.cellier_id')
            ->join('users', 'users.id', '=', 'celliers.user_id')
            ->join('bouteilles', 'bouteilles.id', '=', 'contenirs.bouteille_id')
            ->select("contenirs.id as contenir_id", "bouteille_id", "anomalie", "type_id", "pays_id", "bouteilles.nom", "code_saq", "description_saq", "format", "prix_saq", "url_saq", "url_image_saq", "name")
            ->whereNotNull('anomalie')
            ->paginate(20)
        );

    }

    /**
     * @author Saddek
     * Resoudre une anomalie: corriger l'erreur signalée par le membre
     */
    public function resoudre(Request $request)
    {
        if( auth()->user()->est_admin != 1){
            return response()->json(['status' => 'not ok', 'message'=>'non autorisé']);
        }

        $request->validate([
            'type_id' => 'required|exists:types,id',
            'pays_id' => 'required|exists:pays,id',
            'nom' => 'required|string|min:10',
            'code_saq' => 'required|integer',
            'description_saq' =>'required',
            'format' => 'required|string',
            'prix_saq' => 'required|numeric|gte:0',
            'url_saq' => 'required|url',
            'url_image_saq' => 'required|url',
        ]);

        $corrigerBouteille = Bouteille::where('id', $request->bouteille_id)
        ->update([
           'type_id' => $request->type_id,
           'pays_id' => $request->pays_id,
           'nom' => $request->nom,
           'code_saq' => $request->code_saq,
           'description_saq' => $request->description_saq,
           'format' => $request->format,
           'prix_saq' => $request->prix_saq,
           'url_saq' => $request->url_saq,
           'url_image_saq' => $request->url_image_saq
        ]);
        
        Contenir::where('id', $request->contenir_id)
        ->update(['anomalie' => null]);

        return response()->json(['status' => 'ok', 'message'=>'Bouteille mis à jour avec succès']);

    }

    /**
     * @author: Hanane
     * @return: json
     * Suspendre/Aciver le compte d'un membre.
     */
    public function modifierStatut(User $user)
    {
        if( auth()->user()->est_admin != 1){
            return response()->json(['status' => 'not ok', 'message'=>'non autorisé']);
        }
        
        $user->update([
            "actif" => !$user->actif
        ]);

        return response()->json(['status' => 'ok', 'message'=>'Membre est suspendu avec succès']);

    }

}
