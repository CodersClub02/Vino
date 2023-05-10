<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('anomalies', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('bouteille_id')->constrained()->nullable();
            $table->foreignId('user_id')->constrained()->nullable();
            $table->string('message');
            $table->boolean('resolue')->nullable();
            $table->date('date_resolution')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anomalies');
    }
};
