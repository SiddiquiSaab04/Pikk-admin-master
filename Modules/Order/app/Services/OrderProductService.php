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

    public function getProductsByOrder($order)
    {
        $order->orderProducts = $this->orderProductRepository
                    ->getWhere(['order_id', '=', 10])
                    ->get();

        foreach($order->orderProducts as $key => $product) {
            $order->orderProducts[$key]->addons = $this->orderProductAddonService->getAddonsByOrderProduct($order, $product);
        }

        return $order;
    }
}
