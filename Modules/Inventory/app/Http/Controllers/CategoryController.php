<?php

namespace Modules\Inventory\app\Http\Controllers;

use App\Http\Controllers\Controller;
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
        if(request()->wantsjson()) {
            return sendResponse('inventory::category.index', [
                "categories" => $categories,
                "title" => "Categories List",
                "description" => "show all categories list"
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
        $created = $this->categoryService->create($data);
        return redirect()->route('category.index');
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
        $data = $request->all();
        $updated = $this->categoryService->update($data, $id);
        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $deleted = $this->categoryService->delete($id);
        return redirect()->route('category.index');
    }
}
