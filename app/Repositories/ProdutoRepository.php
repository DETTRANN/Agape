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

    /**
     * Busca produto por identificador visível na tabela (id_item) ou id interno
     */
    public function findById($id)
    {
        // Alguns lugares usam id_item (código do item exibido na tabela)
        // Tenta primeiro por id_item, se não achar, tenta pelo id padrão
        $byItem = $this->model->where('id_item', $id)->first();
        if ($byItem) {
            return $byItem;
        }
        return $this->model->find($id);
    }

    /**
     * Busca produto por id_item ou id, restrito ao usuário
     */
    public function findByIdForUser($userId, $id)
    {
        $byItem = $this->model
            ->where('user_id', $userId)
            ->where('id_item', $id)
            ->first();
        if ($byItem) {
            return $byItem;
        }

        return $this->model
            ->where('user_id', $userId)
            ->where('id', $id)
            ->first();
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
        // Excluir apenas produtos que estejam em transferência ativa ou concluída
        return $this->model
            ->where('user_id', $userId)
            ->whereDoesntHave('transferencias', function ($q) use ($userId) {
                $q->where('user_id', $userId)
                  ->whereIn('status', ['em_transito', 'concluida']);
            })
            ->get();
    }
}
