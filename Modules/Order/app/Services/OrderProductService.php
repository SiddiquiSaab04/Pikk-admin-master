<?php

namespace Modules\Order\app\Services;

use Modules\Order\app\Repositories\OrderRepository;

class OrderProductService
{
    protected $model;
    protected $branch;
    protected $orderProductRepository;
    protected $orderProductAddonService;

    public function __construct(OrderRepository $orderProductRespository, OrderProductAddonService $orderProductAddonService)
    {
        $this->model = "\\Modules\\Order\\app\\Models\\OrderProduct";
        $this->orderProductRepository = $orderProductRespository->initTable($this->model, request()->branch);
        $this->orderProductAddonService = $orderProductAddonService;
        $this->branch = request()->branch;
    }

    public function create($data)
    {
        return $this->orderProductRepository->create($data);
    }

    public function getProductsByOrder($orders)
    {
        if(isset($orders[0])) {
            foreach($orders as $index => $order) {
                $order = $this->getOrderAdditionalData($order);

                $orders[$index] = $order;
            }
        } else {
            $orders = $this->getOrderAdditionalData($orders);
        }

        return $orders;
    }

    protected function getOrderAdditionalData($order)
    {
        $order->orderProducts = $this->orderProductRepository
                        ->getWhere(['order_id', '=', $order->id])
                        ->get();

        foreach($order->orderProducts as $key => $product) {
            $order->orderProducts[$key]->addons = $this->orderProductAddonService->getAddonsByOrderProduct($order, $product);
        }

        return $order;
    }
}
