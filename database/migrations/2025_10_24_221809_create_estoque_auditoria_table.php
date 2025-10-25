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
        Schema::create('estoque_auditoria', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('produto_id');
            $table->unsignedBigInteger('user_id');
            $table->string('tipo_operacao'); // 'criacao', 'atualizacao', 'exclusao', 'transferencia'
            $table->string('campo_alterado')->nullable(); // Campo que foi alterado
            $table->text('valor_anterior')->nullable(); // Valor anterior
            $table->text('valor_novo')->nullable(); // Novo valor
            $table->string('ip_usuario')->nullable();
            $table->text('observacoes')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('produto_id')->references('id')->on('produtos')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('clientes')->onDelete('cascade');
            
            // Índices para melhor performance
            $table->index(['produto_id', 'created_at']);
            $table->index(['user_id', 'created_at']);
            $table->index('tipo_operacao');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estoque_auditoria');
    }
};
