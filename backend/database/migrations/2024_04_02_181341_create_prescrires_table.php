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
        Schema::create('prescrire', function (Blueprint $table) {
            $table->id();
            $table->string('dose');
            $table->string('prise');
            $table->boolean('status')->default(0);
            $table->string('medicament');
            $table->unsignedBigInteger('id_consul');
            $table->unsignedBigInteger('id_pat');
            $table->unsignedBigInteger('id_pers');
            $table->foreign('id_consul')->references('id')->on('consultation');
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
        Schema::dropIfExists('prescrire');
    }
};
