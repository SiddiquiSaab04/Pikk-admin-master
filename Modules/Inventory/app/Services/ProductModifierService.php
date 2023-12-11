<?php

namespace Modules\Inventory\app\Services;

use Modules\Inventory\app\Repositories\ProductModifierRepository;

class ProductModifierService
{
    private $productModifierRepository;

    public function __construct(ProductModifierRepository $productModifierRepository)
    {
        $this->productModifierRepository = $productModifierRepository;
    }
}
