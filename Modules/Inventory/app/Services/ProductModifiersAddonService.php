<?php

namespace Modules\Inventory\app\Services;

use Modules\Inventory\app\Repositories\ProductModifiersAddonsRepository;

class ProductModifiersAddonService
{
    private $productModifiersAdddonRepository;

    public function __construct(ProductModifiersAddonsRepository $productModifiersAdddonRepository)
    {
        $this->productModifiersAdddonRepository = $productModifiersAdddonRepository;
    }
}
