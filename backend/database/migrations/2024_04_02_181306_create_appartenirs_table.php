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
        Schema::create('appartenir', function (Blueprint $table) {
            $table->id();
            $table->date('date_debut');
            $table->date('date_fin');
            $table->unsignedBigInteger('id_ser');
            $table->unsignedBigInteger('id_per');
            $table->Integer('status')->default(0);
            $table->foreign('id_ser')->references('id')->on('service');
            $table->foreign('id_per')->references('id')->on('personnel');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appartenir');
    }
};
