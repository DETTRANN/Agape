<?php

namespace App\Http\Controllers;

use App\Services\TransferenciaService;
use Illuminate\Http\Request;

class TransferenciaController extends Controller
{
    protected $transferenciaService;

    public function __construct(TransferenciaService $transferenciaService)
    {
        $this->transferenciaService = $transferenciaService;
    }

    /**
     * Lista transferências com paginação
     */
    public function index()
    {
        $transferencias = $this->transferenciaService->buscarTransferenciasDoUsuario();
        $estatisticas = $this->transferenciaService->calcularEstatisticasDoUsuario();

        return view('transferencias.index', compact('transferencias', 'estatisticas'));
    }

    /**
     * Mostra formulário de criação de transferência
     */
    public function create()
    {
        $produtos = $this->transferenciaService->buscarProdutosDisponiveis();
        return view('transferencias.create', compact('produtos'));
    }

    /**
     * Cria uma nova transferência
     */
    public function store(Request $request)
    {
        $request->validate([
            'produto_id' => 'required|exists:produtos,id',
            'localidade_destino' => 'required|string|max:255',
            'responsavel_destino' => 'required|email',
            'motivo' => 'nullable|string',
            'observacoes' => 'nullable|string',
        ]);

        try {
            $this->transferenciaService->criarTransferencia($request->all());
            return redirect()->route('transferencias.index')
                ->with('success', 'Transferência solicitada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Exibe uma transferência específica
     */
    public function show($id)
    {
        $transferencia = $this->transferenciaService->buscarTransferenciaDoUsuario($id);
        return view('transferencias.show', compact('transferencia'));
    }

    /**
     * Inicia uma transferência pendente
     */
    public function iniciarTransferencia($id)
    {
        try {
            $resultado = $this->transferenciaService->iniciarTransferencia($id);
            return redirect()->back()->with('success', $resultado['message']);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Conclui uma transferência em trânsito
     */
    public function concluirTransferencia($id)
    {
        try {
            $resultado = $this->transferenciaService->concluirTransferencia($id);
            return redirect()->back()->with('success', $resultado['message']);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Cancela uma transferência
     */
    public function cancelarTransferencia(Request $request, $id)
    {
        try {
            $resultado = $this->transferenciaService->cancelarTransferencia($id, $request->motivo_cancelamento);
            return redirect()->back()->with('success', $resultado['message']);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
