<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstoqueAuditoria extends Model
{
    protected $table = 'estoque_auditoria';
    
    protected $fillable = [
        'produto_id',
        'user_id',
        'tipo_operacao',
        'campo_alterado',
        'valor_anterior',
        'valor_novo',
        'ip_usuario',
        'observacoes'
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

    // Scopes para facilitar consultas
    public function scopePorTipoOperacao($query, $tipo)
    {
        return $query->where('tipo_operacao', $tipo);
    }

    public function scopePorProduto($query, $produtoId)
    {
        return $query->where('produto_id', $produtoId);
    }

    public function scopePorUsuario($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
