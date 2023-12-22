<?php

namespace Modules\Order\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Inventory\app\Models\Product;

class OrderProductAddon extends Model
{
    use HasFactory;

    protected $table = 'order_product_addons';
    protected $branch = null;

    public function setTableName(string $table)
    {
        if($table) {
            $this->table .= '_' . $table;
            $this->branch = $table;
        }

        return $this->$table;
    }

    protected $fillable = [
        "order_id",
        "order_product_id",
        "product_id",
        "product_name",
        "quantity",
        "unit_price",
        "total_price",
    ];

    public function orderProduct()
    {
        return $this->belongsTo(OrderProduct::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
