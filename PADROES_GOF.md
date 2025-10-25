# Padrões de Projeto GoF Implementados - Sistema Agape

Este documento descreve os padrões de projeto Gang of Four (GoF) implementados no sistema de gerenciamento de estoque Agape.

## 📚 O que são Padrões GoF?

**GoF** significa "Gang of Four" (Gangue dos Quatro), referência aos autores do livro clássico "Design Patterns: Elements of Reusable Object-Oriented Software" (1994): Erich Gamma, Richard Helm, Ralph Johnson e John Vlissides.

Eles catalogaram 23 padrões de projeto divididos em três categorias:
- **Criacionais**: Singleton, Factory, Abstract Factory, Builder, Prototype
- **Estruturais**: Adapter, Bridge, Composite, Decorator, Facade, Flyweight, Proxy
- **Comportamentais**: Chain of Responsibility, Command, Iterator, Mediator, Memento, Observer, State, Strategy, Template Method, Visitor

---

## 1. 🔐 Singleton Pattern (Criacional)

**Localização**: Implementado nativamente pelo Laravel através do Service Container

### Descrição
O padrão Singleton garante que uma classe tenha apenas uma única instância e fornece um ponto de acesso global a ela.

### Implementação no Projeto
O Laravel implementa o Singleton automaticamente para:
- **Conexão com Banco de Dados**: `DB::connection()` sempre retorna a mesma instância
- **Service Container**: O próprio container Laravel é um Singleton
- **Facades**: Como `Auth`, `Storage`, `Hash` são Singletons gerenciados pelo container

**Exemplo no código**:
```php
// Em qualquer parte do código, sempre a mesma instância
$db = DB::connection(); // Instância única da conexão
$auth = Auth::user(); // Sempre o mesmo gerenciador de autenticação
```

### Justificativa
- **Performance**: Evita criar múltiplas conexões com o banco de dados
- **Consistência**: Garante que todos os componentes usem a mesma conexão
- **Economia de Recursos**: Uma única instância consome menos memória

### Onde é Aplicado
- `config/database.php` - Configuração da conexão única
- Toda vez que usamos `DB::`, `Auth::`, `Storage::` estamos usando Singletons

---

## 2. 🏗️ Repository Pattern (Estrutural)

**Localização**: `app/Repositories/`

### Descrição
O Repository Pattern atua como uma camada de abstração entre a lógica de negócio e o acesso aos dados. É semelhante ao padrão **Facade** do GoF, pois fornece uma interface simplificada para um subsistema complexo.

### Implementação no Projeto

**Interface (Contrato)**:
```php
// app/Repositories/ProdutoRepositoryInterface.php
interface ProdutoRepositoryInterface
{
    public function all();
    public function create(array $data);
    public function find($id);
    public function update($id, array $data);
    public function delete($id);
    public function findByUser($userId);
}
```

**Implementação Concreta**:
```php
// app/Repositories/ProdutoRepository.php
class ProdutoRepository implements ProdutoRepositoryInterface
{
    protected $model;

    public function __construct(Produto $model)
    {
        $this->model = $model;
    }

    public function findByUser($userId)
    {
        return $this->model->where('user_id', $userId)->get();
    }
    // ... outros métodos
}
```

**Uso no Controller**:
```php
// app/Http/Controllers/ProdutoController.php
class ProdutoController extends Controller
{
    protected $produtoRepository;

    public function __construct(ProdutoRepositoryInterface $produtoRepository)
    {
        $this->produtoRepository = $produtoRepository;
    }

    public function index()
    {
        $produtos = $this->produtoRepository->findByUser(Auth::id());
        // ...
    }
}
```

### Justificativa
- **Desacoplamento**: Controllers não dependem diretamente dos Models
- **Testabilidade**: Fácil mockar repositories em testes
- **Manutenibilidade**: Mudanças na camada de dados não afetam controllers
- **Reutilização**: Mesma lógica de acesso pode ser usada em múltiplos lugares

### Onde é Aplicado
- `ProdutoRepository` - Gerenciamento de produtos do estoque
- `AuthRepository` - Lógica de autenticação
- Registrado em `app/Providers/RepositoryServiceProvider.php`

---

## 3. 💉 Dependency Injection + Service Container (Comportamental)

**Localização**: Todo o projeto (padrão do Laravel)

### Descrição
Dependency Injection é uma aplicação do padrão **Strategy** do GoF, onde dependências são fornecidas externamente ao invés de serem criadas internamente.

### Implementação no Projeto

**Service Provider (Binding)**:
```php
// app/Providers/RepositoryServiceProvider.php
class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            AuthRepositoryInterface::class, 
            EloquentAuthRepository::class
        );
        $this->app->bind(
            ProdutoRepositoryInterface::class, 
            ProdutoRepository::class
        );
    }
}
```

**Injeção no Construtor**:
```php
// app/Http/Controllers/ProdutoController.php
class ProdutoController extends Controller
{
    public function __construct(
        ProdutoRepositoryInterface $produtoRepository, 
        AuditoriaService $auditoriaService
    ) {
        $this->produtoRepository = $produtoRepository;
        $this->auditoriaService = $auditoriaService;
    }
}
```

### Justificativa
- **Flexibilidade**: Fácil trocar implementações sem modificar código
- **Testabilidade**: Pode injetar mocks/stubs em testes
- **Inversão de Controle**: Classes não criam suas dependências
- **Baixo Acoplamento**: Depende de abstrações, não de implementações concretas

### Onde é Aplicado
- Todos os Controllers recebem dependências via construtor
- Services são injetados automaticamente pelo container
- Configurado em `app/Providers/`

---

## 4. 🎭 Facade Pattern (Estrutural)

**Localização**: `app/Services/AuditoriaService.php`

### Descrição
O Facade fornece uma interface simplificada para um subsistema complexo. No nosso caso, o `AuditoriaService` encapsula toda a complexidade de registrar auditorias.

### Implementação no Projeto

**Service (Facade)**:
```php
// app/Services/AuditoriaService.php
class AuditoriaService
{
    public function registrarCriacao($produtoId, $observacoes = null)
    {
        $this->registrarOperacao(
            $produtoId, 
            'criacao', 
            null, null, null, 
            $observacoes ?? 'Item criado no estoque'
        );
    }

    public function registrarAtualizacao($produtoId, $campoAlterado, $valorAnterior, $valorNovo, $observacoes = null)
    {
        $this->registrarOperacao(
            $produtoId, 
            'atualizacao', 
            $campoAlterado, 
            $valorAnterior, 
            $valorNovo, 
            $observacoes
        );
    }

    public function registrarExclusao($produtoId, $observacoes = null)
    {
        $this->registrarOperacao(
            $produtoId, 
            'exclusao', 
            null, null, null, 
            $observacoes ?? 'Item removido do estoque'
        );
    }

    private function registrarOperacao($produtoId, $tipo, $campo, $anterior, $novo, $obs)
    {
        // Lógica complexa encapsulada
        EstoqueAuditoria::create([
            'produto_id' => $produtoId,
            'user_id' => Auth::id(),
            'tipo_operacao' => $tipo,
            'campo_alterado' => $campo,
            'valor_anterior' => $anterior,
            'valor_novo' => $novo,
            'ip_usuario' => request()->ip(),
            'observacoes' => $obs
        ]);
    }
}
```

**Uso Simplificado**:
```php
// app/Http/Controllers/ProdutoController.php
public function store(Request $request)
{
    $produto = $this->produtoRepository->create($data);
    
    // Uso simples da facade - complexidade escondida
    $this->auditoriaService->registrarCriacao(
        $produto->id, 
        'Produto criado: ' . $produto->nome_item
    );
}
```

### Justificativa
- **Simplicidade**: Interface simples para operações complexas
- **Encapsulamento**: Detalhes de implementação ficam ocultos
- **Manutenibilidade**: Mudanças na lógica de auditoria ficam centralizadas
- **Reutilização**: Mesma interface usada em toda aplicação

### Onde é Aplicado
- `AuditoriaService` - Registra todas as operações de auditoria
- Usado em `ProdutoController`, `TransferenciaController`

---

## 5. 🎨 Strategy Pattern (Comportamental)

**Localização**: Autenticação com múltiplas estratégias

### Descrição
O Strategy define uma família de algoritmos, encapsula cada um deles e os torna intercambiáveis.

### Implementação no Projeto

**Interface de Estratégia**:
```php
// app/Repositories/AuthRepositoryInterface.php
interface AuthRepositoryInterface
{
    public function attemptLogin(string $email, string $password): bool;
    public function logout(): void;
}
```

**Estratégias Concretas**:
```php
// app/Repositories/EloquentAuthRepository.php
class EloquentAuthRepository implements AuthRepositoryInterface
{
    public function attemptLogin(string $email, string $password): bool
    {
        return Auth::attempt(['email' => $email, 'password' => $password]);
    }
}

// app/Repositories/AuthRepository.php
class AuthRepository implements AuthRepositoryInterface
{
    public function attemptLogin(string $email, string $password): bool
    {
        $cliente = Cliente::where('email', $email)->first();
        
        if (!$cliente) return false;
        
        if (Hash::check($password, $cliente->senha)) {
            Auth::login($cliente);
            return true;
        }
        
        return false;
    }
}
```

**Contexto (Uso)**:
```php
// app/Http/Controllers/AuthController.php
class AuthController extends Controller
{
    public function __construct(private AuthRepositoryInterface $auth)
    {
        // A estratégia correta é injetada pelo Service Container
    }

    public function login(Request $request)
    {
        if ($this->auth->attemptLogin($credentials['email'], $credentials['password'])) {
            // Login bem-sucedido
        }
    }
}
```

### Justificativa
- **Flexibilidade**: Fácil adicionar novas estratégias de autenticação
- **Manutenibilidade**: Cada estratégia é independente
- **Open/Closed Principle**: Aberto para extensão, fechado para modificação
- **Testabilidade**: Cada estratégia pode ser testada isoladamente

### Onde é Aplicado
- Sistema de autenticação com múltiplas estratégias
- Configuração em `RepositoryServiceProvider.php`

---

## 📊 Resumo dos Padrões Implementados

| Padrão | Categoria | Localização | Propósito |
|--------|-----------|-------------|-----------|
| **Singleton** | Criacional | Laravel Service Container | Instância única de conexão DB |
| **Repository** | Estrutural (similar Facade) | `app/Repositories/` | Abstração de acesso a dados |
| **Dependency Injection** | Comportamental (Strategy) | Todo o projeto | Inversão de controle |
| **Facade** | Estrutural | `app/Services/AuditoriaService.php` | Interface simplificada |
| **Strategy** | Comportamental | Sistema de Autenticação | Algoritmos intercambiáveis |

---

## 🎯 Benefícios da Aplicação dos Padrões

1. **Manutenibilidade**: Código organizado e fácil de modificar
2. **Testabilidade**: Componentes podem ser testados isoladamente
3. **Reutilização**: Lógica compartilhada entre diferentes partes do sistema
4. **Escalabilidade**: Fácil adicionar novos recursos sem quebrar código existente
5. **Legibilidade**: Padrões conhecidos facilitam entendimento por novos desenvolvedores

---

## 📝 Conclusão

O sistema Agape implementa **5 padrões GoF** (incluindo Singleton) de forma efetiva, demonstrando boas práticas de engenharia de software. A arquitetura está alinhada com princípios SOLID e facilita a manutenção e evolução do sistema.

**Desenvolvido pela equipe Agape - © 2025**
