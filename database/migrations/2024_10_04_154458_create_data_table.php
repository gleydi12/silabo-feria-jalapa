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
        Schema::create('data', function (Blueprint $table) {
            $table->id();
            $table->string('value');
            $table->foreignId('categoria_id')->nullable()->constrained('catalogos');
            $table->foreignId('tipo_dato_id')->nullable()->constrained('catalogos');
            $table->morphs('asignable'); // Polimorfica
            $table->foreignId('depende_de_id')->nullable()->constrained('data');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data');
    }
};
