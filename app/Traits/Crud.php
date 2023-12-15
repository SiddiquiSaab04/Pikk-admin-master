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

    public function getAllWithoutPagination()
    {
        return $this->crudRepository->getAllWithoutPagination($this->model);
    }

    public function load($collection, $relationships)
    {
        return $this->crudRepository->load($collection,$relationships);
    }

    public function refresh($model)
    {
        return $this->crudRepository->refresh($model);
    }
}
