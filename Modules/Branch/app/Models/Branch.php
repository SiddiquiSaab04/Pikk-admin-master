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
    protected $fillable = [];
    
    protected static function newFactory(): BranchFactory
    {
        //return BranchFactory::new();
    }
}
