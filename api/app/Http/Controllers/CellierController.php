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
        return Cellier::where('user_id', auth()?->user()?->id)->get();
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
     * Display the specified resource.
     */
    public function show(Cellier $cellier)
    {
        return response()->json($cellier);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Cellier $cellier, Request $request)
    {
        $request->validate([
            'nom' => 'required|string|min:10|max:100',
        ]);

        $cellier::where('user_id', auth()->user()->id)->update([
            'nom' => $request->nom
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cellier::where('user_id', auth()->user()->id)->delete();
        return response()->json(['status' => 'ok', 'message'=>'cellier supprimé avec succès']);
    }
}
