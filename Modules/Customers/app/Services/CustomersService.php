<?php

namespace Modules\Customers\app\Services;

use App\Repositories\CrudRepository;
use App\Traits\Crud;
use Illuminate\Support\Facades\Auth;
use Modules\Customers\app\Models\Customer;
use Modules\Customers\app\Repositories\CustomersRepository;

class CustomersService
{
  use Crud;

  private $crudRepository;
  private $customersRepository;
  private $model;

  public function __construct(CrudRepository $crudRepository, CustomersRepository $customersRepository)
  {
    $this->crudRepository = $crudRepository;
    $this->customersRepository = $customersRepository;
    $this->model = "\\Modules\\Customers\\app\\Models\\Customer";
  }

  public function loginOrRegister($request)
  {
    $customer = $this->getWhere(['phone' => $request['phone']])->first();

    if ($customer) {
      $token = $this->customersRepository->generateToken($customer);
    } else {
      $customer = $this->create($request);
      $token = $this->customersRepository->generateToken($customer);
    }

    $response = [
      'customer' => $customer,
      'token' => $token
    ];

    return sendResponse(true, null, $response, 'Successfully logged in.', 200);
  }

  public function logout()
  {
    Auth::user()->tokens()->delete();
    return sendResponse(true, null, null, 'Successfully logout.', 200);
  }
}
