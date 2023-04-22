<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Type;
use App\Models\Pays;
use App\Models\User;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bouteilles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignIdFor(Type::class)->constrained();
            $table->foreignIdFor(Pays::class)->constrained();
            $table->foreignIdFor(User::class)->constrained();

            $table->string('nom', 200);
            $table->string('code_saq', 50)->nullable();
            $table->string('description_saq', 500)->nullable();
            $table->string('format', 20)->nullable();
            $table->decimal('prix_saq')->nullable();
            $table->string('url_saq', 1000)->nullable();
            $table->string('url_image_saq', 1000)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bouteilles');
    }
};
