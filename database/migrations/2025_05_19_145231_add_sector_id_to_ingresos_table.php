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
    Schema::table('ingresos', function (Blueprint $table) {
        $table->foreignId('sector_id')
              ->nullable() // lo dejamos nullable por ahora
              ->constrained()
              ->onDelete('set null'); // si se borra un sector, se limpia el campo
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ingresos', function (Blueprint $table) {
            $table->dropForeign(['sector_id']);
            $table->dropColumn('sector_id');
        });
    }
    
};
