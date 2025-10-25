<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transferencia extends Model
{
    protected $table = 'transferencias';
    
    protected $fillable = [
        'produto_id',
        'user_id',
        'localidade_origem',
        'localidade_destino',
        'responsavel_origem',
        'responsavel_destino',
        'status',
        'data_solicitacao',
        'data_inicio',
        'data_conclusao',
        'motivo',
        'observacoes',
        'codigo_rastreamento'
    ];

    protected $casts = [
        'data_solicitacao' => 'date',
        'data_inicio' => 'date',
        'data_conclusao' => 'date',
    ];

    // Relacionamentos
    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }

    public function user()
    {
        return $this->belongsTo(Cliente::class, 'user_id');
    }

    // Scopes
    public function scopePendentes($query)
    {
        return $query->where('status', 'pendente');
    }

    public function scopeEmTransito($query)
    {
        return $query->where('status', 'em_transito');
    }

    public function scopeConcluidas($query)
    {
        return $query->where('status', 'concluida');
    }

    public function scopePorUsuario($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Métodos auxiliares
    public function iniciarTransferencia()
    {
        $this->update([
            'status' => 'em_transito',
            'data_inicio' => now(),
            'codigo_rastreamento' => 'TR' . str_pad($this->id, 6, '0', STR_PAD_LEFT) . strtoupper(substr(md5(time()), 0, 4))
        ]);
    }

    public function concluirTransferencia()
    {
        $this->update([
            'status' => 'concluida',
            'data_conclusao' => now()
        ]);

        // Atualizar localidade do produto
        $this->produto->update([
            'localidade' => $this->localidade_destino,
            'responsavel' => $this->responsavel_destino
        ]);
    }

    public function cancelarTransferencia($motivo = null)
    {
        $this->update([
            'status' => 'cancelada',
            'observacoes' => $motivo ? $this->observacoes . "\nCancelamento: " . $motivo : $this->observacoes
        ]);
    }
}
