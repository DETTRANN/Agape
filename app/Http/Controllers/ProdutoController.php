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

    public function __construct(ProdutoRepositoryInterface $produtoRepository, AuditoriaService $auditoriaService)
    {
        $this->produtoRepository = $produtoRepository;
        $this->auditoriaService = $auditoriaService;
    }

    public function index()
    {
        $produtos = $this->produtoRepository->findByUser(Auth::id());
        if (!$produtos) {
            $produtos = collect(); // Retorna uma coleção vazia se não houver produtos
        }

        // Calcular estatísticas do estoque
        $totalItens = $produtos->count();
        $itensOcupados = $produtos->where('status', 'Ocupado')->count();
        $porcentagemOcupados = $totalItens > 0 ? ($itensOcupados / $totalItens) * 100 : 0;
        
        // Determinar se há alerta de estoque baixo (50% ou mais ocupados)
        $estoqueAlerta = $porcentagemOcupados >= 50;
        
        return view('tabela_estoque', compact('produtos', 'totalItens', 'itensOcupados', 'porcentagemOcupados', 'estoqueAlerta'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('auth.login.form')->with('error', 'Você precisa estar autenticado para realizar esta ação.');
        }

        $userId = Auth::id();
        
        // Verificar se o usuário existe (agora usando Cliente)
        if (!$userId || !\App\Models\Cliente::find($userId)) {
            return redirect()->route('auth.login.form')->with('error', 'Sessão inválida. Faça login novamente.');
        }

        $request->validate([
            'status' => 'required',
            'nome_item' => 'required',
            'descricao' => 'required',
            'categoria' => 'required',
            'preco' => 'required|numeric|min:0',
            'data_posse' => 'required|date',
            'responsavel' => 'required|email',
            'numero_serie' => 'nullable|string',
            'localidade' => 'nullable|string',
            'observacoes' => 'nullable|string'
        ]);

        $data = $request->only([
            'status',
            'nome_item', 
            'descricao',
            'categoria',
            'numero_serie',
            'preco',
            'data_posse',
            'responsavel',
            'localidade',
            'observacoes'
        ]);
        
        // Gerar próximo ID sequencial para este usuário específico
        $ultimoIdDoUsuario = \App\Models\Produto::where('user_id', $userId)->max('id_item');
        $proximoNumero = $ultimoIdDoUsuario ? (int)$ultimoIdDoUsuario + 1 : 1;
        $data['id_item'] = (string)$proximoNumero;
        $data['user_id'] = $userId;

        $produto = $this->produtoRepository->create($data);

        // Registrar auditoria de criação
        $this->auditoriaService->registrarCriacao($produto->id, 'Produto criado: ' . $produto->nome_item);

        return redirect()->back()->with('success', 'Produto adicionado com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
            'nome_item' => 'required',
            'descricao' => 'required',
            'categoria' => 'required',
            'preco' => 'required|numeric|min:0',
            'data_posse' => 'required|date',
            'responsavel' => 'required|email',
            'numero_serie' => 'nullable|string',
            'localidade' => 'nullable|string',
            'observacoes' => 'nullable|string'
        ]);

        // Obter produto anterior para auditoria
        $produtoAnterior = $this->produtoRepository->find($id);
        $produto = $this->produtoRepository->update($id, $request->all());

        // Registrar alterações na auditoria
        if ($produtoAnterior) {
            $dadosNovos = $request->all();
            foreach ($dadosNovos as $campo => $valorNovo) {
                $valorAnterior = $produtoAnterior->$campo ?? null;
                if ($valorAnterior != $valorNovo) {
                    $this->auditoriaService->registrarAtualizacao(
                        $id,
                        $campo,
                        $valorAnterior,
                        $valorNovo,
                        "Campo '{$campo}' alterado"
                    );
                }
            }
        }

        return redirect()->back()->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy($id)
    {
        // Obter produto antes da exclusão para auditoria
        $produto = $this->produtoRepository->find($id);
        
        if ($produto) {
            // Registrar auditoria de exclusão
            $this->auditoriaService->registrarExclusao($id, 'Produto removido: ' . $produto->nome_item);
        }
        
        $this->produtoRepository->delete($id);
        return redirect()->back()->with('success', 'Produto removido com sucesso!');
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
            ->take(4)
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
            'produtosRotatividade',
            'itensFalta',
            'principaisFornecedores',
            'itensMaisValiosos'
        ));
    }
}
