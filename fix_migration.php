<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

echo "Criando tabela clientes...\n";

try {
    Schema::create('clientes', function (Blueprint $table) {
        $table->id();
        $table->string('nome');
        $table->string('sobrenome');
        $table->string('email')->unique();
        $table->string('senha');
        $table->timestamps();
    });
    
    echo "Tabela 'clientes' criada com sucesso!\n";
} catch (Exception $e) {
    echo "Erro ao criar tabela: " . $e->getMessage() . "\n";
}

// Verificar se a tabela existe
if (Schema::hasTable('clientes')) {
    echo "Confirmado: Tabela 'clientes' existe no banco de dados.\n";
} else {
    echo "Erro: Tabela 'clientes' ainda não existe.\n";
}
