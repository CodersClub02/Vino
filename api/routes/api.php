<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


// Route::group(['middleware' => 'auth:sanctum'], function(){

    //cette ligne accompli le "route binding"
    Route::model('bouteille', 'App\Models\Bouteille');
    //cette ligne gere toutes les resources de l'url bouteille: post, get, put...
    Route::apiResource('bouteille', 'App\Http\Controllers\BouteilleController');
    
    Route::model('cellier', 'App\Models\Cellier');
    Route::apiResource('cellier', 'App\Http\Controllers\CellierController');
    
    Route::model('contenir', 'App\Models\Contenir');
    Route::apiResource('contenir', 'App\Http\Controllers\ContenirController');
    
    Route::model('pays', 'App\Models\Pays');
    Route::apiResource('pays', 'App\Http\Controllers\PaysController');
    
    Route::model('type', 'App\Models\Type');
    Route::apiResource('type', 'App\Http\Controllers\TypeController');
// });