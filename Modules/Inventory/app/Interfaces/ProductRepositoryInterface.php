<?php

namespace Modules\Inventory\app\Interfaces;

interface ProductRepositoryInterface
{
    public function getAllProducts();
    public function getProductById($id);
    public function deleteProduct($id);
    public function searchProduct($slug);
    public function createProduct(array $data);
    public function updateProduct(string $id, array $data);
    public function getProductWith(string $relation);
}
