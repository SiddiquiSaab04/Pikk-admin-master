<?php

namespace Modules\Order\app\Services;

use Modules\Order\app\Repositories\OrderRepository;

class OrderProductAddonService
{
    protected $model;
    protected $branch;
    protected $orderProductAddonRepository;

    public function __construct(OrderRepository $orderProductAddonRepository)
    {
        $this->model = "\\Modules\\Order\\app\\Models\\OrderProductAddon";
        $this->orderProductAddonRepository = $orderProductAddonRepository->initTable($this->model, request()->branch);
        $this->branch = request()->branch;
    }

    public function create($data)
    {
        return $this->orderProductAddonRepository->create($data);
    }

    public function getAddonsByOrderProduct($order, $product)
    {
        return $this->orderProductAddonRepository
                    ->getWhere(
                        ['order_id', '=', $order->id],
                        ['order_product_id', '=', $product->id]
                    )->get();
    }
}
