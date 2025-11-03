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

-   **Sistema completo de autenticação** — Login, cadastro e proteção de rotas
-   **Gestão de estoque** — CRUD de produtos e visualização aprimorada
-   **Transferências de Itens** — criação, listagem, mudança de status (pendente, em trânsito, concluída, cancelada)
-   **Auditoria de Estoque** — trilha de alterações com filtros e cabeçalho fixo
-   **Formulário de contato** — Integração com FormSubmit

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

# Instale as dependências frontend
npm install

# Compile os assets (produção)
npm run build

# Configure o arquivo de ambiente
copy .env.example .env

# Gere a chave da aplicação
php artisan key:generate
```

#### 2. **Configure o Banco de Dados**

```powershell
# Criar o banco SQLite
New-Item -Path "database/database.sqlite" -ItemType File -Force

# Rodar as migrações (com seed opcional)
php artisan migrate
# ou
php artisan migrate --seed

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
# OPÇÃO 1 (Recomendada): Rodar o ambiente completo de desenvolvimento (Windows/PowerShell)
# Inicia: servidor Laravel + filas + logs + Vite (hot reload)
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

### Atalho (Windows): Setup automático

Para configurar tudo em um passo no Windows, execute o script:

```powershell
./setup.ps1
```

O script instala dependências, cria o banco SQLite, executa migrações, limpa caches e cria um usuário de teste (teste@teste.com / 123456).

### **Verificação Final**

Antes de usar o sistema, certifique-se de que:

1. O servidor Laravel está rodando sem erros
2. O banco SQLite foi criado em `database/database.sqlite`
3. As rotas `/login` e `/register` estão acessíveis
4. Não há erros no console do navegador
5. Os assets CSS/JS foram compilados (pasta `public/build/` existe)

### Problemas Comuns e Soluções

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

## Páginas e Navegação (Principais)

- Sistema/Dashboard: `/system`
- Estoque: `/views/tabela_estoque`
- Transferências:
	- Listagem: `/transferencias`
	- Criar: `/transferencias/criar`
	- Ver: `/transferencias/{id}`
	- Ações: `PUT /transferencias/{id}/iniciar`, `PUT /transferencias/{id}/concluir`, `PUT /transferencias/{id}/cancelar`
- Auditoria: `/auditoria`
- Relatórios: `/views/relatorios`
- Autenticação: `/login`, `/register`

## Rotas do Sistema (resumo)

Veja as rotas completas com:

```powershell
php artisan route:list
```

Principais rotas estão descritas na seção “Páginas e Navegação”.

## Design Responsivo

Interface otimizada para **desktop** e **dispositivos móveis** com navegação adaptativa.

## Requisitos Funcionais — Terceira Entrega

-   [x] RF01: Localização de mercadoria
-   [x] RF02: Gerenciamento de quantidade no estoque
-   [x] RF03: Gerenciamento de saída de produtos
-   [x] RF04: Controle de validade
-   [x] RF05: Multi usuários 
-   [x] RF06: Histórico de movimentação
-   [x] RF07: Controle da variedade de preços
-   [x] RF08: Ordem automática
-   [x] RF09: O sistema deve registrar todas as alterações no estoque
-   [x] RF10: Integração de vendas
-   [x] RF11: Validação de estoque
-   [x] RF12: Gestão de Preços
-   [x] RF13: Alertas de Estoque Baixo
-   [x] RF14: Controle de Devoluções
-   [x] RF15: Filtragem de produtos
-   [x] RF16: Rastreios
-   [x] RF17: Relatório sobre venda anuais
-   [x] RF18: Ciclo de inventário
-   [x] RF19: Controle de Transferências
-   [x] RF20: Cadastro e login de usuários
-   [x] RF21: Notificações por Email
-   [x] RF22: Redefinição de senha
-   [x] RF23: Design Intuitivo
-   [x] RF24: Gráficos e tabelas de estoque

## Vídeo mostrando os requisitos funcionando

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
