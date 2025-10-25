<?php

namespace App\Services;

use App\Models\EstoqueAuditoria;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuditoriaService
{
    public function registrarOperacao($produtoId, $tipoOperacao, $campoAlterado = null, $valorAnterior = null, $valorNovo = null, $observacoes = null)
    {
        try {
            EstoqueAuditoria::create([
                'produto_id' => $produtoId,
                'user_id' => Auth::id(),
                'tipo_operacao' => $tipoOperacao,
                'campo_alterado' => $campoAlterado,
                'valor_anterior' => $valorAnterior,
                'valor_novo' => $valorNovo,
                'ip_usuario' => request()->ip(),
                'observacoes' => $observacoes
            ]);
        } catch (\Exception $e) {
            Log::error('Erro ao registrar auditoria: ' . $e->getMessage());
        }
    }

    public function registrarCriacao($produtoId, $observacoes = null)
    {
        $this->registrarOperacao($produtoId, 'criacao', null, null, null, $observacoes ?? 'Item criado no estoque');
    }

    public function registrarAtualizacao($produtoId, $campoAlterado, $valorAnterior, $valorNovo, $observacoes = null)
    {
        $this->registrarOperacao($produtoId, 'atualizacao', $campoAlterado, $valorAnterior, $valorNovo, $observacoes);
    }

    public function registrarExclusao($produtoId, $observacoes = null)
    {
        $this->registrarOperacao($produtoId, 'exclusao', null, null, null, $observacoes ?? 'Item removido do estoque');
    }

    public function registrarTransferencia($produtoId, $localidadeOrigem, $localidadeDestino, $observacoes = null)
    {
        $this->registrarOperacao(
            $produtoId, 
            'transferencia', 
            'localidade', 
            $localidadeOrigem, 
            $localidadeDestino, 
            $observacoes ?? "Transferência de {$localidadeOrigem} para {$localidadeDestino}"
        );
    }

    public function obterHistoricoProduto($produtoId)
    {
        return EstoqueAuditoria::where('produto_id', $produtoId)
            ->with(['user'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function obterHistoricoUsuario($userId, $limite = 50)
    {
        return EstoqueAuditoria::where('user_id', $userId)
            ->with(['produto', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit($limite)
            ->get();
    }

    public function obterEstatisticasAuditoria($userId)
    {
        $estatisticas = EstoqueAuditoria::where('user_id', $userId)
            ->selectRaw('tipo_operacao, COUNT(*) as total')
            ->groupBy('tipo_operacao')
            ->pluck('total', 'tipo_operacao')
            ->toArray();

        return [
            'criacoes' => $estatisticas['criacao'] ?? 0,
            'atualizacoes' => $estatisticas['atualizacao'] ?? 0,
            'exclusoes' => $estatisticas['exclusao'] ?? 0,
            'transferencias' => $estatisticas['transferencia'] ?? 0,
            'total' => array_sum($estatisticas)
        ];
    }
}
