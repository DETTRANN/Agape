# Agape - Sistema de Gerenciamento de Estoque

## Sobre o Projeto

O **Agape** é um sistema completo de gestão de estoque desenvolvido para simplificar o controle de produtos, oferecendo uma interface intuitiva e funcionalidades robustas para empresas de todos os portes. O sistema proporciona controle total dos produtos, organização eficiente no dia a dia e tomada de decisões mais rápidas e assertivas.

## Objetivos

-   Facilitar o gerenciamento de estoque para pequenas e médias empresas
-   Oferecer uma interface moderna e intuitiva
-   Automatizar processos de controle de entrada e saída
-   Fornecer alertas inteligentes para gestão eficiente
-   Garantir escalabilidade e performance

## Funcionalidades Principais

### Autenticação e Segurança

-   Sistema de cadastro e login de usuários com modelo Cliente personalizado
-   Autenticação segura com validação dupla (middleware auth + force.auth)
-   Sistema de logout funcional
-   Proteção de rotas e sessões
-   Redirecionamento automático para login quando não autenticado

### Gestão de Estoque

-   Controle completo de entrada e saída de produtos
-   Interface de tabela de estoque com design profissional
-   Gerenciamento de quantidades em tempo real
-   Sistema de alertas para estoque baixo
-   Filtros avançados de produtos
-   Gestão integrada de preços

### Interface e Experiência do Usuário

-   Design responsivo mobile-first
-   Header mobile com sidebar deslizante
-   Interface moderna com paleta de cores consistente (gradientes #0a0d1c → #1a1d2e → #2a2d3e)
-   Animações suaves e transições
-   Navegação otimizada para desktop e mobile
-   Sistema de notificações visuais
-   Menu hamburger funcional

### Comunicação

-   Sistema de notificações por email
-   Formulário de contato integrado
-   Alertas automáticos do sistema

## Tecnologias Utilizadas

### Backend

-   **Laravel 12.x** - Framework PHP mais recente e robusto
-   **PHP 8.2+** - Linguagem server-side
-   **SQLite** - Banco de dados leve e eficiente
-   **Composer** - Gerenciador de dependências PHP
-   **Pattern Repository** - Arquitetura de repositórios para melhor organização

### Frontend

-   **HTML5** - Estrutura semântica
-   **CSS3** - Estilização moderna com variáveis CSS e sistema de design profissional
-   **JavaScript ES6+** - Interatividade e dinamismo com performance otimizada
-   **Blade Templates** - Sistema de templates do Laravel
-   **TailwindCSS 4.0** - Framework CSS utilitário

### Ferramentas de Desenvolvimento

-   **Vite 7.x** - Build tool moderna e rápida
-   **Artisan** - CLI do Laravel
-   **Git** - Controle de versão
-   **Concurrently** - Execução paralela de scripts de desenvolvimento

## Estrutura do Projeto

```
agape-laravel/
├── app/
│   ├── Http/
│   │   ├── Controllers/           # Controladores da aplicação
│   │   │   ├── AuthController.php # Controlador de autenticação
│   │   │   └── ClienteController.php
│   │   └── Middleware/           # Middleware personalizado
│   │       └── ForceAuth.php     # Middleware de proteção de rotas
│   ├── Models/                   # Modelos Eloquent
│   │   └── Cliente.php          # Modelo de usuário personalizado
│   ├── Repositories/            # Padrão Repository
│   │   └── AuthRepository.php   # Lógica de autenticação
│   └── Providers/               # Service Providers
├── database/
│   ├── migrations/              # Migrações do banco de dados
│   │   └── 2025_08_31_222826_create_clientes_table.php
│   ├── seeders/                # Seeders para popular dados
│   └── database.sqlite         # Banco de dados SQLite
├── public/
│   └── frontend/
│       ├── css/
│       │   ├── style.css       # Estilos principais
│       │   └── inventory.css   # Estilos da tabela de estoque
│       ├── js/
│       │   └── script.js       # Scripts principais com navegação mobile
│       └── img/                # Imagens e assets
├── resources/
│   └── views/                  # Templates Blade
│       ├── index.blade.php     # Página inicial
│       ├── login.blade.php     # Página de login
│       ├── register.blade.php  # Página de cadastro
│       ├── system.blade.php    # Sistema principal
│       ├── tabela_estoque.blade.php # Tabela de estoque
│       └── contato.blade.php   # Página de contato
├── routes/
│   └── web.php                 # Rotas protegidas e públicas
└── storage/                    # Armazenamento de arquivos
```

## Instalação e Configuração

### Pré-requisitos

-   PHP 8.2 ou superior
-   Composer
-   SQLite (geralmente já incluído no PHP)
-   Git

### IMPORTANTE - SETUP COMPLETO PARA NOVOS DESENVOLVEDORES

**Se você está clonando o projeto pela primeira vez ou após atualizações importantes, siga TODOS os passos abaixo:**

#### 1. **Clone e Configure o Projeto**

```bash
# Clone o repositório
git clone https://github.com/DETTRANN/Agape.git
cd Agape

# Instale as dependências PHP
composer install

# Configure o arquivo de ambiente
cp .env.example .env
php artisan key:generate
```

#### 2. **Configure o Banco de Dados**

```bash
# Criar o banco SQLite (se não existir)
touch database/database.sqlite

# Rodar as migrações
php artisan migrate

# IMPORTANTE: Se der erro na migração, delete o banco e recrie:
rm database/database.sqlite
touch database/database.sqlite
php artisan migrate

# Criar tabela de clientes manualmente (se necessário)
php artisan tinker
# No tinker, execute:
# \Illuminate\Support\Facades\Schema::create('clientes', function($table) {
#     $table->id();
#     $table->string('nome');
#     $table->string('email')->unique();
#     $table->string('senha');
#     $table->timestamps();
# });
# exit
```

#### 3. **Limpar Todos os Caches**

```bash
# Limpar TODOS os caches do Laravel
php artisan config:clear
php artisan route:clear
php artisan cache:clear
php artisan view:clear

# Recriar caches otimizados
php artisan config:cache
php artisan route:cache
```

#### 4. **Criar Usuário de Teste (Opcional)**

```bash
# Entre no tinker para criar um usuário de teste
php artisan tinker

# Execute no tinker:
# \App\Models\Cliente::create([
#     'nome' => 'Teste User',
#     'email' => 'teste@teste.com',
#     'senha' => \Illuminate\Support\Facades\Hash::make('123456')
# ]);
# exit
```

#### 5. **Iniciar o Servidor**

```bash
# Iniciar o servidor Laravel
php artisan serve

# O sistema estará disponível em:
# http://127.0.0.1:8000
```

### Credenciais de Teste

-   **Email**: teste@teste.com
-   **Senha**: 123456

### Problemas Comuns e Soluções

#### Erro: "SQLSTATE[HY000]: General error: 1 no such table: clientes"

```bash
# Solução:
rm database/database.sqlite
touch database/database.sqlite
php artisan migrate
```

#### Erro: "Route [auth.login.form] not defined"

```bash
# Solução:
php artisan route:clear
php artisan config:clear
```

#### Login não funciona / Aceita qualquer senha

```bash
# Solução:
php artisan cache:clear
# Verificar se o usuário existe na tabela clientes
php artisan tinker
# \App\Models\Cliente::all();
```

#### Páginas protegidas não redirecionam para login

```bash
# Solução:
php artisan config:clear
php artisan route:clear
# Restart do servidor
```

### Funcionalidades Mobile

O sistema possui navegação mobile completa:

-   Header mobile com botão hamburger
-   Sidebar deslizante com overlay
-   Navegação responsiva
-   Design mobile-first

### Sistema de Segurança

O projeto implementa múltiplas camadas de segurança:

-   Middleware `auth` do Laravel
-   Middleware personalizado `ForceAuth`
-   Proteção de rotas sensíveis
-   Redirecionamento automático para login
-   Logout seguro com invalidação de sessão

## Rotas do Sistema

### Rotas Públicas

-   `/` - Página inicial
-   `/login` - Página de login
-   `/register` - Página de cadastro
-   `/views/register` - Cadastro (rota alternativa)

### Rotas Protegidas (Requer Login)

-   `/system` - Sistema principal
-   `/views/tabela_estoque` - Tabela de estoque
-   `/views/system` - Redireciona para /system

### Rotas de Autenticação

-   `POST /login` - Processar login
-   `POST /logout` - Fazer logout
-   `POST /clientes` - Registrar novo cliente

## Responsividade

O sistema foi desenvolvido com abordagem mobile-first, garantindo uma experiência otimizada em:

-   **Mobile**: Dispositivos com largura menor que 768px
-   **Tablet**: Dispositivos entre 768px e 1024px
-   **Desktop**: Dispositivos com largura superior a 1024px

## Checklist de Funcionalidades - Segunda Entrega

-   [x] **Design Intuitivo** - Interface moderna e responsiva
-   [x] **Cadastro e Login** - Sistema completo de autenticação
-   [x] **Redefinição de Senha** - Recovery via email
-   [x] **Notificações por Email** - Sistema integrado de comunicação
-   [x] **Gerenciamento de Estoque** - Modelagem de produtos
-   [x] **Ordem Automática** - Listagem ordenada
-   [x] **Filtragem de Produtos** - Busca e filtros avançados
-   [x] **Gestão de Quantidades** - Controle em tempo real
-   [x] **Alertas de Estoque Baixo** - Notificações automáticas
-   [x] **Gestão de Preços** - Controle financeiro integrado

## Vídeo mostrandos os 10 requisitos funcionando
https://youtu.be/i0mA892Z5-A

## Equipe de Desenvolvimento

| Nome                | Matrícula |
| ------------------- | --------- | 
| **Daniel Heber**    | 12301647  | 
| **Daniel Pereira**  | 12303011  | 
| **Gabriel Dias**    | 12301620  | 
| **Gabriel Lacerda** | 12302457  |
| **Matheus Vieira**  | 12302988  | 

**Turma**: 3E1

## Contato

-   **Email**: agapeinventory@gmail.com
-   **WhatsApp**: (31) 9272-3541
-   **Instagram**: @agape_inventory

---

**Desenvolvido pela equipe Agape - © 2025 Sistema de Gestão de Estoque**
