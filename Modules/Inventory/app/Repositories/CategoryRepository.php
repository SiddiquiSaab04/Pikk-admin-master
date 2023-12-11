<?php

namespace Modules\Inventory\app\Repositories;

use Modules\Inventory\app\Interfaces\CategoryRepositoryInterface;
use Modules\Inventory\app\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function getAllCategories()
    {
        return Category::paginate(20);
    }

    public function getCategoryById($id)
    {
        //
    }

    public function deleteCategory($id)
    {
        //
    }

    public function searchCategory($slug)
    {
        //
    }

    public function createCategory(array $data)
    {
        //
    }

    public function updateCategory(string $id, array $data)
    {
        //
    }

    public function getCategoryWith(string $relation)
    {
        //
    }
}
