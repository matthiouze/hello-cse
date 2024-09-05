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
	    Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            // Clé étrangère pour l'administrateur ayant créé le profil
            $table->foreignId('admin_id')
                ->nullable()
                ->constrained()
                ->onDelete('set null');

            $table->string('name');
            $table->string('firstname');
            $table->string('image_path'); // Stockage du chemin du fichier image
            $table->enum('status', ['unactive', 'pending', 'active'])->default('pending');
            $table->timestamps();
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
