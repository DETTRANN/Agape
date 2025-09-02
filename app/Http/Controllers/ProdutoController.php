<?php

namespace App\Http\Controllers;

use App\Repositories\ProdutoRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdutoController extends Controller
{
    protected $produtoRepository;

    public function __construct(ProdutoRepositoryInterface $produtoRepository)
    {
        $this->produtoRepository = $produtoRepository;
    }

    public function index()
    {
        $produtos = $this->produtoRepository->findByUser(Auth::id());
        if (!$produtos) {
            $produtos = collect(); // Retorna uma coleção vazia se não houver produtos
        }
        return view('tabela_estoque', compact('produtos'));
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

        $produto = $this->produtoRepository->update($id, $request->all());

        return redirect()->back()->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $this->produtoRepository->delete($id);
        return redirect()->back()->with('success', 'Produto removido com sucesso!');
    }
}
