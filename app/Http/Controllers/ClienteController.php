<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ClienteRepository;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ClienteController extends Controller
{
    protected $clienteRepository;

    public function __construct(ClienteRepository $clienteRepository)
    {
        $this->clienteRepository = $clienteRepository;
    }

    public function create()
    {
        return view('register');
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:100',
            'sobrenome' => 'required|string|max:100',
            'email' => 'required|email|unique:clientes,email|unique:users,email',
            'senha' => 'required|min:6|confirmed',
            'aceito_termos' => 'accepted',
        ]);

        $dados['senha'] = Hash::make($dados['senha']);
        $this->clienteRepository->create($dados);

        // Cria também na tabela users para login funcionar
        $user = User::create([
            'name' => $dados['nome'] . ' ' . $dados['sobrenome'],
            'email' => $dados['email'],
            'password' => $dados['senha'],
        ]);

        // Autentica o usuário automaticamente após cadastro
        Auth::login($user);

        // Redireciona para o sistema
        return redirect()->route('system.page')->with('success', 'Cadastro realizado com sucesso!');
    }
}
