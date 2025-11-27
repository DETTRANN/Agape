# 🎤 ROTEIRO 1 MINUTO - RELATÓRIOS (CÓDIGO)

## ⏱️ TEMPO: 60 SEGUNDOS

---

## 📋 ROTEIRO CRONOMETRADO - FOCADO NO CÓDIGO

### 0-10s: VIEW (Blade Template)

-   Abrir: `resources/views/relatorios.blade.php`
-   Falar: "A View de Relatórios consome variáveis calculadas no Controller: totais, itens mais valiosos e vendas anuais."
-   Destacar:
    -   `{{ $totalItens }}`, `{{ number_format($valorEstoque, 2, ',', '.') }}`
    -   Bloco "Relatório de Vendas Anuais": `{{ $totalVendasAno }}`, `{{ number_format($valorTotalVendas, 2, ',', '.') }}`, `{{ number_format($mediaValorVenda, 2, ',', '.') }}` e `{{ $produtoMaisVendido['nome'] ?? 'Nenhum' }}`

---

### 10-25s: ROTA → CONTROLLER

-   Abrir: `routes/web.php`
-   Falar: "A rota `/views/relatorios` aponta para `ProdutoController@relatorios`."
-   Mostrar:

```php
Route::get('/views/relatorios', [ProdutoController::class, 'relatorios'])->name('relatorios');
```

-   Abrir: `app/Http/Controllers/ProdutoController.php` (método `relatorios()`)
-   Falar: "O Controller agrega dados do estoque e calcula vendas anuais."

---

### 25-45s: CONTROLLER (Agregação de Dados)

-   Destacar no `relatorios()`:
    -   Produtos do usuário: `findByUser(Auth::id())`
    -   Totais: `count()`, `sum('preco')`, `max('updated_at')`
    -   Vendas do ano (escopo por usuário + relacionamento):

```php
$anoAtual = now()->year;
$vendasAnoAtual = \App\Models\Transferencia::porUsuario(Auth::id())
    ->whereYear('created_at', $anoAtual)
    ->where('motivo', 'Venda')
    ->with('produto')
    ->get();

$totalVendasAno = $vendasAnoAtual->count();
$valorTotalVendas = $vendasAnoAtual->reduce(function($total, $venda) {
    return $total + ($venda->produto ? (float)$venda->produto->preco : 0);
}, 0);
$mediaValorVenda = $totalVendasAno > 0 ? $valorTotalVendas / $totalVendasAno : 0;
```

-   Mais vendido:

```php
$produtoMaisVendido = $vendasAnoAtual
  ->groupBy('produto_id')
  ->map(function($grupo) use ($produtos) {
      $produto = $produtos->firstWhere('id', $grupo->first()->produto_id);
      return ['nome' => $produto ? $produto->nome_item : 'Desconhecido', 'quantidade' => $grupo->count()];
  })
  ->sortByDesc('quantidade')
  ->first();
```

---

### 45-55s: REPOSITORY (Regra de Exclusão)

-   Abrir: `app/Repositories/ProdutoRepository.php`
-   Falar: "O Repository aplica regra para NÃO listar produtos **em transferência** ou **vendidos**."
-   Mostrar:

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

-   Impacto: valores de estoque e itens mais valiosos refletem apenas itens ativos do usuário.

---

### 55-60s: NOTAS & PADRÕES

-   Padrões: MVC + Repository; Services e Composer (estoque/alertas) via IoC Singleton por request.
-   Consistência: vendas anuais somam via relacionamento `produto`; filtros por usuário evitam somas 0.
-   Próximo passo: parametrizar motivos de venda no config e adicionar gráficos em `resources/js`.

---

## 🎯 PREPARAÇÃO PRÉ-APRESENTAÇÃO

-   Abrir abas na ordem: `relatorios.blade.php` → `routes/web.php` → `ProdutoController@relatorios` → `ProdutoRepository`.
-   Deixar trechos visíveis para evitar scroll.
-   Praticar com cronômetro 2–3 vezes.

**Boa apresentação! 🚀**
