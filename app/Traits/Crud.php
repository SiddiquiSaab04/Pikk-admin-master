<?php

namespace App\Traits;

trait Crud
{

    public function getAll()
    {
        return $this->crudRepository->getAll($this->model);
    }

    public function create($data)
    {
        return $this->crudRepository->create($this->model, $data);
    }

    public function getById($id)
    {
        return $this->crudRepository->getById($this->model, $id);
    }

    public function update($data, $id)
    {
        return $this->crudRepository->update($this->model, $id, $data);
    }

    public function delete($id)
    {
        return $this->crudRepository->delete($this->model, $id);
    }

    public function search($slug)
    {
        return $this->crudRepository->search($this->model, $slug);
    }
}
