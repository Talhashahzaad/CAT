<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscription extends Model
{
    //

    use HasFactory;

    protected $fillable = [
        'user_id',
        'package_id',
        'order_id',
        'purchase_date',
        'expire_date',
        'status'
    ];
}