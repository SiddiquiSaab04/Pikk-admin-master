<?php

namespace App\Interfaces;
interface CrudInterface
{
    public function getAll(string $model);
    public function getAllWithoutPagination(string $model);
    public function load($collection, $relationships);
    public function getById(string $model, string $id);
    public function delete(string $model, $id);
    public function search(string $model, string $slug);
    public function create(string $model, array $data);
    public function update(string $model, string $id, array $data);
    public function getWith(string $model, array $relation);
    public function refresh($model);
    public function whereIn(string $model, array $clauses);
    public function getWhere($model, array $clause);
    public function updateOrCreate(string $model, array $clauses, array $data);
}
