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
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->integer('id_item')->nullable(); // Número sequencial por usuário
            $table->string('status');
            $table->string('nome_item');
            $table->text('descricao')->nullable();
            $table->string('categoria');
            $table->string('numero_serie')->nullable();
            $table->decimal('preco', 10, 2);
            $table->date('data_posse');
            $table->string('responsavel');
            $table->string('localidade')->nullable();
            $table->text('observacoes')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            
            // Foreign key constraint para clientes
            $table->foreign('user_id')->references('id')->on('clientes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
