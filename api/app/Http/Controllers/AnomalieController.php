<?php

namespace App\Http\Controllers;

use App\Models\Anomalie;
use Illuminate\Http\Request;

class AnomalieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $request->validate([
            'message' => 'required|string|min:4|max:200',
            'bouteille_id' => 'exists:bouteilles,id',
        ]);

       Anomalie::create([
            'message' => $request->message,
            'user_id' => auth()->user()->id,
            'bouteille_id' => $request->bouteille_id,
        ]);
   
        return response()->json(['status' => 'ok', 'message'=>'erreur signalé avec succès']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Anomalie $anomalie)
    {
        //
    }

}
