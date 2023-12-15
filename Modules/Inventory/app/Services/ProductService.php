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

    /**
     * @param null
     * @return Category
     */
    public function getCategories()
    {
        return $this->categories->getAllWithoutPagination();
    }

    /**
     * @param null
     * @return AddonGroup
     */
    public function getAddons()
    {
        $addons = $this->addons->getAllWithoutPagination();
        $addons->load('products');
        return $addons;
    }

    /**
     * returns color associated with each product category
     *
     * @param null
     * @return array
     */
    public function colorAssociation()
    {
        $categories = array_values($this->getCategories()->pluck('id')->toArray());
        return array_combine($categories, ['primary', 'info', 'warning', 'success']);
    }

    /**
     * Creates a new Product
     *
     * @param array $data
     * @return Product
     */
    public function createProduct($data)
    {
        $data['product_addon'] = collect(json_decode($data['addons']), true);
        $product = $this->create($data);

        $addons = collect($data['product_addon']);

        foreach($addons as $addonData) {
            /**
             * creating array for product_modifiers table
             */

            $addon = [
                "modifier_id" => $addonData->id,
                "product_id" => $product->id,
                "max_selection" => $addonData->max_selection
            ];

            $productModifier = $this->modifierService->create($addon);

            /**
             * we are only selecting the products where is_selected
             * field is 1, which means only selected products will
             * be inserted into the database
             */
            $products = collect($addonData->products)->filter( fn ($product) => $product->is_selected == 1 )->flatten();

            foreach ($products as $productData) {

                /**
                 * creating product_modifier_addons array for insertion
                 */
                $addonProduct = [
                    "product_modifier_id" => $productModifier->id,
                    'product_id' => $productData->id
                ];

                $this->productAddonService->create($addonProduct);
            }
        }

        return $product;
    }

    /**
     * Update an existing product
     *
     * @param array data
     * @param string id
     *
     * @return Product
     */
    public function updateProduct($data, $id)
    {
        $product = $this->getById($id);
        $product->load('category', 'addons.modifier', 'addons.addonProducts.product');
        $data['product_addon'] =(json_decode($data['addons']));

        $update = $this->update($data, $id);

        /**
         * fetch a fresh instance of product from database
         */
        $product = $this->refresh($product);

        /**
         * removing all exisiting record for the product modifers and
         * addons, we will insert a new row for each addon
         */
        $product->addons()->delete();
        $product->addonProducts()->delete();

        $addons = collect($data['product_addon']);

        foreach($addons as $addonData) {
            /**
             * checking if new addon is added for the existing product
             * if added then process data to insert into the database.
             * otherwise checking whether user has changed the products
             * for a specific addon
             *
             */
            if(empty($addonData->product_id)) {
                /**
                 * aligning data for eloquent update
                 */
                $addon = [
                    "modifier_id" => $addonData->id,
                    "product_id" => $product->id,
                    "max_selection" => $addonData->max_selection
                ];

                $productModifier = $this->modifierService->create($addon);
                $products = collect($addonData->products)->filter( fn ($product) => $product->is_selected == 1 )->flatten();

                foreach ($products as $productData) {
                    /**
                     * aligning data for eloquent update
                     */
                    $addonProduct = [
                        "product_modifier_id" => $productModifier->id,
                        'product_id' => $productData->id
                    ];

                    $this->productAddonService->create($addonProduct);
                }
            } else {
                $addon = [
                    "modifier_id" => $addonData->modifier_id,
                    "product_id" => $product->id,
                    "max_selection" => $addonData->max_selection
                ];

                $productModifier = $this->modifierService->create($addon);
                $products = collect($addonData->products)->filter( fn ($product) => $product->is_selected == 1 )->flatten();

                foreach ($products as $productData) {
                    $addonProduct = [
                        "product_modifier_id" => $productModifier->id,
                        'product_id' => $productData->product_id
                    ];

                    $this->productAddonService->create($addonProduct);
                }
            }
        }

        return $product;
    }
}
