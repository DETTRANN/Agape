<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Produto;
use App\Services\AuditoriaService;
use Carbon\Carbon;

class MarcarProdutosVencidos extends Command
{
    protected $signature = 'produtos:marcar-vencidos';
    protected $description = 'Marca produtos como "Vencido" quando a data de validade é ultrapassada';

    protected $auditoriaService;

    public function __construct(AuditoriaService $auditoriaService)
    {
        parent::__construct();
        $this->auditoriaService = $auditoriaService;
    }

    public function handle()
    {
        $this->info('Verificando produtos vencidos...');

        $produtosVencidos = Produto::whereNotNull('data_validade')
            ->where('data_validade', '<', Carbon::now())
            ->whereNotIn('status', ['Vencido'])
            ->get();

        if ($produtosVencidos->isEmpty()) {
            $this->info('Nenhum produto vencido encontrado.');
            return 0;
        }

        $contador = 0;
        foreach ($produtosVencidos as $produto) {
            $statusAnterior = $produto->status;
            $produto->update(['status' => 'Vencido']);

            // Registrar na auditoria
            $this->auditoriaService->registrarAtualizacao(
                $produto->id,
                'status',
                $statusAnterior,
                'Vencido',
                'Status alterado automaticamente - produto venceu em ' . Carbon::parse($produto->data_validade)->format('d/m/Y')
            );

            $contador++;
        }

        $this->info("✅ {$contador} produto(s) marcado(s) como 'Vencido'");
        return 0;
    }
}
