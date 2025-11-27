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
                // Centraliza cálculo nas estatísticas (DRY)
                $estatisticas = app(\App\Services\EstatisticasService::class)
                    ->calcularEstatisticasProdutos($userId ?? 0);

                $view->with([
                    'produtosVencidos' => $estatisticas['produtos_vencidos'] ?? collect(),
                    'produtosProximosVencimento' => $estatisticas['produtos_proximos_vencimento'] ?? collect(),
                    'totalItens' => $estatisticas['total_itens'] ?? 0,
                    'itensOcupados' => $estatisticas['itens_ocupados'] ?? 0,
                    'porcentagemOcupados' => $estatisticas['porcentagem_ocupados'] ?? 0,
                    'estoqueAlerta' => $estatisticas['estoque_alerta'] ?? false,
                ]);
            } catch (\Throwable $e) {
                // Em caso de erro, não interromper renderização; nenhuma variável é compartilhada
            }
        });
    }
}
