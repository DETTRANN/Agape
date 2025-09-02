# COMANDOS DE SETUP MANUAL - AGAPE

# =================================

## COMANDOS ESSENCIAIS APÓS CLONAR O REPOSITÓRIO

### 1. Instalar dependências

composer install

### 2. Configurar ambiente

cp .env.example .env
php artisan key:generate

### 3. Recriar banco de dados

rm database/database.sqlite # Linux/Mac
del database\database.sqlite # Windows
touch database/database.sqlite # Linux/Mac
New-Item database\database.sqlite # Windows PowerShell

### 4. Executar migrações

php artisan migrate

### 5. Limpar todos os caches

php artisan config:clear
php artisan route:clear
php artisan cache:clear
php artisan view:clear

### 6. Recriar caches (opcional - para produção)

php artisan config:cache
php artisan route:cache

### 7. Criar usuário de teste

php artisan tinker

# No tinker:

\App\Models\Cliente::create(['nome' => 'Teste', 'email' => 'teste@teste.com', 'senha' => \Illuminate\Support\Facades\Hash::make('123456')]);
exit

### 8. Iniciar servidor

php artisan serve

## COMANDOS DE SOLUÇÃO DE PROBLEMAS

### Erro de rota não encontrada

php artisan route:clear
php artisan config:clear

### Erro de tabela não existe

rm database/database.sqlite
touch database/database.sqlite
php artisan migrate

### Login não funciona

php artisan cache:clear
php artisan config:clear

# Verificar usuários existentes:

php artisan tinker
\App\Models\Cliente::all();

### Páginas protegidas não redirecionam

php artisan config:clear
php artisan route:clear

# Restart do servidor (Ctrl+C e depois php artisan serve)

## CREDENCIAIS DE TESTE

Email: teste@teste.com
Senha: 123456

## ESTRUTURA DE AUTENTICAÇÃO

-   Modelo: App\Models\Cliente
-   Middleware: auth + force.auth
-   Rotas protegidas: /system, /views/tabela_estoque
-   Rota de login: /login
-   Logout: POST /logout

## ARQUIVOS IMPORTANTES MODIFICADOS

-   routes/web.php (rotas protegidas)
-   app/Models/Cliente.php (modelo de usuário)
-   app/Http/Controllers/AuthController.php (autenticação)
-   app/Http/Middleware/ForceAuth.php (middleware personalizado)
-   bootstrap/app.php (configuração de middleware)
-   config/auth.php (configuração de autenticação)
-   database/migrations/\*\_create_clientes_table.php (estrutura do banco)
