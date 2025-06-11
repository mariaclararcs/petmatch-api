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
        Schema::create('animals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('ong_id');
            $table->foreign('ong_id')->references('id')->on('ongs');
            $table->string('name');
            $table->integer('age');
            $table->enum('gender', ['male', 'female'])->default('male');
            $table->enum('type', ['dog', 'cat', 'other'])->default('dog');
            $table->enum('size', ['small', 'medium', 'large'])->default('medium');
            $table->date('shelter_date')->default(now());
            $table->string('image')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};
