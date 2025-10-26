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
        Schema::create('categoria_configuracoes', function (Blueprint $table) {
            $table->id();
            $table->string('nome_categoria');
            $table->integer('dias_alerta_validade')->default(30); // Prazo padrão de 30 dias
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            
            // Foreign key constraint para clientes
            $table->foreign('user_id')->references('id')->on('clientes')->onDelete('cascade');
            
            // Índice único para evitar categorias duplicadas por usuário
            $table->unique(['nome_categoria', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categoria_configuracoes');
    }
};
