<?php

namespace Modules\Inventory\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Branch\app\Models\Branch;
use Modules\Inventory\Database\factories\AddonGroupBranchFactory;

class AddonGroupBranch extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'branch_id',
        'addon_group_id'
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function addonGroup()
    {
        return $this->belongsTo(AddonGroup::class);
    }
}
