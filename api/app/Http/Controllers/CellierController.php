<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cellier;

class CellierController extends Controller
{
    /**
     * Display a listing of the resource.
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|min:10|max:100',
        ]);

        Cellier::create([
            'nom' => $request->nom,
            'user_id' => auth()->user()->id
        ]);
   
        return response()->json(['status' => 'ok', 'message'=>'cellier créé avec succès']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Cellier $cellier, Request $request)
    {
        $request->validate([
            'nom' => 'required|string|min:10|max:100',
        ]);

        $cellier->update([
            'nom' => $request->nom
        ]);

        return response()->json(['status' => 'ok', 'message'=>'cellier modifié avec succès']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cellier $cellier)
    {
        $cellier->delete();
        return response()->json(['status' => 'ok', 'message'=>'cellier supprimé avec succès']);
    }
}
