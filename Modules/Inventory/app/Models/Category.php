<?php

namespace Modules\Inventory\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        "name",
        "description",
        "preview_url",
        "display"
    ];

    public function products ()
    {
        return $this->hasMany(Product::class)->where(function($query) {
            if(request()->branch != null) {
                $query->doesntHave('branches');
                $query->orWhereHas('branches', function($q) {
                    $q->where('branch_id', $this->branch);
                });
            }
        });
    }
}
