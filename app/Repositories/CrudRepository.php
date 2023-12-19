<?php

namespace App\Repositories;

use App\Interfaces\CrudInterface;

class CrudRepository implements CrudInterface
{
    public function getAll($model)
    {
        return $model::orderByDesc('id')->paginate(20);
    }

    public function load($collection, $relationships)
    {
        $collection->load($relationships);
        return $collection;
    }

    public function getAllWithoutPagination($model)
    {
        return $model::get();
    }

    public function getById($model, $id)
    {
        return $model::find($id);
    }

    public function delete($model, $id)
    {
        return $model::where('id', $id)->delete();
    }

    public function search($model, $slug)
    {
        $columns = $this->getModelFillable($model);
        return $model::where(function($query) use ($columns, $slug){
            foreach($columns as $column) {
                $query->orWhere($column, 'LIKE', "%$slug%");
            }
        })->paginate(20);
    }

    public function create($model, array $data)
    {
        return $model::create($data);
    }

    public function update($model, string $id, array $data)
    {
        return $model::find($id)->update($data);
    }

    public function getWith($model, array $relation)
    {
        return $model::with($relation);
    }

    protected function getModelFillable($model)
    {
        return (new $model)->getFillable();
    }

    public function refresh($model)
    {
        return $model->refresh();
    }

    public function getWhere($model, array $clause)
    {
        return $model::where($clause)->paginate(20);
    }
}
