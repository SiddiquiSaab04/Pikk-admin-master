<?php

namespace Modules\Inventory\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Inventory\app\Http\Requests\ProductRequest;
use Modules\Inventory\app\Resources\ProductResource;
use Modules\Inventory\app\Services\ProductService;

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

        if(request()->wantsjson()) {
            return sendResponse(true, null,
                ProductResource::make($products),
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
        $categories = $this->productService->getCategories();
        $addons = $this->productService->getAddons();

        return view('inventory::products.create', [
            'categories' => $categories,
            'addons' => $addons,
            'title' => 'Create Product',
            'description' => 'create a new product'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request): RedirectResponse
    {
        $data = $request->all();
        $created = $this->productService->createProduct($data);
        return redirect()->route('product.index');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $product = $this->productService->search($id);
        if(request()->wantsjson()) {
            return sendResponse('inventory::product.index', [
                "product" => $product,
                "title" => "Products List",
                "description" => "show all products listing"
            ]);
        } else {
            return sendResponse(false, 'inventory::product.index', [
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
        $addonGroup = $this->productService->getById($id);
        return view('inventory::product.edit', [
            "addonGroup" => $addonGroup,
            "title" => "Edit product",
            "description" => "edit a product"
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $data = $request->all();
        $updated = $this->productService->update($data, $id);
        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $deleted = $this->productService->delete($id);
        return redirect()->route('product.index');
    }
}
