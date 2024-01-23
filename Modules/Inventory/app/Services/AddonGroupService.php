<?php

namespace Modules\Inventory\app\Services;

use App\Repositories\CrudRepository;
use App\Traits\Crud;
use Modules\Branch\app\Services\BranchService;
use Modules\Inventory\app\Classes\InventoryClass;
use Modules\Inventory\app\Repositories\AddonGroupRepository;

class AddonGroupService extends InventoryClass
{

    public $crudRepository;
    public $model;
    public $branch;
    public $branchService;

    public function __construct(
        CrudRepository $crudRepository,
        BranchService $branchService
    )
    {
        $this->crudRepository = $crudRepository;
        $this->model = "\\Modules\\Inventory\\app\\Models\\AddonGroup";
        $this->branch = request()->branch;
        $this->branchService = $branchService;
    }

    public function getBranches()
    {
        return $this->branchService->getAllWithoutPagination();
    }

    public function createAddonGroup($data)
    {
        $addonGroup = $this->create($data);
        $this->createOrUpdateBranches($addonGroup, $data['branch_id']);
        return $addonGroup;
    }

    public function updateAddonGroup($data, $id)
    {
        $addonGroup = $this->getById($id);
        $updated = $this->update($data, $id);
        $addonGroup = $this->refresh($addonGroup);

        $this->createOrUpdateBranches($addonGroup, $data['branch_id'], 'update');

        return $addonGroup;
    }

    protected function createOrUpdateBranches($addonGroup, $branches, $flag='create')
    {
        if ($flag == 'update') {
            $addonGroup->branches()->delete();
        }

        if (count($branches) > 0) {
            foreach ($branches as $branch) {

                $clause = ['addon_group_id' => $addonGroup->id];

                $addonGroupBranch['addon_group_id'] = $addonGroup->id;
                $addonGroupBranch['branch_id'] = $branch;

                $addonGroup->branches()->updateOrCreate($clause, $addonGroupBranch);
            }
        }
    }

}
