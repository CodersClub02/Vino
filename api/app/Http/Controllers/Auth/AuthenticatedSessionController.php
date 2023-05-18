<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Gérer une requête d'authenfication.
     */
    public function store(LoginRequest $request): Response
    {
        $request->authenticate();

        if(auth()->user()->actif == 0){
            Auth::guard('web')->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();
            abort(403, "Compte vérouillé. Contactez l'admin svp");

        }else{
            
            $request->session()->regenerate();
            return response()->noContent();
        }

    }

    /**
     * Détruire une session authentifiée.
     */
    public function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
