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
        Schema::create('rendez_vous', function (Blueprint $table) {
            $table->id();
            $table->date('date_r');
            $table->string('motif_r');
            $table->string('notes');
            $table->string('status');
            $table->boolean('is_delete')->default(0);
            $table->unsignedBigInteger('id_pat');
            $table->unsignedBigInteger('id_pers');
            $table->foreign('id_pat')->references('id')->on('patient');
            $table->foreign('id_pers')->references('id')->on('personnel');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rendez_vous');
    }
};
