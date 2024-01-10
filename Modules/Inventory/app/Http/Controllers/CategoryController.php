<?php

namespace Modules\Inventory\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Inventory\app\Http\Requests\CategoryRequest;
use Modules\Inventory\app\Services\CategoryService;

class CategoryController extends Controller
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = $this->categoryService->getAll();
        $categories->load('products', 'products.addons.modifier', 'products.addons.addonProducts.product.media', 'products.media');
        $categories = $this->categoryService->modifyResponse($categories);
        if(request()->wantsjson()) {
            return sendResponse(true, null, [
                $categories,
                ["title" => "Categories List",
                "description" => "show all categories list"],
                200
            ]);
        } else {
            return sendResponse(false, 'inventory::category.index', [
                "categories" => $categories,
                "title" => "Categories List",
                "description" => "show all categories list"
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('inventory::category.create', [
            "title" => "Create Category",
            "description" => "create a new category"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request): RedirectResponse
    {
        $data = $request->all();
        try {
            $created = $this->categoryService->create($data);
            return redirect()->route('category.index')->withToastSuccess("Category created successfully.");
        } catch(Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $category = $this->categoryService->search($id);
        if(request()->wantsjson()) {
            return sendResponse('inventory::category.index', [
                "categories" => $category,
                "title" => "Categories List",
                "description" => "show all categories list"
            ]);
        } else {
            return sendResponse(false, 'inventory::category.index', [
                "categories" => $category,
                "title" => "Categories List",
                "description" => "show all categories list"
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = $this->categoryService->getById($id);
        return view('inventory::category.edit', [
            "category" => $category,
            "title" => "Edit Category",
            "description" => "edit a new category"
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, $id): RedirectResponse
    {
        try {
            $data = $request->all();
            $updated = $this->categoryService->update($data, $id);
            return redirect()->route('category.index')->withToastSuccess("Category updated successfully.");
        } catch (Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $deleted = $this->categoryService->delete($id);
            return redirect()->route('category.index')->withToastSuccess("category deleted successfully.");
        } catch (Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }
}
