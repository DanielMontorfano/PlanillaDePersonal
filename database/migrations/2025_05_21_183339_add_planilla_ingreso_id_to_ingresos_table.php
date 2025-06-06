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
            $table->foreignId('planilla_ingreso_id')->nullable()->after('sector_id')->constrained()->onDelete('set null');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ingresos', function (Blueprint $table) {
            $table->dropForeign(['planilla_ingreso_id']);
            $table->dropColumn('planilla_ingreso_id');
        });
    }
    
};
