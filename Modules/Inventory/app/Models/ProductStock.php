<?php

namespace Modules\Inventory\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductStock extends Model
{
    use HasFactory;

    protected $table = 'product_stocks';
    protected $branch = null;

    public function setTableName(string $table)
    {
        if($table) {
            $this->table .= '_' . $table;
            $this->branch = $table;
        }
        return $this;
    }

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        "product_id",
        "is_enabled",
        "available_stock",
        "default_quantity",
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
