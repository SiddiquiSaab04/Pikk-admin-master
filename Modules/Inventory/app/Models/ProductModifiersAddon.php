<?php

namespace Modules\Inventory\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Inventory\Database\factories\ProductModifiersAddonFactory;

class ProductModifiersAddon extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        "product_modifier_id",
        "product_id",
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
