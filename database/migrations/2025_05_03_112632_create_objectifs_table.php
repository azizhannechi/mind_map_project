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
        Schema::create('objectifs', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('slug')->unique();
            $table->string('categorie')->default('autre');
            $table->text('description')->nullable();
            $table->date('date_debut')->nullable();
            $table->date('date_limite')->nullable();
            $table->string('lieu')->nullable();
            $table->enum('visibilite', ['public', 'prive'])->default('public');
            $table->float('latitude')->nullable();
            $table->float('longitude')->nullable();
            $table->float('progression')->default(0);
            $table->string('couleur')->nullable();
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
        Schema::dropIfExists('objectifs');
    }
};
