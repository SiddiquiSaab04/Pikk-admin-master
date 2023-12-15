<?php

namespace Modules\Inventory\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Inventory\Database\factories\ProductFactory;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        "name",
        "sku",
        "barcode",
        "preview_url",
        "description",
        "wholesale_price",
        "sale_price",
        "stock_checking",
        "sort_order",
        "status",
        "category_id",
        "addon_group_id"
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function addons()
    {
        return $this->hasMany(ProductModifier::class);
    }

    public function addonProducts()
    {
        return $this->hasManyThrough(ProductModifiersAddon::class, ProductModifier::class);
    }
}
