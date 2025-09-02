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
        'responsavel',
        'localidade',
        'observacoes',
        'user_id'
    ];

    // Relacionamento com usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
