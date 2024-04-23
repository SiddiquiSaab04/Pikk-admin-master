<?php

namespace Modules\Customers\app\Http\Controllers;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Customers\app\Services\CustomersService;
use Modules\Customers\app\Http\Requests\CustomerRequest;
use Modules\Customers\app\Services\CustomersCashbackService;

class CustomersController extends Controller
{
    private $customersService;
    private $customersCashbackService;

    public function __construct(CustomersService $customersService, CustomersCashbackService $customersCashbackService)
    {
        $this->customersService = $customersService;
        $this->customersCashbackService = $customersCashbackService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('customers::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('customers::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('customers::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

    public function loginOrRegister(CustomerRequest $request)
    {
        return $this->customersService->loginOrRegister($request->all());
    }

    public function logout()
    {
        return $this->customersService->logout();
    }

    public function cashback()
    {
        return $this->customersCashbackService->cashback();
    }

    public function computeCashback(Request $request)
    {
        $month = request()->month;
        $year = request()->year;

        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = Carbon::create($year, $month, 1)->endOfMonth();

        $formattedStartDate = $startDate->toDateString();
        $formattedEndDate = $endDate->toDateString();

        return $this->customersCashbackService->computeCashback($formattedStartDate, $formattedEndDate);
    }
}
