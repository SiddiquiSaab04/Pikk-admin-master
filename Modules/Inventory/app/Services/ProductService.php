<?php

namespace Modules\Inventory\app\Services;

use App\Repositories\CrudRepository;
use App\Traits\Crud;

class ProductService
{
    use Crud;

    private $crudRepository;
    private $model;
    private $categories;
    private $modifierService;
    private $addons;
    private $productAddonService;

    public function __construct(
        CategoryService $categoryService,
        AddonGroupService $addonGroupService,
        ProductModifierService $modifierService,
        ProductModifiersAddonService $productAddonService,
        CrudRepository $crudRepository)
    {
        $this->crudRepository = $crudRepository;
        $this->addons = $addonGroupService;
        $this->categories = $categoryService;
        $this->modifierService = $modifierService;
        $this->productAddonService = $productAddonService;
        $this->model = "\\Modules\\Inventory\\app\\Models\\Product";
    }

    public function getCategories()
    {
        return $this->categories->getAllWithoutPagination();
    }

    public function getAddons()
    {
        $addons = $this->addons->getAllWithoutPagination();
        $addons->load('products');
        return $addons;
    }

    public function colorAssociation()
    {
        $categories = array_values($this->getCategories()->pluck('id')->toArray());
        return array_combine($categories, ['primary', 'info', 'warning', 'success']);
    }

    public function createProduct($data)
    {
        $data['product_addon'] = collect(json_decode($data['addons']), true);
        $product = $this->create($data);

        $addons = collect($data['product_addon']);

        foreach($addons as $addonData) {
            $addon = [
                "modifier_id" => $addonData->id,
                "product_id" => $product->id,
                "max_selection" => $addonData->max_selection
            ];

            $productModifier = $this->modifierService->create($addon);

            $products = collect($addonData->products)->filter( fn ($product) => $product->is_selected == 1 )->flatten();

            foreach ($products as $productData) {
                $addonProduct = [
                    "product_modifier_id" => $productModifier->id,
                    'product_id' => $productData->id
                ];

                $this->productAddonService->create($addonProduct);
            }
        }

        return $product;
    }
}
