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
        Schema::create('caisse', function (Blueprint $table) {
            $table->id();
            $table->string('motif');
            $table->decimal('verser');
            $table->decimal('reste');
            $table->string('lettre');
            $table->string('etat_caisse');
            $table->string('numero_recu');
            $table->unsignedBigInteger('id_pers');
            $table->unsignedBigInteger('id_pat');
            $table->foreign('id_pers')->references('id')->on('personnel');
            $table->foreign('id_pat')->references('id')->on('patient');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caisse');
    }
};
