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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->integer('telephone');
            $table->string('adresse');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('status')->default(0);
            $table->string('sit_mat');
            $table->string('sexe');
            $table->string('profil');
            $table->boolean('is_delete')->default(0);
            $table->rememberToken();
            $table->unsignedBigInteger('id_type_user');
            $table->foreign('id_type_user')->references('id')->on('type_users');
            $table->timestamps();

            // Spécifier le moteur InnoDB
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
