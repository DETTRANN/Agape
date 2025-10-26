<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Transferencia;

class SystemController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Produtos ativos: se existir status 'Ativo' (ou 'ativo'), usa, senão usa total do usuário
        $ativosPossiveis = ['Ativo', 'ativo', 'Disponível', 'Disponivel'];
        $produtosAtivos = Produto::where('user_id', $userId)
            ->whereIn('status', $ativosPossiveis)
            ->count();

        if ($produtosAtivos === 0) {
            $produtosAtivos = Produto::where('user_id', $userId)->count();
        }

        // Transferências ativas: pendente ou em_transito
        $transferenciasAtivas = Transferencia::porUsuario($userId)
            ->whereIn('status', ['pendente', 'em_transito'])
            ->count();

        // Entregas hoje: transferências concluídas hoje
        $entregasHoje = Transferencia::porUsuario($userId)
            ->whereDate('data_conclusao', now()->toDateString())
            ->count();

        return view('system', [
            'produtosAtivos' => $produtosAtivos,
            'transferenciasAtivas' => $transferenciasAtivas,
            'entregasHoje' => $entregasHoje,
        ]);
    }
}
