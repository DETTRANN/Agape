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
        return $this->model->where('user_id', $userId)->get();
    }
}
