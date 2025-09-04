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

-   **Sistema completo de autenticação** - Login, cadastro e proteção de rotas
-   **Gestão de estoque** - CRUD de produtos com interface responsiva
-   **Notificações em tempo real** - Alertas visuais e sistema de badges
-   **Reset de senha** - Recuperação via email
-   **Design responsivo** - Interface otimizada para desktop e mobile
-   **Formulário de contato** - Integração com FormSubmit

## Tecnologias Utilizadas

-   **Laravel 12.x** - Framework PHP moderno
-   **PHP 8.2+** - Linguagem server-side
-   **SQLite** - Banco de dados leve
-   **HTML5, CSS3, JavaScript** - Frontend responsivo
-   **Vite** - Build tool para assets
-   **Composer** - Gerenciador de dependências PHP

## Estrutura do Projeto

```
agape-laravel/
├── app/
│   ├── Http/Controllers/         # Controladores (Auth, Cliente, Produto)
│   ├── Models/                   # Modelos (Cliente, Produto)
│   ├── Repositories/             # Padrão Repository para organização
│   └── Providers/                # Service Providers
├── database/
│   ├── migrations/               # Estrutura do banco
│   └── database.sqlite           # Banco SQLite
├── public/frontend/              # CSS, JS e imagens otimizados
├── resources/views/              # Templates das páginas
├── routes/web.php                # Rotas da aplicação
└── SETUP_COMMANDS.md             # Guia de configuração
```

````
## Instalação e Configuração

### Pré-requisitos

-   PHP 8.2 ou superior
-   Composer
-   Node.js e npm (para compilar assets frontend)
-   SQLite (geralmente já incluído no PHP)
-   Git

### IMPORTANTE - SETUP COMPLETO PARA NOVOS DESENVOLVEDORES

**Se você está clonando o projeto pela primeira vez ou após atualizações importantes, siga os passos abaixo:**

#### 1. **Clone e Configure o Projeto**

```powershell
# Clone o repositório
git clone https://github.com/DETTRANN/Agape.git
cd Agape

# Instale as dependências PHP
composer install

# Instale as dependências frontend e compile os assets
npm install && npm run build

# Configure o arquivo de ambiente (Windows)
copy .env.example .env

# Gere a chave da aplicação
php artisan key:generate
```

#### 2. **Configure o Banco de Dados**

```powershell
# Criar o banco SQLite
New-Item -Path "database/database.sqlite" -ItemType File -Force

# Rodar as migrações
php artisan migrate

# Se der erro na migração, delete o banco e recrie:
Remove-Item "database/database.sqlite" -Force
New-Item -Path "database/database.sqlite" -ItemType File -Force
php artisan migrate
```

#### 3. **Limpar Todos os Caches e Registrar Providers**

```powershell
# Limpar TODOS os caches do Laravel
php artisan config:clear
php artisan route:clear
php artisan cache:clear
php artisan view:clear

# Verificar se os Service Providers estão registrados
php artisan about

# Recriar caches otimizados
php artisan config:cache
php artisan route:cache
```

#### 4. **Criar Usuário de Teste (Opcional)**

```powershell
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

#### 5. **Iniciar o Servidor e Verificar**

```powershell
# OPÇÃO 1 (Recomendada): Rodar o ambiente completo de desenvolvimento
# Isto iniciará: servidor Laravel + processamento de filas + logs + Vite dev server
composer run dev

# OPÇÃO 2 (Alternativa): Iniciar apenas o servidor Laravel
php artisan serve

# O sistema estará disponível em:
# http://127.0.0.1:8000

# Para verificar se está tudo funcionando:
# 1. Acesse http://127.0.0.1:8000 - deve mostrar a página inicial
# 2. Acesse http://127.0.0.1:8000/login - deve mostrar a página de login
# 3. Acesse http://127.0.0.1:8000/register - deve mostrar a página de cadastro
```

### **Diferença entre as opções:**

-   **`composer run dev`**: Ambiente completo com hot reload de CSS/JS, logs em tempo real e processamento de filas
-   **`php artisan serve`**: Apenas o servidor web Laravel básico

### **Verificação Final**

Antes de usar o sistema, certifique-se de que:

1. O servidor Laravel está rodando sem erros
2. O banco SQLite foi criado em `database/database.sqlite`
3. As rotas `/login` e `/register` estão acessíveis
4. Não há erros no console do navegador
5. Os assets CSS/JS foram compilados (pasta `public/build/` existe)

### Problemas Comuns e Soluções (Windows)

#### Erro: "SQLSTATE[HY000]: General error: 1 no such table: clientes"

```powershell
# Solução:
Remove-Item "database/database.sqlite" -Force
New-Item -Path "database/database.sqlite" -ItemType File -Force
php artisan migrate
```

#### Erro: "Route [auth.login.form] not defined"

```powershell
php artisan route:clear
php artisan config:clear
php artisan serve
```

#### Erro: "Vite assets not found"

```powershell
npm install
npm run build
php artisan serve
```

#### Login não funciona

```powershell
php artisan cache:clear
# Verificar se há usuários cadastrados
php artisan tinker
# \App\Models\Cliente::all();
```

## Rotas do Sistema

### Rotas Principais

**Públicas:**

-   `/` - Página inicial
-   `/login` - Login
-   `/register` - Cadastro
-   `/views/contato` - Contato

**Protegidas (requer login):**

-   `/system` - Dashboard principal
-   `/views/tabela_estoque` - Gestão de estoque

**API (CRUD de produtos):**

-   `POST /produtos` - Criar produto
-   `PUT /produtos/{id}` - Atualizar produto
-   `DELETE /produtos/{id}` - Excluir produto

## Design Responsivo

Interface otimizada para **desktop** e **dispositivos móveis** com navegação adaptativa.

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
