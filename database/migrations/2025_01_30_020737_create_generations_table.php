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
        Schema::create('generations', function (Blueprint $table) {
            $table->id();
            $table->year('fecha_inicio');
            $table->year('fecha_termino');
            $table->integer('status')->default(1);
            $table->unsignedBigInteger('level_id')->nullable();
            $table->integer('order');
            $table->timestamps();

            $table->foreign('level_id')->references('id')->on('levels')->onDelete('set null');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generations');
    }
};
