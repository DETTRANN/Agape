<?php

namespace App\Repositories;

use App\Models\Produto;

class ProdutoRepository implements ProdutoRepositoryInterface
{
    protected $model;

    public function __construct(Produto $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function update($id, array $data)
    {
        $produto = $this->model->find($id);
        if ($produto) {
            $produto->update($data);
            return $produto;
        }
        return null;
    }

    public function delete($id)
    {
        $produto = $this->model->find($id);
        if ($produto) {
            return $produto->delete();
        }
        return false;
    }

    public function findByUser($userId)
    {
        // Excluir produtos que estejam em transferência ativa (em_transito)
        // ou que tenham sido vendidos (transferência concluida com motivo 'Venda')
        return $this->model
            ->where('user_id', $userId)
            ->whereDoesntHave('transferencias', function ($q) use ($userId) {
                $q->where('user_id', $userId)
                  ->where(function ($q2) {
                      $q2->whereIn('status', ['em_transito'])
                         ->orWhere(function ($q3) {
                             $q3->where('status', 'concluida')
                                ->where('motivo', 'Venda');
                         });
                  });
            })
            ->get();
    }
}
