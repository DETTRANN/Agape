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

        $request->validate([
            'id_item' => 'required',
            'status' => 'required',
            'nome_item' => 'required',
            'descricao' => 'required',
            'categoria' => 'required',
            'numero_serie' => 'required',
            'preco' => 'required|numeric',
            'data_posse' => 'required|date',
            'responsavel' => 'required|email'
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id(); // Garante que o user_id seja definido

        $produto = $this->produtoRepository->create($data);

        return redirect()->back()->with('success', 'Produto adicionado com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_item' => 'required',
            'status' => 'required',
            'nome_item' => 'required',
            'descricao' => 'required',
            'categoria' => 'required',
            'numero_serie' => 'required',
            'preco' => 'required|numeric',
            'data_posse' => 'required|date',
            'responsavel' => 'required|email'
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
