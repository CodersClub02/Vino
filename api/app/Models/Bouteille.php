<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bouteille extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type_id',
        'pays_id',
        'nom'
        // $table->string('code_saq', 50)->nullable;
        // $table->string('description_saq', 500)->nullable;
        // $table->string('format', 20)->nullable;
        // $table->decimal('prix_saq')->nullable;
        // $table->string('url_saq', 1000)->nullable;
        // $table->string('url_image_saq', 1000)->nullable;
    ];
}
