<?php

namespace Modules\Reports\app\Services;

use Modules\Order\app\Services\OrderService;

class ReportService
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function getOrdersCount($start, $end)
    {
        return $this->orderService->getOrdersByDate($start, $end)->count();
    }

    public function getTotalRevenue($start, $end)
    {
        return $this->orderService->getOrdersByDate($start, $end)->sum('sub_total');
    }

    public function getTotalProfit($start, $end)
    {
        return $this->orderService->getOrdersByDate($start, $end)->sum('total');
    }

    public function getOrdersByDate($start, $end)
    {
        $orders = $this->orderService->getOrdersByDate($start, $end)->groupBy('order_date')->map(function ($order) {
            return $order->count();
        })->sortKeys();

        return [
            "labels" => $orders->keys()->all(),
            "datasets" => [
                [
                    "label" => "orders",
                    "backgroundColor" => "#17a2b8",
                    "data" => $orders->values()->all()
                ]
            ]
        ];
    }

    public function getOrdersByPlatform($start, $end)
    {
        $orders = $this->orderService->getOrdersByDate($start, $end);
        $platforms = $orders->groupBy('platform')->map(function($order) use ($orders) {
            return ($order->count() * 100) / $orders->count();
        })->sortKeys();

        return $platforms;
    }
}
