<?php

namespace Modules\Inventory\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Modules\Media\app\Models\Media;

class ProductStock extends Model
{
    use HasFactory;

    protected $table = 'product_stocks';
    protected $branch = null;

    public function setTableName($table)
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
        "is_new",
        "tags"
    ];

    public function setAvailableStockAttribute($value)
    {
        $tags = $this->attributes['tags'] == null ? "[]" : $this->attributes['tags'];
        $tags = json_decode($tags);
        $tag = $this->getTag('sold');

        if ($value <= 0) {
            if($tag) {
                if(!in_array($tag->url, $tags)) {
                    array_push($tags, $tag->url);
                }
            }

            $this->attributes['tags'] = json_encode($tags);
        } else {
            if($this->attributes['is_enabled'] != 0) {
                $tags = collect($tags)->reject(fn($t) => $t == $tag->url);
                $this->attributes['tags'] = json_encode($tags);
            }
        }

        $this->attributes['available_stock'] = $value;
    }

    public function setIsEnabledAttribute($value)
    {
        $tags = $this->attributes['tags'] == null ? "[]" : $this->attributes['tags'];
        $tags = json_decode($tags);
        $tag = $this->getTag('sold');

        if ($value == 0 ) {
            if($tag) {
                if(!in_array($tag->url, $tags)) {
                    array_push($tags, $tag->url);
                }
            }

            $this->attributes['tags'] = json_encode($tags);
        } else {
            if($this->attributes['available_stock'] > 0) {
                $tags = collect($tags)->reject(fn ($t) => $t == $tag->url);
                $this->attributes['tags'] = json_encode($tags);
            }

        }

        $this->attributes['is_enabled'] = $value;
    }

    public function setIsNewAttribute($value)
    {
        $tags = $this->attributes['tags'] == null ? "[]" : $this->attributes['tags'];
        $tags = json_decode($tags);
        $tag = $this->getTag('new');
        if($value == 1) {
            if($tag) {
                array_push($tags, $tag->url);
            }

            $this->attributes['tags'] = json_encode($tags);
        } else {
            $tags = collect($tags)->reject(fn ($t) => $t == $tag->url);
            $this->attributes['tags'] = json_encode($tags);
        }

        $this->attributes['is_new'] = $value;
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    protected function getTag($name)
    {
        return Media::where('name', $name)->first();
    }
}
