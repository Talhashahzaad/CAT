<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = [
        'order_id',
        'transaction_id',
        'user_id',
        'package_id',
        'payment_method',
        'payment_status',
        'base_amount',
        'base_currency',
        'paid_amount',
        'paid_currency',
        'purchase_date',
    ];
}