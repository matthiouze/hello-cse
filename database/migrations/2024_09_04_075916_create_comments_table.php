<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->text('contenu');
            $table->unsignedBigInteger('admin_id');
            $table->unsignedBigInteger('profile_id');
            $table->timestamps();

            // Clé étrangère pour l'administrateur ayant posté le commentaire
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('cascade');

            // Clé étrangère pour le profil concerné par le commentaire
            $table->foreign('profile_id')->references('id')->on('profiles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
};
