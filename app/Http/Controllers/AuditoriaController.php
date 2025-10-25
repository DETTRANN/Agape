<?php

namespace App\Http\Controllers;

use App\Models\EstoqueAuditoria;
use App\Services\AuditoriaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditoriaController extends Controller
{
    protected $auditoriaService;

    public function __construct(AuditoriaService $auditoriaService)
    {
        $this->auditoriaService = $auditoriaService;
    }

    public function index(Request $request)
    {
        $query = EstoqueAuditoria::where('user_id', Auth::id())
            ->with(['produto', 'user']);

        // Filtros
        if ($request->filled('tipo_operacao')) {
            $query->where('tipo_operacao', $request->tipo_operacao);
        }

        if ($request->filled('produto_id')) {
            $query->where('produto_id', $request->produto_id);
        }

        if ($request->filled('data_inicio')) {
            $query->whereDate('created_at', '>=', $request->data_inicio);
        }

        if ($request->filled('data_fim')) {
            $query->whereDate('created_at', '<=', $request->data_fim);
        }

        $auditorias = $query->orderBy('created_at', 'desc')->paginate(50);

        // Estatísticas
        $estatisticas = $this->auditoriaService->obterEstatisticasAuditoria(Auth::id());

        // Produtos para filtro
        $produtos = \App\Models\Produto::where('user_id', Auth::id())
            ->select('id', 'nome_item')
            ->get();

        return view('auditoria.index', compact('auditorias', 'estatisticas', 'produtos'));
    }

    public function show($produtoId)
    {
        // Verificar se o produto pertence ao usuário
        $produto = \App\Models\Produto::where('user_id', Auth::id())
            ->findOrFail($produtoId);

        $historico = $this->auditoriaService->obterHistoricoProduto($produtoId);

        return view('auditoria.show', compact('produto', 'historico'));
    }

    public function relatorio(Request $request)
    {
        $dataInicio = $request->input('data_inicio', now()->subDays(30)->format('Y-m-d'));
        $dataFim = $request->input('data_fim', now()->format('Y-m-d'));

        $auditorias = EstoqueAuditoria::where('user_id', Auth::id())
            ->whereBetween('created_at', [$dataInicio, $dataFim])
            ->with(['produto'])
            ->get();

        $estatisticas = [
            'total_operacoes' => $auditorias->count(),
            'por_tipo' => $auditorias->groupBy('tipo_operacao')->map->count(),
            'por_data' => $auditorias->groupBy(function($item) {
                return $item->created_at->format('Y-m-d');
            })->map->count(),
            'produtos_mais_alterados' => $auditorias->groupBy('produto_id')
                ->map(function($grupo) {
                    return [
                        'produto' => $grupo->first()->produto->nome_item ?? 'Produto removido',
                        'total' => $grupo->count()
                    ];
                })
                ->sortByDesc('total')
                ->take(10)
        ];

        return view('auditoria.relatorio', compact('auditorias', 'estatisticas', 'dataInicio', 'dataFim'));
    }
}
