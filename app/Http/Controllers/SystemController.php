<?php

namespace App\Http\Controllers;

use App\Services\EstatisticasService;
use Illuminate\Support\Facades\Auth;

class SystemController extends Controller
{
    protected $estatisticasService;

    public function __construct(EstatisticasService $estatisticasService)
    {
        $this->estatisticasService = $estatisticasService;
    }

    /**
     * Exibe dashboard do sistema com estatísticas
     */
    public function index()
    {
        $estatisticas = $this->estatisticasService->calcularEstatisticasTransferencias(Auth::id());

        return view('system', [
            'produtosAtivos' => $estatisticas['produtos_ativos'],
            'transferenciasAtivas' => $estatisticas['transferencias_ativas'],
            'entregasHoje' => $estatisticas['entregas_hoje'],
        ]);
    }
}
