<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CellierController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
use App\Http\Controllers\ScraperController;
use App\Models\Contenir;

Route::get('/scraper', [ScraperController::class, 'store']);


Route::group(['middleware' => 'auth:sanctum'], function(){

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    //cette ligne accompli le "route binding"
    Route::model('bouteille', 'App\Models\Bouteille');
    //cette ligne gere toutes les resources de l'url bouteille: post, get, put...
    Route::apiResource('bouteille', 'App\Http\Controllers\BouteilleController');
    
    Route::model('cellier', 'App\Models\Cellier');
    Route::apiResource('cellier', 'App\Http\Controllers\CellierController');

    Route::model('contenir', 'App\Models\Contenir');
    Route::apiResource('contenir', 'App\Http\Controllers\ContenirController');
    Route::put('deplacer-bouteilles/{id}', [App\Http\Controllers\ContenirController::class, 'deplacerBouteilles']);
    Route::put('anomalie/{contenir}', [App\Http\Controllers\ContenirController::class, 'signaler']);

    Route::model('pays', 'App\Models\Pays');
    Route::apiResource('pays', 'App\Http\Controllers\PaysController');
    
    Route::model('type', 'App\Models\Type');
    Route::apiResource('type', 'App\Http\Controllers\TypeController');

    Route::get('archive', [App\Http\Controllers\CellierController::class, 'archive']);

    // Admin routes
    Route::get('membres', [App\Http\Controllers\AdminController::class, 'membres']);
    Route::put('membres/{user}', [App\Http\Controllers\AdminController::class, 'modifierStatut']);
    Route::get('signalements', [App\Http\Controllers\AdminController::class, 'signalements']);
    Route::put('signalements', [App\Http\Controllers\AdminController::class, 'resoudre']);

});