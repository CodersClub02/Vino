<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Bouteille;
use App\Models\Cellier;
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
         return response()->json(
            User::withCount('contenirs', 'celliers')
            ->whereNot('id', auth()?->user()?->id)
            ->get()
            
        );
    }

    /**
     * @author Saddek
     * Renvoyer la liste des signalements de bouteilles
     */
    public function signalements()
    {
         return response()->json(
            Anomalie::join('bouteilles', 'bouteilles.id', '=', 'anomalies.bouteille_id')
            ->join('users', 'users.id', '=', 'anomalies.user_id')
            ->where('resolue', '=', '0')
            ->select("bouteille_id", "anomalies.id as anomalie_id", "message", "resolue", "date_resolution", "type_id", "pays_id", "nom", "code_saq", "description_saq", "format", "prix_saq", "url_saq", "url_image_saq", "name")
            ->get()
        );

    }

    /**
     * @author Saddek
     * Resoudre une anomalie
     */
    public function resoudre(Request $request)
    {
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
        
        Anomalie::where('id', $request->anomalie_id)
            ->update([
                'resolue' => true,
                'date_resolution' => now()
            ]);

        return response()->json(['status' => 'ok', 'message'=>'Bouteille mis à jour avec succès']);

    }



    /**
     * @author: Hanane
     * @return: json
     * Suspendre/Aciver le compte d'un membre.
     */
    public function modifierStatut(User $user)
    {
        $user->update([
            "actif" => !$user->actif
        ]);

        return response()->json(['status' => 'ok', 'message'=>'Membre est suspendu avec succès']);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
