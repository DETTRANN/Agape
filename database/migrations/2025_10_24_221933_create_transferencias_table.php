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
        Schema::create('transferencias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('produto_id');
            $table->unsignedBigInteger('user_id');
            $table->string('localidade_origem');
            $table->string('localidade_destino');
            $table->string('responsavel_origem');
            $table->string('responsavel_destino');
            $table->enum('status', ['pendente', 'em_transito', 'concluida', 'cancelada'])->default('pendente');
            $table->date('data_solicitacao');
            $table->date('data_inicio')->nullable();
            $table->date('data_conclusao')->nullable();
            $table->text('motivo')->nullable();
            $table->text('observacoes')->nullable();
            $table->string('codigo_rastreamento')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('produto_id')->references('id')->on('produtos')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('clientes')->onDelete('cascade');
            
            // Índices
            $table->index(['user_id', 'status']);
            $table->index(['produto_id', 'status']);
            $table->index('codigo_rastreamento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transferencias');
    }
};
