<?php

namespace Modules\Order\app\Interfaces;

interface OrderInterface
{
    public function getAll();
    public function create($data);
    public function delete($id);
    public function update($id, $data);
    public function getById($id);
    public function getLatest();
}
