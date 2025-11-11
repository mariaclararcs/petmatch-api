<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('adoptions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('adopter_id'); // usuário que está adotando
            $table->uuid('animal_id');
            $table->uuid('ong_id'); // ONG dona do animal
            
            // Dados do formulário
            $table->string('name_adopter');
            $table->string('email_adopter');
            $table->date('birth_date');
            $table->string('phone_adopter');
            $table->text('address');
            $table->string('cep');
            
            // Questionário
            $table->text('quest1');
            $table->text('quest2');
            $table->text('quest3');
            $table->text('quest4');
            $table->text('quest5');
            $table->text('quest6');
            $table->text('quest7');
            $table->text('quest8');
            $table->text('quest9');
            $table->text('quest10');
            
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamp('request_at')->useCurrent();
            
            $table->timestamps();
            $table->softDeletes();

            // Chaves estrangeiras
            $table->foreign('adopter_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('animal_id')->references('id')->on('animals')->onDelete('cascade');
            $table->foreign('ong_id')->references('id')->on('ongs')->onDelete('cascade');

            // Índices
            $table->index('adopter_id');
            $table->index('animal_id');
            $table->index('ong_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('adoptions');
    }
};