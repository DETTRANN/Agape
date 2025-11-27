<?php

namespace App\Http\Controllers;

use App\Repositories\ProdutoRepositoryInterface;
use App\Services\AuditoriaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdutoController extends Controller
{
    protected $produtoRepository;
    protected $auditoriaService;
    protected $produtoService;

    public function __construct(
        ProdutoRepositoryInterface $produtoRepository, 
        AuditoriaService $auditoriaService,
        \App\Services\ProdutoService $produtoService
    ) {
        $this->produtoRepository = $produtoRepository;
        $this->auditoriaService = $auditoriaService;
        $this->produtoService = $produtoService;
    }

    /**
     * Lista produtos do estoque com estatísticas
     */
    public function index()
    {
        $dadosEstoque = $this->produtoService->gerarDadosEstoque();
        return view('tabela_estoque', $dadosEstoque);
    }

    /**
     * Cria um novo produto
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('auth.login.form')->with('error', 'Você precisa estar autenticado para realizar esta ação.');
        }

        $request->validate([
            'status' => 'required',
            'nome_item' => 'required',
            'descricao' => 'required',
            'categoria' => 'required',
            'preco' => 'required|numeric|min:0',
            'data_posse' => 'required|date',
            'data_validade' => 'nullable|date|after:data_posse',
            'responsavel' => 'required|email',
            'numero_serie' => 'nullable|string',
            'localidade' => 'nullable|string',
            'observacoes' => 'nullable|string'
        ]);

        try {
            $data = $request->only([
                'status', 'nome_item', 'descricao', 'categoria',
                'numero_serie', 'preco', 'data_posse', 'data_validade',
                'responsavel', 'localidade', 'observacoes'
            ]);
            
            $this->produtoService->criarProduto($data);
            return redirect()->back()->with('success', 'Produto adicionado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Atualiza um produto existente
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
            'nome_item' => 'required',
            'descricao' => 'required',
            'categoria' => 'required',
            'preco' => 'required|numeric|min:0',
            'data_posse' => 'required|date',
            'data_validade' => 'nullable|date|after:data_posse',
            'responsavel' => 'required|email',
            'numero_serie' => 'nullable|string',
            'localidade' => 'nullable|string',
            'observacoes' => 'nullable|string'
        ]);

        try {
            $this->produtoService->atualizarProduto($id, $request->all());
            return redirect()->back()->with('success', 'Produto atualizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove um produto
     */
    public function destroy($id)
    {
        try {
            $this->produtoService->removerProduto($id);
            return redirect()->back()->with('success', 'Produto removido com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Salva configuração de categoria
     */
    public function salvarConfigCategoria(Request $request)
    {
        $request->validate([
            'nome_categoria' => 'required|string',
            'sem_validade' => 'sometimes|boolean',
            'dias_alerta_validade' => 'required_without:sem_validade|nullable|integer|min:1|max:365'
        ]);

        try {
            $semValidade = $request->boolean('sem_validade');
            $diasAlerta = (int) $request->input('dias_alerta_validade', 30);
            
            $this->produtoService->salvarConfigCategoria(
                $request->nome_categoria,
                $semValidade,
                $diasAlerta
            );
            
            return redirect()->back()->with('success', 'Configuração de alerta salva com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function relatorios()
    {
        $produtos = $this->produtoRepository->findByUser(Auth::id());
        if (!$produtos) {
            $produtos = collect();
        }

        // Total de itens
        $totalItens = $produtos->count();

        // Valor total do estoque
        $valorEstoque = $produtos->sum('preco');

        // Última atualização (data do item mais recente)
        $ultimaAtualizacao = $produtos->max('updated_at') ?? $produtos->max('created_at') ?? now();

        // ============================================
        // VENDAS ANUAIS (baseado em transferências)
        // ============================================
        $anoAtual = now()->year;
        
        // Buscar transferências do USUÁRIO com motivo "Venda" do ano atual
        $vendasAnoAtual = \App\Models\Transferencia::porUsuario(Auth::id())
            ->whereYear('created_at', $anoAtual)
            ->where('motivo', 'Venda')
            ->with('produto')
            ->get();
        
        // Total de vendas do ano
        $totalVendasAno = $vendasAnoAtual->count();
        
        // Calcular valor total de vendas (soma dos preços dos produtos vendidos)
        $valorTotalVendas = $vendasAnoAtual->reduce(function($total, $venda) {
            return $total + ($venda->produto ? (float)$venda->produto->preco : 0);
        }, 0);
        
        // Média de valor por venda
        $mediaValorVenda = $totalVendasAno > 0 ? $valorTotalVendas / $totalVendasAno : 0;
        
        // Produto mais vendido
        $produtoMaisVendido = $vendasAnoAtual
            ->groupBy('produto_id')
            ->map(function($grupo) use ($produtos) {
                $produto = $produtos->firstWhere('id', $grupo->first()->produto_id);
                return [
                    'nome' => $produto ? $produto->nome_item : 'Desconhecido',
                    'quantidade' => $grupo->count()
                ];
            })
            ->sortByDesc('quantidade')
            ->first();

        // Produtos com maior rotatividade (baseado na quantidade de repetições)
        // Conta quantas vezes cada item disponível aparece
        $produtosRotatividade = $produtos
            ->where('status', 'Disponível')
            ->groupBy('nome_item')
            ->map(function($grupo) {
                return [
                    'nome' => $grupo->first()->nome_item,
                    'rotatividade' => $grupo->count() // Quantidade de vezes que o item se repete
                ];
            })
            ->sortByDesc('rotatividade')
            ->take(5)
            ->values();

        // Itens em falta (status "Manutenção" ou "Ocupado")
        $itensFalta = $produtos
            ->whereIn('status', ['Manutenção', 'Ocupado'])
            ->groupBy('nome_item')
            ->map(function($grupo) {
                return [
                    'nome' => $grupo->first()->nome_item,
                    'quantidade' => $grupo->count() // Quantidade de itens com esse status
                ];
            })
            ->take(4)
            ->values();

        // Principais fornecedores (baseado no campo responsável)
        $principaisFornecedores = $produtos
            ->groupBy('responsavel')
            ->map(function($grupo) {
                return $grupo->count();
            })
            ->sortDesc()
            ->take(5)
            ->keys()
            ->map(function($email) {
                // Extrai apenas o nome antes do @ (ex: joao.silva@email.com -> joao.silva)
                return explode('@', $email)[0];
            })
            ->toArray();

        // Top 5 itens mais valiosos (ordenados por preço)
        $itensMaisValiosos = $produtos
            ->sortByDesc('preco')
            ->take(5)
            ->values();

        return view('relatorios', compact(
            'totalItens',
            'valorEstoque',
            'ultimaAtualizacao',
            'totalVendasAno',
            'valorTotalVendas',
            'mediaValorVenda',
            'produtoMaisVendido',
            'produtosRotatividade',
            'itensFalta',
            'principaisFornecedores',
            'itensMaisValiosos'
        ));
    }
}
