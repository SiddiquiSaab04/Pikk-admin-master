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

    public function whereIn($clause)
    {
        return $this->crudRepository->whereIn($this->model, $clause);
    }

    public function getWhere($clause)
    {
        return $this->crudRepository->getWhere($this->model, $clause);
    }

    public function updateOrCreate($clause, $data)
    {
        return $this->crudRepository->updateOrCreate($this->model, $clause, $data);
    }

    public function getWhereFirst($clause)
    {
        return $this->crudRepository->getWhereFirst($this->model, $clause);
    }
}
