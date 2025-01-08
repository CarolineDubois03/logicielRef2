<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema; // Add missing import statement

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('couriers', function (Blueprint $table) {
            $table->id();
            $table->integer('annual_id');
            $table->string('object');
            $table->string('nature');
            $table->string('document_path')->nullable();
            $table->foreignId('id_handling_user')->constrained('users');
            $table->integer('year');

            $table->timestamps();

            $table->unique(['annual_id', 'year']);
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
