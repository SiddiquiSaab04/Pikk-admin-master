<?php

namespace Modules\Reports\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Reports\app\Services\ReportService;

class ReportsController extends Controller
{
   protected $reportService;

   public function __construct(ReportService $reportService)
   {
        $this->reportService = $reportService;
   }

   public function index()
   {
        return sendResponse(false, 'reports::index', [
            "title" => "Order Reports",
            "description" => "show order reports"
        ]);
   }

   public function getOrdersCount()
   {
        $count = $this->reportService->getOrdersCount();
        return sendResponse(
            true,
            null,
            $count,
            "Order Count",
            200
        );
    }

    public function getTotalRevenue()
    {
        $revenue = $this->reportService->getTotalRevenue();
        return sendResponse(
            true,
            null,
            ("$".round($revenue, 2)),
            "Total Revenue",
            200
        );
    }

    public function getTotalProfit()
    {
        $revenue = $this->reportService->getTotalProfit();
        return sendResponse(
            true,
            null,
            ("$".round($revenue, 2)),
            "Total Profit",
            200
        );
    }
}
