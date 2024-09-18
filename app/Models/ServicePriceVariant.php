<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePriceVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'duration',
        'price_type',
        'price',
        // Include these if your table has these columns
        'name',
        'description',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}