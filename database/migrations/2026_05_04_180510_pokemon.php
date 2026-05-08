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
        Schema::create('pokemon', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("type");
            $table->string("type2")->nullable(); // <-- NEW FIELD
            $table->double("height");
            $table->double("weight");
            $table->integer("hp");
            $table->integer("attack");
            $table->integer("defense");
            $table->integer("speed");
            $table->string("special-attack"); // Remember to change to integer if you haven't!
            $table->string("special-defense"); // Remember to change to integer if you haven't!
            $table->string("official_artwork")->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
