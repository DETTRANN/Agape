<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Cliente;
use Illuminate\Support\Facades\Hash;

// Criar um cliente teste
$cliente = Cliente::create([
    'nome' => 'Teste',
    'sobrenome' => 'Usuario',
    'email' => 'teste@teste.com',
    'senha' => Hash::make('123456')
]);

echo "Cliente teste criado com ID: " . $cliente->id . "\n";
echo "Email: teste@teste.com\n";
echo "Senha: 123456\n";
