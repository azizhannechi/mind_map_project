<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('progressions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('objectif_id')->constrained('objectifs')->onDelete('cascade'); // Lien avec l'objectif
            $table->string('name'); // Nom de l'étape
            $table->decimal('progression', 5, 2)->default(0); // Progression de l'étape
            $table->date('deadline')->nullable(); // Date limite de l'étape
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
        Schema::dropIfExists('progressions');
    }
};
