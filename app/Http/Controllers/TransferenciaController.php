<?php

namespace App\Http\Controllers;

use App\Models\Transferencia;
use App\Models\Produto;
use App\Services\AuditoriaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransferenciaController extends Controller
{
    protected $auditoriaService;

    public function __construct(AuditoriaService $auditoriaService)
    {
        $this->auditoriaService = $auditoriaService;
    }

    public function index()
    {
        $transferencias = Transferencia::where('user_id', Auth::id())
            ->with(['produto'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $estatisticas = [
            'pendentes' => Transferencia::porUsuario(Auth::id())->pendentes()->count(),
            'em_transito' => Transferencia::porUsuario(Auth::id())->emTransito()->count(),
            'concluidas' => Transferencia::porUsuario(Auth::id())->concluidas()->count(),
        ];

        return view('transferencias.index', compact('transferencias', 'estatisticas'));
    }

    public function create()
    {
        $produtos = Produto::where('user_id', Auth::id())
            ->where('status', 'Disponível')
            ->get();

        return view('transferencias.create', compact('produtos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'produto_id' => 'required|exists:produtos,id',
            'localidade_destino' => 'required|string|max:255',
            'responsavel_destino' => 'required|email',
            'motivo' => 'nullable|string',
            'observacoes' => 'nullable|string',
        ]);

        // Obter produto
        $produto = Produto::findOrFail($request->produto_id);

        // Verificar se o produto pertence ao usuário
        if ($produto->user_id != Auth::id()) {
            return redirect()->back()->with('error', 'Produto não encontrado.');
        }

        // Criar transferência
        $transferencia = Transferencia::create([
            'produto_id' => $request->produto_id,
            'user_id' => Auth::id(),
            'localidade_origem' => $produto->localidade ?? 'Não informado',
            'localidade_destino' => $request->localidade_destino,
            'responsavel_origem' => $produto->responsavel,
            'responsavel_destino' => $request->responsavel_destino,
            'data_solicitacao' => now(),
            'motivo' => $request->motivo,
            'observacoes' => $request->observacoes,
        ]);

        // Se o motivo for "Venda", marcar produto como "Ocupado"
        if ($request->motivo === 'Venda') {
            $produto->update(['status' => 'Ocupado']);
            
            // Registrar auditoria da venda
            $this->auditoriaService->registrarAtualizacao(
                $produto->id,
                'status',
                'Disponível',
                'Ocupado',
                'Produto vendido - Transferência ID: ' . $transferencia->id
            );
        }

        // Registrar auditoria
        $this->auditoriaService->registrarTransferencia(
            $produto->id,
            $produto->localidade ?? 'Não informado',
            $request->localidade_destino,
            'Transferência solicitada - ' . ($request->motivo ?? 'Sem motivo especificado')
        );

        return redirect()->route('transferencias.index')
            ->with('success', 'Transferência solicitada com sucesso!');
    }

    public function show($id)
    {
        $transferencia = Transferencia::where('user_id', Auth::id())
            ->with(['produto'])
            ->findOrFail($id);

        return view('transferencias.show', compact('transferencia'));
    }

    public function iniciarTransferencia($id)
    {
        $transferencia = Transferencia::where('user_id', Auth::id())
            ->findOrFail($id);

        if ($transferencia->status !== 'pendente') {
            return redirect()->back()->with('error', 'Apenas transferências pendentes podem ser iniciadas.');
        }

        $transferencia->iniciarTransferencia();

        // Registrar auditoria
        $this->auditoriaService->registrarAtualizacao(
            $transferencia->produto_id,
            'status_transferencia',
            'pendente',
            'em_transito',
            'Transferência iniciada - Código: ' . $transferencia->codigo_rastreamento
        );

        return redirect()->back()->with('success', 'Transferência iniciada! Código de rastreamento: ' . $transferencia->codigo_rastreamento);
    }

    public function concluirTransferencia($id)
    {
        $transferencia = Transferencia::where('user_id', Auth::id())
            ->findOrFail($id);

        if ($transferencia->status !== 'em_transito') {
            return redirect()->back()->with('error', 'Apenas transferências em trânsito podem ser concluídas.');
        }

        $transferencia->concluirTransferencia();

        // Registrar auditoria
        $this->auditoriaService->registrarAtualizacao(
            $transferencia->produto_id,
            'status_transferencia',
            'em_transito',
            'concluida',
            'Transferência concluída - Produto agora em: ' . $transferencia->localidade_destino
        );

        return redirect()->back()->with('success', 'Transferência concluída com sucesso!');
    }

    public function cancelarTransferencia(Request $request, $id)
    {
        $transferencia = Transferencia::where('user_id', Auth::id())
            ->findOrFail($id);

        if (in_array($transferencia->status, ['concluida', 'cancelada'])) {
            return redirect()->back()->with('error', 'Esta transferência não pode ser cancelada.');
        }

        $transferencia->cancelarTransferencia($request->motivo_cancelamento);

        // Registrar auditoria
        $this->auditoriaService->registrarAtualizacao(
            $transferencia->produto_id,
            'status_transferencia',
            $transferencia->status,
            'cancelada',
            'Transferência cancelada - ' . ($request->motivo_cancelamento ?? 'Sem motivo especificado')
        );

        return redirect()->back()->with('success', 'Transferência cancelada.');
    }
}
