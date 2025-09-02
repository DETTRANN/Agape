<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

echo "Executando migrate:fresh...\n";
$exitCode = Artisan::call('migrate:fresh', ['--force' => true]);
echo "Migrate fresh executado com código: $exitCode\n";

echo "Criando usuário de teste...\n";
$user = App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@teste.com',
    'password' => Hash::make('123456')
]);

echo "Usuário criado com ID: " . $user->id . "\n";

echo "Verificando estrutura da tabela produtos...\n";
$columns = DB::select("PRAGMA table_info(produtos)");
foreach ($columns as $column) {
    echo "- " . $column->name . " (" . $column->type . ")\n";
}

echo "Migration concluída com sucesso!\n";
