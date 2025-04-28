<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayPalSession extends Model
{
    protected $table = 'paypal_sessions'; // Your table name

    protected $fillable = [
        'token',
        'user_id',
        'package_id',
        'amount',
        'currency',

    ];
}