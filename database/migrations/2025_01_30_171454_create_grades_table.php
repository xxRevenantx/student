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
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->string('grado');
            $table->string('grado_numero');
            $table->unsignedBigInteger('level_id')->nullable();
            $table->unsignedBigInteger('generation_id')->nullable();
            $table->json('grupos')->nullable();
            $table->integer('order');

            $table->foreign('level_id')->references('id') ->on('levels')->onDelete('set null');

            $table->foreign('generation_id')->references('id')->on('generations')->onDelete('set null');



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
