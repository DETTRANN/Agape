<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Cliente extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'clientes';

    protected $fillable = [
        'nome',
        'sobrenome',
        'email',
        'senha',
    ];

    protected $hidden = [
        'senha',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'senha' => 'hashed',
    ];

    // Configurar o campo de senha para autenticação
    public function getAuthPassword()
    {
        return $this->senha;
    }
}
