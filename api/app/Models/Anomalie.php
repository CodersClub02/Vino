<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anomalie extends Model
{
    use HasFactory;
    protected $fillable=[
        "message",
        "bouteille_id",
        "user_id",
        "resolue",
        "date_resolution",
    ];
}
