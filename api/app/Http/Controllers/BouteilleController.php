<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bouteille;
use App\Models\Type;
use App\Models\Pays;

class BouteilleController extends Controller
{
    /**
     * @author Saddek
     * @param Request $request
     * Retourne une liste (max, 10) des bouteilles qui ont le nom ou le code saq contenant ce que l'usager cherche..
     */
    public function index(Request $request)
    {
        return response()->json(
            Bouteille::where('nom', 'like', $request->requete . '%')
            ->orWhere('code_saq', 'LIKE', $request->requete . '%')
            ->take(10)
            ->get()
        );
    }
    
    /**
     * 
     * Display the specified resource.
     */
    public function show(Bouteille $bouteille)
    {
        return response()->json(
            $bouteille
        );
    }

}
