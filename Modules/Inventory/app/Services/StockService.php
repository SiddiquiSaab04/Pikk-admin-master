<?php

namespace Modules\Inventory\app\Services;

use App\Repositories\CrudRepository;
use App\Traits\Crud;
use Modules\Inventory\app\Repositories\StockRepository;

use function PHPSTORM_META\type;

class StockService
{
  use Crud;

  private $crudRepository;
  private $model;
  private $branch;
  private $productService;
  private $stockRepository;

  public function __construct(
    CrudRepository $crudRepository,
    ProductService $productService,
    StockRepository $stockRepository
  ) {
    $this->model = "\\Modules\\Inventory\\app\\Models\\ProductStock";
    $this->stockRepository = $stockRepository->initTable($this->model, request()->branch);
    $this->branch = request()->branch;
    $this->crudRepository = $crudRepository;
    $this->productService = $productService;
  }

  public function getViewsData()
  {
    $products = $this->productService->getAllWithoutPagination();
    $products->load('stock');

    return [
      "products" => $products,
      'title' => 'Manage Stocks',
      'description' => 'Change Stocks Values'
    ];
  }

  public function manageStock($request)
  {
    $clause = ['product_id' => $request['product_id']];

    $data['default_quantity'] = $request['default_quantity'];
    $data['available_stock'] = $request['available_stock'];
    $data['is_enabled'] = $request['is_enabled'];
    $data['is_new'] = $request['is_new'];

    return $this->stockRepository->updateOrCreate($clause, $data);
  }
}
