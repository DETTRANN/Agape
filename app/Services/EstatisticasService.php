<?php

namespace App\Services;

use App\Models\Produto;
use App\Models\Transferencia;

class EstatisticasService
{
    /**
     * Calcula estatísticas dos produtos para o usuário
     */
    public function calcularEstatisticasProdutos(int $userId): array
    {
        // Excluir produtos que estejam em transferência ativa ou concluída
        $produtos = Produto::where('user_id', $userId)
            ->whereDoesntHave('transferencias', function ($q) use ($userId) {
                $q->where('user_id', $userId)
                  ->whereIn('status', ['em_transito', 'concluida']);
            })
            ->get();

        if ($produtos->isEmpty()) {
            return [
                'total_itens' => 0,
                'itens_ocupados' => 0,
                'porcentagem_ocupados' => 0,
                'estoque_alerta' => false,
                'produtos_proximos_vencimento' => collect(),
                'produtos_vencidos' => collect(),
            ];
        }

        $totalItens = $produtos->count();
        $itensOcupados = $produtos->where('status', 'Ocupado')->count();
        $porcentagemOcupados = ($itensOcupados / $totalItens) * 100;
        $estoqueAlerta = $porcentagemOcupados >= 50;

        return [
            'total_itens' => $totalItens,
            'itens_ocupados' => $itensOcupados,
            'porcentagem_ocupados' => $porcentagemOcupados,
            'estoque_alerta' => $estoqueAlerta,
            'produtos_proximos_vencimento' => $this->calcularProdutosProximosVencimento($produtos, $userId),
            'produtos_vencidos' => $this->calcularProdutosVencidos($produtos),
        ];
    }

    /**
     * Calcula estatísticas das transferências para o sistema
     */
    public function calcularEstatisticasTransferencias(int $userId): array
    {
        // Produtos ativos: se existir status 'Ativo' (ou 'ativo'), usa, senão usa total do usuário
        $ativosPossiveis = ['Ativo', 'ativo', 'Disponível', 'Disponivel'];
        $produtosAtivos = Produto::where('user_id', $userId)
            ->whereIn('status', $ativosPossiveis)
            ->count();

        if ($produtosAtivos === 0) {
            $produtosAtivos = Produto::where('user_id', $userId)->count();
        }

        // Transferências ativas: pendente ou em_transito
        $transferenciasAtivas = Transferencia::porUsuario($userId)
            ->whereIn('status', ['pendente', 'em_transito'])
            ->count();

        // Entregas hoje: transferências concluídas hoje
        $entregasHoje = Transferencia::porUsuario($userId)
            ->whereDate('data_conclusao', now()->toDateString())
            ->count();

        return [
            'produtos_ativos' => $produtosAtivos,
            'transferencias_ativas' => $transferenciasAtivas,
            'entregas_hoje' => $entregasHoje,
        ];
    }

    /**
     * Calcula produtos próximos ao vencimento
     */
    private function calcularProdutosProximosVencimento($produtos, int $userId)
    {
        $configsCategorias = \App\Models\CategoriaConfiguracao::where('user_id', $userId)
            ->pluck('dias_alerta_validade', 'nome_categoria')
            ->toArray();

        return $produtos->filter(function($produto) use ($configsCategorias) {
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
                return false; // Configuração "Sem validade"
            }
            
            return $diasRestantes >= 0 && $diasRestantes <= $diasAlerta;
        });
    }

    /**
     * Calcula produtos vencidos
     */
    private function calcularProdutosVencidos($produtos)
    {
        return $produtos->filter(function($produto) {
            if (!$produto->data_validade) {
                return false;
            }
            
            $hoje = \Carbon\Carbon::now();
            $validade = \Carbon\Carbon::parse($produto->data_validade);
            return $validade->isPast();
        });
    }
}
