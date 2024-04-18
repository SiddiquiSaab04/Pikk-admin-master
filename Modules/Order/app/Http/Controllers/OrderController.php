<?php

namespace Modules\Order\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Modules\Order\app\Services\OrderService;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
        if (array_key_exists('HTTP_AUTHORIZATION', $_SERVER)) {
            $this->middleware('auth:sanctum');
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = $this->orderService->getAll();
        if (request()->wantsjson()) {
            return sendResponse(
                true,
                null,
                $orders,
                null,
                200
            );
        } else {
            return sendResponse(false, 'order::index', [
                "orders" => $orders,
                "title" => "Orders List",
                "description" => "show all orders listing"
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('order::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $auth = $request->user();
        $order = $this->orderService->create($request->all(), $auth);
        return sendResponse(
            true,
            null,
            $order,
            null,
            200
        );
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('order::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('order::edit');
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

    public function receipt($branch, $id)
    {
        $receipt = $this->orderService->orderData($id);
        if (request()->wantsJson()) {
            return sendResponse(
                true,
                null,
                $receipt,
                null,
                200
            );
        } else {
            return sendResponse(false, 'order::receipt', [
                "receipt" => $receipt,
                "title" => "Order Receipt",
                "description" => "show receipt for order"
            ]);
        }
    }

    public function invoice($branch, $id)
    {
        $invoice = $this->orderService->orderData($id);
        if (request()->wantsJson()) {
            return sendResponse(
                true,
                null,
                $invoice,
                null,
                200
            );
        } else {
            return sendResponse(false, 'order::invoice', [
                "invoice" => $invoice,
                "title" => "Order Invoice",
                "description" => "show invoice for order"
            ]);
        }
    }

    public function getPendingOrders()
    {
        $orders = $this->orderService->getPendingOrders();
        if (request()->wantsJson()) {
            return sendResponse(true, null, $orders, null, 200);
        } else {
            //
        }
    }

    public function getReadyOrders()
    {
        $orders = $this->orderService->getReadyOrders();
        if (request()->wantsJson()) {
            return sendResponse(true, null, $orders, null, 200);
        } else {
            //
        }
    }

    public function getServeOrders()
    {
        $orders = $this->orderService->getServeOrders();
        if (request()->wantsJson()) {
            return sendResponse(true, null, $orders, null, 200);
        } else {
            //
        }
    }

    public function getPendingAndReadyOrders()
    {
        $orders = $this->orderService->getPendingAndReadyOrders();
        if (request()->wantsJson()) {
            return sendResponse(true, null, $orders, null, 200);
        } else {
            //
        }
    }

    public function readyOrder(Request $request)
    {
        $order = $this->orderService->readyOrder($request->id);
        if($order) {
            return sendResponse(
                true,
                null,
                null,
                "Order Is Ready",
                200
            );
        } else {
            return sendError(
                true,
                null,
                null,
                "Some error occurred",
                500
            );
        }
    }

    public function cancelOrder(Request $request)
    {
        $order = $this->orderService->cancelOrder($request->all());
        if($order) {
            return sendResponse(
                true,
                null,
                null,
                "Order Cancelled",
                200
            );
        } else {
            return sendError(
                true,
                null,
                null,
                "Some error occurred",
                500
            );
        }
    }

    public function serveOrder(Request $request)
    {
        $order = $this->orderService->serveOrder($request->all());
        if($order) {
            return sendResponse(
                true,
                null,
                null,
                "Order Served",
                200
            );
        } else {
            return sendError(
                true,
                null,
                null,
                "Some error occurred",
                500
            );
        }
    }

    public function sendReminder(Request $request)
    {
        $order = $this->orderService->sendReminder($request->all());
        if($order) {
            return sendResponse(
                true,
                null,
                null,
                "Reminder sent",
                200
            );
        } else {
            return sendError(
                true,
                null,
                null,
                "Some error occurred",
                500
            );
        }
    }
}
