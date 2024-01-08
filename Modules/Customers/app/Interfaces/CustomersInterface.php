<?php

namespace Modules\Customers\app\Interfaces;

use Modules\Customers\app\Models\Customer;

interface CustomersInterface
{
  public function loginOrRegister(array $data);
  public function logout();
  public function generateToken(Customer $customer);
}
