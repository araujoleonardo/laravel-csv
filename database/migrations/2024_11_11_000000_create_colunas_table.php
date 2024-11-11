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
        Schema::create('colunas', function (Blueprint $table) {
            $table->id();
            $table->string('coluna01')->nullable();
            $table->string('coluna02')->nullable();
            $table->string('coluna03')->nullable();
            $table->string('coluna04')->nullable();
            $table->string('coluna05')->nullable();
            $table->string('coluna06')->nullable();
            $table->string('coluna07')->nullable();
            $table->string('coluna08')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colunas');
    }
};
