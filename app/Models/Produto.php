<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $table = 'produtos';
    
    protected $fillable = [
        'id_item',
        'status',
        'nome_item',
        'descricao',
        'categoria',
        'numero_serie',
        'preco',
        'data_posse',
        'data_validade',
        'responsavel',
        'localidade',
        'observacoes',
        'user_id'
    ];

    // Relacionamento com cliente
    public function user()
    {
        return $this->belongsTo(\App\Models\Cliente::class, 'user_id');
    }
    
    // Alias para facilitar
    public function cliente()
    {
        return $this->belongsTo(\App\Models\Cliente::class, 'user_id');
    }

    // Relacionamento com transferências
    public function transferencias()
    {
        return $this->hasMany(\App\Models\Transferencia::class, 'produto_id');
    }
}
