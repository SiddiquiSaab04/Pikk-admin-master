<?php

namespace Modules\Branch\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Branch\Database\factories\BranchFactory;

class Branch extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        "name",
        "address",
        "postcode",
        "phone",
        "multi_kitchen",
        "timings",
        "status",
        "closing_reason",
        "description"
    ];
}
