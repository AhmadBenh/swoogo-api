<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $dbData = $this->find($id);
        $dbData->update($data);
        return $dbData;
    }

    public function delete(int $id)
    {
        $dbData = $this->find($id);
        $dbData->delete();
        return true;
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function findAll()
    {
        return $this->model->all();
    }
}
