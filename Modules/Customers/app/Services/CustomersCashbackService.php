<?php

namespace Modules\Customers\app\Services;

use App\Repositories\CrudRepository;
use App\Traits\Crud;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CustomersCashbackService
{
  use Crud;

  private $crudRepository;
  private $customerService;
  private $model;

  public function __construct(CrudRepository $crudRepository, CustomersService $customerService)
  {
    $this->crudRepository = $crudRepository;
    $this->customerService = $customerService;
    $this->model = "\\Modules\\Customers\\app\\Models\\CustomerCashback";
  }

  public function createCashBack($data)
  {
    try {
      $this->create($data);
      $this->customerService->applyCashback($data['customer_id'], $data['amount']);
      return;
    } catch (Exception $e) {
      Log::info($e->getMessage());
    }
  }

  public function cashback()
  {
    $cashback =  $this->getWhere(['customer_id' => Auth::user()->id]);
    return sendResponse(true, null, $cashback, '', 200);
  }

  public function computeCashback($startDate, $endDate)
  {
    $cashback =  $this->getWhere([['customer_id', Auth::user()->id], ['created_at', '>=', $startDate], ['created_at', '<=', $endDate]]);
    return sendResponse(true, null, $cashback, '', 200);
  }
}
