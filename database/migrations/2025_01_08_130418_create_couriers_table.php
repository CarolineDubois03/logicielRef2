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
        Schema::create('couriers', function (Blueprint $table) {
            $table->id();
            $table->integer('annual_id'); // Numéro annuel unique
            $table->string('object'); // Objet du courrier
            $table->unsignedBigInteger('recipient')->nullable(); // Destinataire (peut être null si non défini)
            $table->date('date'); // Date du courrier
            $table->foreignId('id_handling_user')->nullable()->constrained('users')->onDelete('set null'); // Agent traitant
            $table->text('copy_to')->nullable(); // Champs permettant plusieurs utilisateurs (JSON)
            $table->unsignedBigInteger('category')->nullable(); // Catégorie (clé étrangère)
            $table->string('document_path')->nullable(); // Chemin du document associé
            $table->integer('year'); // Année associée au courrier
            
            $table->timestamps();

            // Contraintes et clés uniques
            $table->unique(['annual_id', 'year']); // Unicité pour une année spécifique
            $table->foreign('recipient')->references('id')->on('recipients')->onDelete('set null'); // Liaison avec la table des destinataires
            $table->foreign('category')->references('id')->on('categories')->onDelete('set null'); // Liaison avec la table des catégories
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('couriers');
    }
};
