<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
	Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('firstname');
            $table->unsignedBigInteger('admin_id');
            $table->string('image_path'); // Stockage du chemin du fichier image
            $table->enum('status', ['unactive', 'pending', 'active'])->default('pending');
            $table->timestamps();

            // Clé étrangère pour l'administrateur ayant créé le profil
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
};
