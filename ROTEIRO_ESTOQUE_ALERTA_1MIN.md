# Roteiro 1 Minuto – Alerta de Estoque Baixo (Código)

**Objetivo:** Mostrar rapidamente como o alerta de estoque baixo é calculado, propagado e exibido na interface.

**0–05s | Requisito**  
Exibir alerta quando a ocupação (itens com status "Ocupado") atingir ou exceder 50% do total de itens do usuário.

**05–15s | Regra de Negócio (Service)**  
Fonte principal: `EstatisticasService::calcularEstatisticasProdutos`.

```php
$itensOcupados = $produtos->where('status', 'Ocupado')->count();
$porcentagemOcupados = ($itensOcupados / $totalItens) * 100;
$estoqueAlerta = $porcentagemOcupados >= 50; // LIMITE ATUAL
```

Retorna também listas de vencidos e próximos do vencimento (não foco aqui).

**15–25s | Acesso aos Dados (Repository/Model)**  
Produtos do usuário são carregados por escopo de `user_id` (Repository ou direto no Service).  
Ex.: `Produto::where('user_id', $userId)->get();` encapsulado em `ProdutoRepository::findByUser($userId)` para manter separação de responsabilidades.

**25–35s | Orquestração (ProdutoService / Controller)**  
`ProdutoService::gerarDadosEstoque()` agrega estatísticas chamando `EstatisticasService`.  
`ProdutoController@index` chama o service e entrega dados à view principal de estoque.

**35–45s | Propagação Global (View Composer)**  
`AppServiceProvider` usa `View::composer('*')` para compartilhar as variáveis com TODAS as views, agora já centralizadas via `EstatisticasService::calcularEstatisticasProdutos($userId)` (DRY).

**45–55s | Exibição (Blade)**  
`tabela_estoque.blade.php` mostra painel condicional:

```blade
@if($estoqueAlerta)
  <div class="notification-item alert-warning">
    <h4>Alerta de Estoque Baixo</h4>
    <p>{{ round($porcentagemOcupados) }}% ocupados ({{ $itensOcupados }}/{{ $totalItens }})</p>
  </div>
@endif
```

Caso contrário, mostra mensagem de “Bom Estado” ou “Estoque Vazio”.

**55–60s | Padrões & Melhorias**

-   Repository: isola consultas de produto.
-   Services: encapsulam regras e reduzem lógica no Controller.
-   DI/Container (singletons): serviços (`EstatisticasService`, `ProdutoService`) são registrados como singleton no IoC do Laravel, garantindo uma instância por request e reduzindo acoplamento. Importante: não há estado global entre requisições.
-   Já centralizado: cálculo do limite de 50% está só no `EstatisticasService`.
-   Tornar o limite configurável (`config/estoque.php` ou `.env`: `ESTOQUE_LIMITE_ALERTA=50`).
-   Teste rápido: criar itens, marcar metade como "Ocupado" e validar transição do estado.

Nota: O `ProdutoRepository::findByUser` filtra itens em transferência ativa (em_transito) e vendidos, então totais e listas refletem apenas itens efetivamente disponíveis/ativos para o usuário.

**Resumo Final:** Regra central (>=50%) vive no Service, é repetida no Provider para disponibilidade global e renderiza no Blade. Ponto-chave: centralizar e parametrizar o limite para manter DRY e permitir ajuste sem código.
