<?php

namespace Modules\Inventory\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Inventory\app\Services\StockService;

class ProductStockController extends Controller
{
    private $stocktService;

    public function __construct(StockService $stocktService)
    {
        $this->stocktService = $stocktService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->stocktService->getViewsData();
        return view('inventory::stock.index', $data);
    }

    public function changeStock(Request $request)
    {
        $this->stocktService->changeStock($request->all());
        return redirect()->back()->withToastSuccess("Stock has been updated successfully.");
    }

    public function setDefault(Request $request)
    {
        $this->stocktService->setDefault($request->all());
        return redirect()->back()->withToastSuccess("Default value for stock has been set successfully.");
    }

    public function statusStock(Request $request)
    {
        $this->stocktService->statusStock($request->all());
        return redirect()->back()->withToastSuccess("The status of the stock has been changed successfully.");
    }
}
