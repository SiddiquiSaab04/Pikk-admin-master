<?php

namespace Modules\Inventory\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Inventory\Database\factories\ProductModifierFactory;

class ProductModifier extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        "product_id",
        "modifier_id",
        "max_selection",
        "required"
    ];

    public function addonProducts()
    {
        return $this->hasMany(ProductModifiersAddon::class);
    }

    public function modifier()
    {
        return $this->hasOne(AddonGroup::class, 'id', 'modifier_id');
    }

    public function branches()
    {
        return $this->hasMany(AddonGroupBranch::class, 'addon_group_id', 'modifier_id');
    }
}
