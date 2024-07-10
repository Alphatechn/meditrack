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
        Schema::create('consultation', function (Blueprint $table) {
            $table->id();
            $table->decimal('temperature');
            $table->decimal('poids');
            $table->decimal('taille');
            $table->string('type_cons');
            $table->string('symptome');
            $table->string('diagnostique');
            $table->string('exam_recom');
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('consultation');
    }
};
