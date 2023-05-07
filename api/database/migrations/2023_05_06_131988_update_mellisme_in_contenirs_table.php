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
        Schema::table('contenirs', function (Blueprint $table) {
            $table->renameColumn('mellisme', 'millesime');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contenirs', function (Blueprint $table) {
            $table->renameColumn('millesime', 'mellisme');
        });
    }
};
