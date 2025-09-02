# AGAPE - SCRIPT DE SETUP AUTOMÁTICO PARA WINDOWS
# ================================================

Write-Host "AGAPE - SCRIPT DE SETUP AUTOMÁTICO" -ForegroundColor Green
Write-Host "===================================" -ForegroundColor Green
Write-Host ""

# Verificar se estamos no diretório correto
if (-not (Test-Path "artisan")) {
    Write-Host "ERRO: Execute este script na raiz do projeto Laravel" -ForegroundColor Red
    exit 1
}

Write-Host "Instalando dependências..." -ForegroundColor Yellow
composer install

Write-Host "Configurando ambiente..." -ForegroundColor Yellow
if (-not (Test-Path ".env")) {
    Copy-Item ".env.example" ".env"
    php artisan key:generate
    Write-Host "Arquivo .env criado e chave gerada" -ForegroundColor Green
} else {
    Write-Host "Arquivo .env já existe" -ForegroundColor Yellow
}

Write-Host "Configurando banco de dados..." -ForegroundColor Yellow
# Remover banco existente se houver problemas
if (Test-Path "database/database.sqlite") {
    Write-Host "Removendo banco SQLite existente..." -ForegroundColor Yellow
    Remove-Item "database/database.sqlite"
}

# Criar novo banco
New-Item -ItemType File -Path "database/database.sqlite" -Force
Write-Host "Banco SQLite criado" -ForegroundColor Green

Write-Host "Executando migrações..." -ForegroundColor Yellow
php artisan migrate --force

Write-Host "Limpando caches..." -ForegroundColor Yellow
php artisan config:clear
php artisan route:clear
php artisan cache:clear
php artisan view:clear

Write-Host "Recriando caches otimizados..." -ForegroundColor Yellow
php artisan config:cache
php artisan route:cache

Write-Host "Criando usuário de teste..." -ForegroundColor Yellow
$createUser = @"
\App\Models\Cliente::create([
    'nome' => 'Teste User',
    'email' => 'teste@teste.com',
    'senha' => \Illuminate\Support\Facades\Hash::make('123456')
]);
echo 'Usuário criado: teste@teste.com / 123456';
"@

php artisan tinker --execute="$createUser"

Write-Host ""
Write-Host "SETUP CONCLUÍDO COM SUCESSO!" -ForegroundColor Green
Write-Host "============================" -ForegroundColor Green
Write-Host ""
Write-Host "Para iniciar o servidor:" -ForegroundColor Cyan
Write-Host "   php artisan serve" -ForegroundColor White
Write-Host ""
Write-Host "Credenciais de teste:" -ForegroundColor Cyan
Write-Host "   Email: teste@teste.com" -ForegroundColor White
Write-Host "   Senha: 123456" -ForegroundColor White
Write-Host ""
Write-Host "Acesse: http://127.0.0.1:8000" -ForegroundColor Cyan
Write-Host ""
