<?php

namespace Modules\Customers\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Modules\Customers\Database\factories\CustomerFactory;

class Customer extends Model
{
    use HasFactory, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        "name",
        "phone",
        "phone_verified",
        'cashback_points'
    ];
}
