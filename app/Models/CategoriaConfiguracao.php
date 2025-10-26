<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaConfiguracao extends Model
{
    protected $table = 'categoria_configuracoes';
    
    protected $fillable = [
        'nome_categoria',
        'dias_alerta_validade',
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
}
