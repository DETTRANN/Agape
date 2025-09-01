<?php

namespace App\Repositories;

use App\Models\Cliente;

class ClienteRepository
{
    protected $model;

    public function __construct(Cliente $cliente)
    {
        $this->model = $cliente;
    }

    public function create(array $dados)
    {
        return $this->model->create($dados);
    }
}
