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
        Schema::create('resultp', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pat');
            $table->unsignedBigInteger('id_pers');
            $table->unsignedBigInteger('id_cons');
            $table->string('exam');
            $table->string('result_text');
            $table->string('result_image');
            $table->foreign('id_cons')->references('id')->on('consultation');
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
        Schema::dropIfExists('resultp');
    }
};
