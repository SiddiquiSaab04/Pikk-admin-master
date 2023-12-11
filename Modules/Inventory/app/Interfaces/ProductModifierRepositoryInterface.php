<?php

namespace Modules\Inventory\app\Interfaces;

interface ProductModifierRepositoryInterface
{
    public function getAllProductModifiers();
    public function getProductModifierById($id);
    public function deleteProductModifier($id);
    public function searchProductModifier($slug);
    public function createProductModifier(array $data);
    public function updateProductModifier(string $id, array $data);
    public function getProductModifierWith(string $relation);
}
