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

    public function getOrdersCount()
    {
        return $this->orderService->getCount();
    }

    public function getTotalRevenue()
    {
        return $this->orderService->getRevenue("sub_total");
    }

    public function getTotalProfit()
    {
        return $this->orderService->getRevenue("total");
    }
}
