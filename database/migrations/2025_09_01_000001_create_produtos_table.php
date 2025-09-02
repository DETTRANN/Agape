<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('id_item');
            $table->string('status');
            $table->string('nome_item');
            $table->text('descricao');
            $table->string('categoria');
            $table->string('numero_serie');
            $table->decimal('preco', 10, 2);
            $table->date('data_posse');
            $table->string('responsavel');
            $table->string('localidade')->nullable();
            $table->text('observacoes')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('produtos');
    }
};
