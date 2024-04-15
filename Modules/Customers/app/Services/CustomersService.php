<?php

namespace Modules\Customers\app\Services;

use App\Repositories\CrudRepository;
use App\Traits\Crud;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
            // if ($customer->pin == $request['pin']) {
                $token = $this->customersRepository->generateToken($customer);
            // } else {
            //     return sendResponse(false, null, null, "Credentials do not match our record", 500);
            // }
        } else {
            $request['name'] = $request['name'] ?? '';
            $request['phone_verified'] = $request['phone_verified'] ?? 0;
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

    public function applyCashback($id, $amount, $add = true)
    {
        $customer = $this->getById($id);

        if ($add) {
            $cashback = $customer->cashback_points + $amount;
        } else {
            $cashback = (int) $amount;
        }

        $data['cashback_points'] = $cashback;

        try {
            $this->update($data, $id);
        } catch (Exception $e) {
            Log::info($e->getMessage());
        }
    }
}
