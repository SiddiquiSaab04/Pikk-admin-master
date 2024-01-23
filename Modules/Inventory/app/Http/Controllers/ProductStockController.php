<?php

namespace Modules\Inventory\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Inventory\app\Services\StockService;

class ProductStockController extends Controller
{
    private $stockService;

    public function __construct(StockService $stocktService)
    {
        $this->stockService = $stocktService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->stockService->getViewsData();
        return view('inventory::stock.index', $data);
    }

    public function manageStock(Request $request)
    {
        $record = $this->stockService->manageStock($request->all());
        return sendResponse(true, null, $record, 'Stock has been updated successfully.', 200);
    }
}
