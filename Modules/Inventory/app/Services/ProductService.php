<?php

namespace Modules\Inventory\app\Services;

use App\Repositories\CrudRepository;
use Modules\Inventory\app\Classes\ProductClass;
use Modules\Branch\app\Services\BranchService;
use Modules\Media\app\Services\MediaService;

class ProductService extends ProductClass
{

    public $crudRepository;
    public $model;
    private $categories;
    private $modifierService;
    private $addons;
    private $productAddonService;
    private $productMediaService;
    private $mediaService;
    private $branchService;
    public $branch;
    public $productBranchModel;

    public function __construct(
        CategoryService $categoryService,
        AddonGroupService $addonGroupService,
        ProductModifierService $modifierService,
        ProductModifiersAddonService $productAddonService,
        ProductMediaService $productMediaService,
        CrudRepository $crudRepository,
        MediaService $mediaService,
        BranchService $branchService
    ) {
        $this->crudRepository = $crudRepository;
        $this->addons = $addonGroupService;
        $this->categories = $categoryService;
        $this->modifierService = $modifierService;
        $this->productAddonService = $productAddonService;
        $this->productMediaService = $productMediaService;
        $this->mediaService = $mediaService;
        $this->branchService = $branchService;
        $this->model = "\\Modules\\Inventory\\app\\Models\\Product";
        $this->branch = request()->branch;
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
        $colors = array_slice(['primary', 'info', 'warning', 'success', 'danger', 'secondary'], 0, count($categories));
        return array_combine($categories, $colors);
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
        $data['images'] = collect(json_decode($data['images']), true);

        $product = $this->create($data);

        $this->createOrUpdateBranches($product, $data['branch_id']);

        $addons = collect($data['product_addon']);
        $medias = collect($data['images']);

        foreach ($addons as $addonData) {
            /**
             * creating array for product_modifiers table
             */

            $addon = [
                "modifier_id" => $addonData->id,
                "product_id" => $product->id,
                "max_selection" => $addonData->max_selection,
                "required" => $addonData->required
            ];

            $productModifier = $this->modifierService->create($addon);

            /**
             * we are only selecting the products where is_selected
             * field is 1, which means only selected products will
             * be inserted into the database
             */
            $products = collect($addonData->products)->filter(fn ($product) => $product->is_selected == 1)->flatten();

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

        $this->createOrUpdateMedia($product, $medias, 'create');
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
        $product->load('category', 'addons.modifier', 'addons.addonProducts.product', 'media');
        $data['product_addon'] = (json_decode($data['addons']));
        $data['images'] = (json_decode($data['images']));

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
        $medias = collect($data['images']);


        foreach ($addons as $addonData) {
            /**
             * checking if new addon is added for the existing product
             * if added then process data to insert into the database.
             * otherwise checking whether user has changed the products
             * for a specific addon
             *
             */
            if (empty($addonData->product_id)) {
                /**
                 * aligning data for eloquent update
                 */
                $addon = [
                    "modifier_id" => $addonData->id,
                    "product_id" => $product->id,
                    "max_selection" => $addonData->max_selection,
                    "required" => $addonData->required
                ];

                $productModifier = $this->modifierService->create($addon);
                $products = collect($addonData->products)->filter(fn ($product) => $product->is_selected == 1)->flatten();

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
                    "max_selection" => $addonData->max_selection,
                    'required' => $addonData->required
                ];

                $productModifier = $this->modifierService->create($addon);
                $products = collect($addonData->products)->filter(fn ($product) => $product->is_selected == 1)->flatten();

                foreach ($products as $productData) {
                    $addonProduct = [
                        "product_modifier_id" => $productModifier->id,
                        'product_id' => $productData->product_id
                    ];

                    $this->productAddonService->create($addonProduct);
                }
            }
        }

        $this->createOrUpdateMedia($product, $medias, 'update');
        $this->createOrUpdateBranches($product, $data['branch_id'], 'update');
        return $product;
    }

    protected function createOrUpdateBranches($product, $branches, $flag='create')
    {
        if ($flag == 'update') {
            $product->branches()->delete();
        }

        if (count($branches) > 0) {
            foreach ($branches as $branch) {

                $clause = ['product_id' => $product->id];

                $productBranch['product_id'] = $product->id;
                $productBranch['branch_id'] = $branch;

                $product->branches()->updateOrCreate($clause, $productBranch);
            }
        }
    }

    public function createOrUpdateMedia($product, $medias, $type)
    {
        if ($type == 'update') {
            $product->media()->detach();
        }

        foreach ($medias as $media) {
            /**
             * creating product_media array for insertion
             */

            $productMedia = [
                "media_id" => $media->id,
                'product_id' => $product->id,
                'primary' => $media->primary
            ];

            $this->productMediaService->create($productMedia);
        }
    }

    public function getViewsData($id = 0)
    {
        $categories = $this->getCategories();
        $addons = $this->getAddons();
        $images = $this->mediaService->getAllWithoutPagination();
        $branches = $this->branchService->getAllWithoutPagination();
        $product = $this->getById($id);

        if ($id != 0) {
            $product->load('category', 'addons.modifier', 'addons.addonProducts.product', 'media', 'branches');
        }

        return [
            "product" => $product,
            'categories' => $categories,
            'addons' => $addons,
            'images' => $images->toJson(),
            'branches' => $branches,
            "selectedBranches" => $product ? $product->branches->map(fn ($branch) => $branch->branch_id)->values()->toArray() : [],
            'title' => 'Create Product',
            'description' => 'create a new product'
        ];
    }
}
