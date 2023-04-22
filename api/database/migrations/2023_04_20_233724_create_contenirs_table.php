<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Bouteille;
use App\Models\Cellier;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contenirs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(Bouteille::class)->constrained();
            $table->foreignIdFor(Cellier::class)->constrained();
            $table->date('date_achat');
            $table->date('garder_jusqu_a')->nullable();
            $table->integer('note')->nullable();
            $table->decimal('prix_paye')->nullable();
            $table->integer('quantite');
            $table->integer('mellisme')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contenirs');
    }
};
