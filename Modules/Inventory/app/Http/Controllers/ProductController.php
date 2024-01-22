<?php

namespace Modules\Inventory\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Inventory\app\Http\Requests\ProductRequest;
use Modules\Inventory\app\Resources\ProductResource;
use Modules\Inventory\app\Services\ProductService;
use stdClass;

class ProductController extends Controller
{
    private $productService;


    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = $this->productService->getAll();
        $products->load('category', 'addons.modifier', 'addons.addonProducts.product');

        $colors = $this->productService->colorAssociation();

        if (request()->wantsjson()) {
            return sendResponse(
                true,
                null,
                $products->groupBy("category.name"),
                null,
                200
            );
        } else {
            return sendResponse(false, 'inventory::products.index', [
                "products" => $products,
                "colors" => $colors,
                "title" => "Products List",
                "description" => "show all products listing"
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = $this->productService->getViewsData(0);

        return view('inventory::products.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request): RedirectResponse
    {
        try {
            $data = $request->all();
            $created = $this->productService->createProduct($data);
            return redirect()->route('product.index')->withToastSuccess("Product created successfully.");
        } catch (Exception $e) {
            return back()->withToastError($e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getLine());
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $product = $this->productService->search($id);
        if (request()->wantsjson()) {
            return sendResponse('inventory::products.index', [
                "product" => $product,
                "title" => "Products List",
                "description" => "show all products listing"
            ]);
        } else {
            return sendResponse(false, 'inventory::products.index', [
                "product" => $product,
                "title" => "Products List",
                "description" => "show all products listing"
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = $this->productService->getViewsData($id);
        return view('inventory::products.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
                try {
            $data = $request->all();
            $updated = $this->productService->updateProduct($data, $id);
            return redirect()->route('product.index')->withToastSuccess("Product updated successfully.");
        } catch (Exception $e) {
            return back()->withToastError($e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getLine());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $deleted = $this->productService->delete($id);
            return redirect()->route('product.index')->withToastSuccess("Product deleted successfully.");
        } catch (Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }
}
