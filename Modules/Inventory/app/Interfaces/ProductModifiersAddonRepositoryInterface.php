<?php

namespace Modules\Inventory\app\Interfaces;

interface ProductModifiersAddonRepositoryInterface
{
    public function getAllProductModifiersAddons();
    public function getProductModifiersAddonById($id);
    public function deleteProductModifiersAddon($id);
    public function searchProductModifiersAddon($slug);
    public function createProductModifiersAddon(array $data);
    public function updateProductModifiersAddon(string $id, array $data);
    public function getProductModifiersAddonWith(string $relation);
}
