<?php

namespace Modules\Inventory\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Media\app\Models\Media;

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
        "addon_group_id",
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function addons()
    {
        return $this->hasMany(ProductModifier::class)->where(function($query) {
            if(request()->branch != null) {
                $query->doesntHave('branches');
                $query->orWhereHas('branches', function($q) {
                    $q->where('branch_id', $this->branch);
                });
            }
        });;
    }

    public function addonProducts()
    {
        return $this->hasManyThrough(ProductModifiersAddon::class, ProductModifier::class);
    }

    public function media()
    {
        return $this->belongsToMany(Media::class, 'product_media', 'product_id', 'media_id')->withPivot('primary');
    }

    public function branches()
    {
        return $this->hasMany(ProductBranch::class);
    }

    public function stock()
    {
        $table = request()->branch ? 'product_stocks_' . request()->branch : 'product_stocks';
        $builder = ProductStock::query()->from($table);

        return $this->newHasOne($builder, $this, 'product_id', 'id');
    }
}
