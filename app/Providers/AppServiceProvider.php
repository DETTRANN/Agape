<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Repositories\AuthRepositoryInterface;
use App\Repositories\AuthRepository;
use App\Repositories\ProdutoRepositoryInterface;
use App\Models\CategoriaConfiguracao;

class AppServiceProvider extends ServiceProvider
{


public function register(): void
{
    // Registrar Repositories
    $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
    
    // Registrar Services
    $this->app->singleton(\App\Services\TransferenciaService::class);
    $this->app->singleton(\App\Services\EstatisticasService::class);
    $this->app->singleton(\App\Services\AuditoriaService::class);
    $this->app->singleton(\App\Services\ProdutoService::class);
}


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Compartilha dados de notificações do estoque com todas as views
        View::composer('*', function ($view) {
            try {
                $userId = Auth::id();

                // Repositório de produtos (respeita o escopo do usuário)
                $produtoRepository = app(ProdutoRepositoryInterface::class);
                $produtos = $produtoRepository->findByUser($userId) ?? collect();

                // Estatísticas básicas
                $totalItens = $produtos->count();
                $itensOcupados = $produtos->where('status', 'Ocupado')->count();
                $porcentagemOcupados = $totalItens > 0 ? ($itensOcupados / $totalItens) * 100 : 0;
                $estoqueAlerta = $porcentagemOcupados >= 50;

                // Configurações de categorias (dias alerta por categoria)
                $configsCategorias = CategoriaConfiguracao::where('user_id', $userId)
                    ->pluck('dias_alerta_validade', 'nome_categoria')
                    ->toArray();

                // Produtos próximos do vencimento (usa config por categoria; 30 dias padrão; 0 = sem validade)
                $produtosProximosVencimento = $produtos->filter(function ($produto) use ($configsCategorias) {
                    if (!$produto->data_validade) {
                        return false;
                    }
                    $hoje = \Carbon\Carbon::now();
                    $validade = \Carbon\Carbon::parse($produto->data_validade);
                    $diasRestantes = $hoje->diffInDays($validade, false);

                    $diasAlerta = array_key_exists($produto->categoria, $configsCategorias)
                        ? $configsCategorias[$produto->categoria]
                        : 30;

                    if ($diasAlerta === 0) {
                        return false;
                    }

                    return $diasRestantes >= 0 && $diasRestantes <= $diasAlerta;
                });

                // Produtos vencidos
                $produtosVencidos = $produtos->filter(function ($produto) {
                    if (!$produto->data_validade) {
                        return false;
                    }
                    $validade = \Carbon\Carbon::parse($produto->data_validade);
                    return $validade->isPast();
                });

                $view->with([
                    'produtosVencidos' => $produtosVencidos,
                    'produtosProximosVencimento' => $produtosProximosVencimento,
                    'totalItens' => $totalItens,
                    'itensOcupados' => $itensOcupados,
                    'porcentagemOcupados' => $porcentagemOcupados,
                    'estoqueAlerta' => $estoqueAlerta,
                ]);
            } catch (\Throwable $e) {
                // Em caso de erro, não interromper renderização; nenhuma variável é compartilhada
            }
        });
    }
}
