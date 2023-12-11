<?php

namespace Modules\Inventory\app\Interfaces;

interface CategoryRepositoryInterface
{
    public function getAllCategories();
    public function getCategoryById($id);
    public function deleteCategory($id);
    public function searchCategory($slug);
    public function createCategory(array $data);
    public function updateCategory(string $id, array $data);
    public function getCategoryWith(string $relation);
}
