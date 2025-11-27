# 🎤 ROTEIRO 1 MINUTO - CONTROLE DE TRANSFERÊNCIAS (CÓDIGO)

## ⏱️ TEMPO: 60 SEGUNDOS

---

## 📋 ROTEIRO CRONOMETRADO - FOCADO NO CÓDIGO

### **0-10s: VIEW (Blade Template)**

**Abrir arquivo:** `resources/views/transferencias/create.blade.php`

**Falar enquanto mostra o formulário:**

> "O fluxo de transferências começa na **View** com um formulário Blade. Quando o usuário submete, faz POST para a rota `transferencias.store`."

**Mostrar rapidamente (destacar):**

```blade
<form action="{{ route('transferencias.store') }}" method="POST">
    <select name="produto_id">...</select>
    <input name="localidade_destino">
    <input name="responsavel_destino">
    <select name="motivo">
        <option value="Venda">Venda</option>
    </select>
</form>
```

---

### **10-20s: ROTA → CONTROLLER**

**Abrir arquivo:** `routes/web.php`

**Falar:**

> "A **rota** direciona para o **Controller**."

**Mostrar:**

```php
Route::post('/', [TransferenciaController::class, 'store'])
```

**Mudar para:** `app/Http/Controllers/TransferenciaController.php`

**Falar:**

> "O **Controller** valida e delega para o **Service**."

**Mostrar método `store()`:**

```php
public function store(Request $request)
{
    $request->validate([...]);
    $this->transferenciaService->criarTransferencia($request->all());
    return redirect()->route('transferencias.index');
}
```

---

### **20-40s: SERVICE (Lógica de Negócio)**

**Abrir arquivo:** `app/Services/TransferenciaService.php`

**Falar:**

> "Aqui está a **Service Layer** com toda a lógica de negócio."

**Mostrar método `criarTransferencia()` e destacar partes principais:**

**1. Validação (linha ~35):**

```php
$produto = Produto::findOrFail($dados['produto_id']);
if ($produto->user_id != Auth::id()) {
    throw new \Exception('Produto não encontrado.');
}
```

**Falar:** "Valida permissões..."

**2. Criação (linha ~43):**

```php
$transferencia = Transferencia::create([
    'produto_id' => $dados['produto_id'],
    'localidade_destino' => $dados['localidade_destino'],
    'status' => 'pendente',
]);
```

**Falar:** "Cria a transferência no banco..."

**3. Auditoria (linha ~58):**

```php
$this->auditoriaService->registrarTransferencia(
    $produto->id,
    $produto->localidade,
    $dados['localidade_destino']
);
```

**Falar:** "E registra na auditoria usando o padrão **Facade**."

---

### **40-50s: MODEL (Active Record)**

**Abrir arquivo:** `app/Models/Transferencia.php`

**Falar:**

> "O **Model** define os **relacionamentos** e **métodos de negócio**."

**Mostrar rapidamente:**

**Relacionamentos:**

```php
public function produto() {
    return $this->belongsTo(Produto::class);
}
```

**Métodos de status:**

```php
public function iniciarTransferencia() {
    $this->update([
        'status' => 'em_transito',
        'codigo_rastreamento' => 'TR' . uniqid()
    ]);
}
```

**Falar:** "Aqui temos os métodos que mudam o status: iniciar, concluir, cancelar."

---

### **50-60s: REPOSITORY (Padrão GoF)**

**Abrir arquivo:** `app/Repositories/ProdutoRepository.php`

**Falar:**

> "Usamos o padrão **Repository** para abstrair o acesso ao banco."

**Mostrar implementação (trecho relevante):**

```php
public function findByUser($userId)
{
    return $this->model
        ->where('user_id', $userId)
        ->whereDoesntHave('transferencias', function ($q) use ($userId) {
            $q->where('user_id', $userId)
              ->where(function ($q2) {
                  $q2->whereIn('status', ['em_transito'])
                     ->orWhere(function ($q3) {
                         $q3->where('status', 'concluida')
                            ->where('motivo', 'Venda');
                     });
              });
        })
        ->get();
}
```

**Falar:**

> "Isso implementa o **Repository Pattern** e aplica regra de negócio na consulta: produtos em **transferência ativa** ou **vendidos** não aparecem nas listagens. **Fluxo**: View → Rota → Controller → Service → Model → Repository. Obrigado!"

---

## 🎯 PREPARAÇÃO PRÉ-APRESENTAÇÃO

### **Abrir ANTES no VS Code (em ordem):**

1. **Aba 1:** `resources/views/transferencias/create.blade.php`

    - Formulário visível (linhas 1-30)

2. **Aba 2:** `routes/web.php`

    - Seção de transferências visível (linha ~58)

3. **Aba 3:** `app/Http/Controllers/TransferenciaController.php`

    - Método `store()` visível (linha ~30)

4. **Aba 4:** `app/Services/TransferenciaService.php`

    - Método `criarTransferencia()` visível (linha ~35)
    - **PRINCIPAL - Vai passar mais tempo aqui**

5. **Aba 5:** `app/Models/Transferencia.php`

    - Métodos `iniciarTransferencia()` e relacionamentos visíveis

6. **Aba 6:** `app/Repositories/ProdutoRepository.php`
    - Interface e implementação visíveis

### **Ordem de navegação:**

-   Use **Ctrl+Tab** para alternar entre abas rapidamente
-   Ou clique nas abas em sequência (1→2→3→4→5→6)

### **Cronômetro:** Pratique 3-5 vezes antes!

---

## ⚡ DICAS PARA 60 SEGUNDOS

### **✅ FAZER:**

-   Falar RÁPIDO mas CLARO
-   **Apontar com o cursor do mouse** nas linhas importantes
-   Alternar abas rapidamente (Ctrl+Tab ou clique)
-   **Destacar código-chave** com mouse/cursor
-   Conectar cada arquivo: "isso chama isso, que chama isso"
-   Mencionar **padrões de projeto** (Repository, Facade, MVC)

### **❌ EVITAR:**

-   Ler código linha por linha
-   Pausar para explicar detalhes
-   Rolar muito a tela (ter código já visível)
-   Ficar muito tempo em um arquivo
-   Esquecer de mencionar o fluxo completo

---

## 📝 SCRIPT COMPLETO (OPCIONAL - Decorar)

**Palavra por palavra:**

> "[ABRIR VIEW] O fluxo de transferências começa na View com formulário Blade. Faz POST para a rota transferencias.store. [ABRIR ROTA] A rota direciona para o Controller. [ABRIR CONTROLLER] O Controller valida e delega para o Service. [ABRIR SERVICE - DEMORAR AQUI] Aqui está a Service Layer com toda a lógica de negócio. Valida permissões, cria a transferência no banco com status pendente, e registra na auditoria usando o padrão Facade. [ABRIR MODEL] O Model define relacionamentos e métodos de negócio: iniciar, concluir, cancelar transferência. [ABRIR REPOSITORY] Usamos o Repository Pattern para abstrair o banco de dados, desacoplando lógica de negócio. Fluxo completo: View-Rota-Controller-Service-Model-Repository. Obrigado!"

---

## ⏲️ TIMING EXATO - CÓDIGO

| Tempo  | Ação                            | Arquivo                                   |
| ------ | ------------------------------- | ----------------------------------------- |
| 0-10s  | Mostrar View (formulário)       | `create.blade.php`                        |
| 10-20s | Mostrar Rota + Controller       | `web.php` + `TransferenciaController.php` |
| 20-40s | **Mostrar Service (PRINCIPAL)** | `TransferenciaService.php`                |
| 40-50s | Mostrar Model (relacionamentos) | `Transferencia.php`                       |
| 50-60s | Mostrar Repository + Finalizar  | `ProdutoRepository.php`                   |

---

## 🎬 ENSAIO RECOMENDADO

**Pratique 5 vezes seguidas com cronômetro!**

1. **Ensaio 1:** Vai passar do tempo (normal)
2. **Ensaio 2:** Ajuste onde ficou lento
3. **Ensaio 3:** Fale mais rápido nas partes decoradas
4. **Ensaio 4:** Só gestos e cliques, sem falar (verificar sequência)
5. **Ensaio 5:** Completo com cronômetro (deve ficar em 55-60s)

---

**Boa apresentação! 🚀**
