<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('planilla_ingresos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha')->default(now());
            $table->foreignId('solicitante_id')->constrained()->onDelete('cascade');
            $table->string('numero')->nullable(); // por si querés un identificador manual
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('planilla_ingresos');
    }
};
