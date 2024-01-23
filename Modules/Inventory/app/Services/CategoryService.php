<?php

namespace Modules\Inventory\app\Services;

use App\Repositories\CrudRepository;
use App\Traits\Crud;
use Modules\Branch\app\Services\BranchService;
use Modules\Inventory\app\Classes\InventoryClass;

class CategoryService extends InventoryClass
{
    protected $crudRepository;
    protected $branchService;
    protected $model;
    protected $branch;

    public function __construct(
        CrudRepository $crudRepository,
        BranchService $branchService
    )
    {
        $this->model = "\\Modules\\Inventory\\app\\Models\\Category";
        $this->crudRepository = $crudRepository;
        $this->branchService = $branchService;
        $this->branch = request()->branch;
    }

    public function modifyResponse($response)
    {
        return $response;
    }

    public function getBranches()
    {
        return $this->branchService->getAllWithoutPagination();
    }

    protected function createOrUpdateBranches($category, $branches, $flag='create')
    {
        if ($flag == 'update') {
            $category->branches()->delete();
        }

        if (count($branches) > 0) {
            foreach ($branches as $branch) {

                $clause = ['category_id' => $category->id];

                $categoryBranch['category_id'] = $category->id;
                $categoryBranch['branch_id'] = $branch;

                $category->branches()->updateOrCreate($clause, $categoryBranch);
            }
        }
    }

    public function createCategory($data)
    {
        $category = $this->create($data);
        $this->createOrUpdateBranches($category, $data['branch_id']);
        return $category;
    }

    public function updateCategory($data, $id)
    {
        $category = $this->getById($id);
        $updated = $this->update($data, $id);
        $category = $this->refresh($category);

        $this->createOrUpdateBranches($category, $data['branch_id'], 'update');

        return $category;
    }
}
