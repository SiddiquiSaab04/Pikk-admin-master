<?php

namespace App\Interfaces;
use Illuminate\Database\Eloquent\Model;

interface CrudInterface
{
    public function getAll(string $model);
    public function getById(string $model, string $id);
    public function delete(string $model, $id);
    public function search(string $model, string $slug);
    public function create(string $model, array $data);
    public function update(string $model, string $id, array $data);
    public function getWith(string $model, array $relation);
}
