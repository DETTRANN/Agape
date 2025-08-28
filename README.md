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

-   Sistema de cadastro e login de usuários
-   Autenticação segura com validação
-   Redefinição de senha via email
-   Proteção de rotas e sessões

### Gestão de Estoque

-   Controle completo de entrada e saída de produtos
-   Gerenciamento de quantidades em tempo real
-   Sistema de alertas para estoque baixo
-   Ordem automática de reposição
-   Filtros avançados de produtos
-   Gestão integrada de preços

### Interface e Experiência do Usuário

-   Design responsivo e intuitivo
-   Interface moderna com paleta de cores consistente
-   Animações suaves e transições
-   Navegação otimizada para desktop e mobile
-   Sistema de notificações visuais

### Comunicação

-   Sistema de notificações por email
-   Formulário de contato integrado
-   Alertas automáticos do sistema

## Tecnologias Utilizadas

### Backend

-   **Laravel 11.x** - Framework PHP robusto e moderno
-   **PHP 8.2+** - Linguagem server-side
-   **SQLite** - Banco de dados leve e eficiente
-   **Composer** - Gerenciador de dependências PHP

### Frontend

-   **HTML5** - Estrutura semântica
-   **CSS3** - Estilização moderna com variáveis CSS
-   **JavaScript ES6+** - Interatividade e dinamismo

### Ferramentas de Desenvolvimento

-   **Vite** - Build tool moderna e rápida
-   **Artisan** - CLI do Laravel
-   **Git** - Controle de versão

## Estrutura do Projeto

```
agape-laravel/
├── app/
│   ├── Http/Controllers/     # Controladores da aplicação
│   ├── Models/              # Modelos Eloquent
│   └── Providers/           # Service Providers
├── database/
│   ├── migrations/          # Migrações do banco de dados
│   ├── seeders/            # Seeders para popular dados
│   └── database.sqlite     # Banco de dados SQLite
├── public/
│   └── frontend/
│       ├── css/            # Estilos CSS
│       ├── js/             # Scripts JavaScript
│       └── img/            # Imagens e assets
├── resources/
│   └── views/              # Templates Blade
│       ├── index.blade.php
│       ├── login.blade.php
│       ├── register.blade.php
│       └── contato.blade.php
├── routes/
│   └── web.php             # Rotas da aplicação
└── storage/                # Armazenamento de arquivos
```

## Instalação e Configuração

### Pré-requisitos

-   PHP 8.2 ou superior
-   Composer
-   Node.js 16+ (para build do frontend)

### Passos para Instalação

1. **Clone o repositório**

    ```bash
    git clone https://github.com/DETTRANN/Agape.git
    cd Agape
    ```

2. **Instale as dependências PHP**

    ```bash
    composer install
    ```

3. **Configure o ambiente**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Configure o banco de dados**

    ```bash
    php artisan migrate
    php artisan db:seed
    ```

5. **Instale dependências do frontend**

    ```bash
    npm install
    npm run build
    ```

6. **Inicie o servidor**

    ```bash
    php artisan serve
    ```

7. **Acesse a aplicação**
    ```
    http://localhost:8000
    ```

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
-   [x] **Gerenciamento de Estoque** - Entrada e saída de produtos
-   [x] **Ordem Automática** - Reposição inteligente
-   [x] **Filtragem de Produtos** - Busca e filtros avançados
-   [x] **Gestão de Quantidades** - Controle em tempo real
-   [x] **Alertas de Estoque Baixo** - Notificações automáticas
-   [x] **Gestão de Preços** - Controle financeiro integrado

## Equipe de Desenvolvimento

| Nome                | Matrícula |
| ------------------- | --------- |
| **Daniel Heber**    | 12301647  |
| **Daniel Pereira**  | 12303011  |
| **Gabriel Dias**    | 12301620  |
| **Gabriel Lacerda** | 12302457  |
| **Matheus Vieira**  | 12302988  |

**Turma**: 3E1

## Licença

Este projeto está sob a licença MIT. Consulte o arquivo [LICENSE](LICENSE) para mais detalhes.

## Contato

-   **Email**: agapeinventory@gmail.com
-   **WhatsApp**: (31) 1 2345-6789
-   **Instagram**: @agape_inventory

---

**Desenvolvido pela equipe Agape - © 2024 Sistema de Gestão de Estoque**
