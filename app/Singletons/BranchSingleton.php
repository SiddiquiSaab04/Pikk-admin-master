<?php

namespace App\Singletons;

use Modules\Branch\app\Models\Branch;

class BranchSingleton
{
    private $branches;

    public function branches()
    {
        $this->branches = Branch::get();
        return $this->branches;
    }


}
