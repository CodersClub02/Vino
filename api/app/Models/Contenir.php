<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contenir extends Model
{
    use HasFactory;
       /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cellier_id',
        'bouteille_id',
        'date_achat',
        'garder_jusqu_a',
        'notes',
        'prix_paye',
        'quantite',
        'mellisme'
    ];
}
