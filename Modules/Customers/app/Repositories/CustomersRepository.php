<?php

namespace Modules\Customers\app\Repositories;

use Illuminate\Support\Facades\Auth;
use Modules\Customers\app\Interfaces\CustomersInterface;

class CustomersRepository implements CustomersInterface
{

  public function loginOrRegister(array $data)
  {
  }

  public function logout()
  {
  }

  public function generateToken($customer)
  {
    return $customer->createToken($customer->phone)->plainTextToken;
  }
}
