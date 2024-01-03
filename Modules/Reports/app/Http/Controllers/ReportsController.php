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

    public function getOrdersCount(Request $request)
    {
        $count = $this->reportService->getOrdersCount($request->startDate, $request->endDate);
        return sendResponse(
            true,
            null,
            $count,
            "Total Orders",
            200
        );
    }

    public function getTotalRevenue(Request $request)
    {
        $revenue = $this->reportService->getTotalRevenue($request->startDate, $request->endDate);
        return sendResponse(
            true,
            null,
            ("$" . round($revenue, 2)),
            "Total Revenue",
            200
        );
    }

    public function getTotalProfit(Request $request)
    {
        $revenue = $this->reportService->getTotalProfit($request->startDate, $request->endDate);
        return sendResponse(
            true,
            null,
            ("$" . round($revenue, 2)),
            "Total Profit",
            200
        );
    }

    public function getOrdersByDate(Request $request)
    {
        $orders = $this->reportService->getOrdersByDate($request->startDate, $request->endDate);
        return sendResponse(
            true,
            null,
            $orders,
            "Total Profit",
            200
        );
    }

    public function getOrdersByPlatform(Request $request)
    {
        $orders = $this->reportService->getOrdersByPlatform($request->startDate, $request->endDate);
        return sendResponse(
            true,
            null,
            $orders,
            "Total Profit",
            200
        );
    }
}
