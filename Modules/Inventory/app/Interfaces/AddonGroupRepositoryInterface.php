<?php

namespace Modules\Inventory\app\Interfaces;

interface AddonGroupRepositoryInterface
{
    public function getAllAddons();
    public function getAddonById($id);
    public function deleteAddon($id);
    public function searchAddon($slug);
    public function createAddon(array $data);
    public function updateAddon(string $id, array $data);
    public function getAddonWith(string $relation);
}
