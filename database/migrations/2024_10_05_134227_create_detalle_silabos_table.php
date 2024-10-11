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
        Schema::create('detalle_silabos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('silabo_id');
            $table->string('encuentro');
            $table->date('fecha');

            $table->json('unidades_id')->nullable()->comment('Relacion_con_data');
            $table->json('objetivos_id')->nullable()->comment('Relacion_con_data');
            $table->json('contenidos_id')->nullable()->comment('Relacion_con_data');

            $table->foreignId('forma_organizativa_id')->nullable()->constrained('catalogos');
            $table->text('formas_organizativa_detalle_id')->nullable();
            $table->text('metodologia')->nullable();
            $table->float('horas_presenciales')->nullable();
            $table->float('horas_trabajo_independiente')->nullable();
            $table->foreignId('evaluacion_id')->nullable()->constrained('catalogos');
            $table->text('evaluacion_detalle')->nullable();
            $table->text('observaciones')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_silabos');
    }
};
