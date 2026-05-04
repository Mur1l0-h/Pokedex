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
            $table->double("height");
            $table->double("weight");
            $table->integer("hp");
            $table->integer("attack");
            $table->integer("defense");
            $table->string("official_artwork");
            $table->unsignedInteger('created_at');
            $table->unsignedInteger('updated_at');
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
