<?php

namespace Modules\Order\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Order\app\Models\OrderProduct;
use Modules\Order\app\Models\OrderProductAddon;
class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
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
        "customer_id",
        "code",
        "title",
        "type",
        "note",
        "status",
        "platform",
        "payment",
        "wallet",
        "discount",
        "discount_type",
        "total",
        "sub_total",
        "cancelled_reason",
    ];

    public function orderProducts()
    {
        // $orderProducts = new OrderProduct();
        // $orderProducts->setTableName($this->branch);
        // dd(OrderProduct::class);
        return $this->hasMany(OrderProduct::class);
    }

    public function orderProductAddons()
    {
        return $this->hasMany(OrderProductAddon::class);
    }

    public function addons()
    {
        return $this->hasManyThrough(OrderProductAddon::class, OrderProduct::class);
    }
}
