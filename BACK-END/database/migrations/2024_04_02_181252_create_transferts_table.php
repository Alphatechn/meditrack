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
        Schema::create('transfert', function (Blueprint $table) {
            $table->id();
            $table->date('date_envoi');
            $table->date('date_recu');
            $table->string('etat_transf');
            $table->string('motif');
            $table->unsignedBigInteger('id_pat');
            $table->unsignedBigInteger('id_pers');
            $table->integer('id_pers_r')->nullable();
            $table->boolean('id_cons')->nullable();
            $table->boolean('etat_caisse')->default(0);
            $table->boolean('status')->default(0);
            $table->unsignedBigInteger('id_ser');
            $table->foreign('id_pat')->references('id')->on('patient');
            $table->foreign('id_pers')->references('id')->on('personnel');
            $table->foreign('id_ser')->references('id')->on('service');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfert');
    }
};
