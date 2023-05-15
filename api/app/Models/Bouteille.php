<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pays;
use App\Models\Type;

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
        'nom',
        'code_saq',
        'description_saq',
        'format',
        'prix_saq',
        'url_saq',
        'url_image_saq',
    ];

    public function pays()
    {
        return $this->belongsTo(Pays::class, 'pays_id');
    }
    
    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}
