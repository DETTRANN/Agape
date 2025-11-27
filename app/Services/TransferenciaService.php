<?php

namespace App\Services;

use App\Models\Transferencia;
use App\Models\Produto;
use Illuminate\Support\Facades\Auth;

class TransferenciaService
{
    protected $auditoriaService;

    public function __construct(AuditoriaService $auditoriaService)
    {
        $this->auditoriaService = $auditoriaService;
    }

    /**
     * Busca transferências do usuário autenticado com paginação
     */
    public function buscarTransferenciasDoUsuario(int $perPage = 20)
    {
        return Transferencia::where('user_id', Auth::id())
            ->with(['produto'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Calcula estatísticas das transferências do usuário
     */
    public function calcularEstatisticasDoUsuario(): array
    {
        $userId = Auth::id();
        
        return [
            'pendentes' => Transferencia::porUsuario($userId)->pendentes()->count(),
            'em_transito' => Transferencia::porUsuario($userId)->emTransito()->count(),
            'concluidas' => Transferencia::porUsuario($userId)->concluidas()->count(),
        ];
    }

    /**
     * Busca produtos disponíveis para transferência
     */
    public function buscarProdutosDisponiveis()
    {
        return Produto::where('user_id', Auth::id())
            ->where('status', 'Disponível')
            ->whereDoesntHave('transferencias', function ($q) {
                $q->whereIn('status', ['pendente', 'em_transito', 'concluida']);
            })
            ->get();
    }

    /**
     * Cria uma nova transferência
     */
    public function criarTransferencia(array $dados): Transferencia
    {
        $produto = Produto::findOrFail($dados['produto_id']);

        // Verificar se o produto pertence ao usuário
        if ($produto->user_id != Auth::id()) {
            throw new \Exception('Produto não encontrado.');
        }

        // Bloquear venda de produtos vencidos
        if (($dados['motivo'] ?? null) === 'Venda' && $produto->status === 'Vencido') {
            throw new \Exception('Não é possível vender produtos vencidos. Use o motivo "Produto Vencido" para descarte.');
        }

        // Criar transferência
        $transferencia = Transferencia::create([
            'produto_id' => $dados['produto_id'],
            'user_id' => Auth::id(),
            'localidade_origem' => $produto->localidade ?? 'Não informado',
            'localidade_destino' => $dados['localidade_destino'],
            'responsavel_origem' => $produto->responsavel,
            'responsavel_destino' => $dados['responsavel_destino'],
            'data_solicitacao' => now(),
            'motivo' => $dados['motivo'] ?? null,
            'observacoes' => $dados['observacoes'] ?? null,
        ]);

        // Processar venda se necessário
        if (($dados['motivo'] ?? null) === 'Venda') {
            $this->processarVenda($produto, $transferencia->id);
        }

        // Registrar auditoria
        $this->auditoriaService->registrarTransferencia(
            $produto->id,
            $produto->localidade ?? 'Não informado',
            $dados['localidade_destino'],
            'Transferência solicitada - ' . ($dados['motivo'] ?? 'Sem motivo especificado')
        );

        return $transferencia;
    }

    /**
     * Processa a lógica de venda
     */
    private function processarVenda(Produto $produto, int $transferenciaId): void
    {
        $produto->update(['status' => 'Ocupado']);
        
        $this->auditoriaService->registrarAtualizacao(
            $produto->id,
            'status',
            'Disponível',
            'Ocupado',
            'Produto vendido - Transferência ID: ' . $transferenciaId
        );
    }

    /**
     * Inicia uma transferência
     */
    public function iniciarTransferencia(int $id): array
    {
        $transferencia = $this->buscarTransferenciaDoUsuario($id);

        if ($transferencia->status !== 'pendente') {
            throw new \Exception('Apenas transferências pendentes podem ser iniciadas.');
        }

        $transferencia->iniciarTransferencia();

        $this->auditoriaService->registrarAtualizacao(
            $transferencia->produto_id,
            'status_transferencia',
            'pendente',
            'em_transito',
            'Transferência iniciada - Código: ' . $transferencia->codigo_rastreamento
        );

        return [
            'success' => true,
            'message' => 'Transferência iniciada! Código de rastreamento: ' . $transferencia->codigo_rastreamento
        ];
    }

    /**
     * Conclui uma transferência
     */
    public function concluirTransferencia(int $id): array
    {
        $transferencia = $this->buscarTransferenciaDoUsuario($id);

        if ($transferencia->status !== 'em_transito') {
            throw new \Exception('Apenas transferências em trânsito podem ser concluídas.');
        }

        $transferencia->concluirTransferencia();

        $this->auditoriaService->registrarAtualizacao(
            $transferencia->produto_id,
            'status_transferencia',
            'em_transito',
            'concluida',
            'Transferência concluída - Produto agora em: ' . $transferencia->localidade_destino
        );

        return [
            'success' => true,
            'message' => 'Transferência concluída com sucesso!'
        ];
    }

    /**
     * Cancela uma transferência
     */
    public function cancelarTransferencia(int $id, ?string $motivo = null): array
    {
        $transferencia = $this->buscarTransferenciaDoUsuario($id);

        if (in_array($transferencia->status, ['concluida', 'cancelada'])) {
            throw new \Exception('Esta transferência não pode ser cancelada.');
        }

        $statusAnterior = $transferencia->status;
        $transferencia->cancelarTransferencia($motivo);

        $this->auditoriaService->registrarAtualizacao(
            $transferencia->produto_id,
            'status_transferencia',
            $statusAnterior,
            'cancelada',
            'Transferência cancelada - ' . ($motivo ?? 'Sem motivo especificado')
        );

        return [
            'success' => true,
            'message' => 'Transferência cancelada.'
        ];
    }

    /**
     * Busca uma transferência específica do usuário
     */
    public function buscarTransferenciaDoUsuario(int $id): Transferencia
    {
        return Transferencia::where('user_id', Auth::id())
            ->with(['produto'])
            ->findOrFail($id);
    }
}
