<?php

namespace Modules\Inventory\app\Services;

use Modules\Inventory\app\Repositories\ProductRepository;

class ProductService
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }
}
