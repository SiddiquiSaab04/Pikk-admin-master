<?php

namespace Modules\Inventory\app\Services;

use Modules\Inventory\app\Repositories\AddonGroupRepository;

class AddonGroupService
{
    private $addonGroupRepository;

    public function __construct(AddonGroupRepository $addonGroupRepository)
    {
        $this->addonGroupRepository = $addonGroupRepository;
    }
}
