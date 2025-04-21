<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ServicePriceVariant;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'category',
        'total_price',
        'service_type',
        'slug',
        'description'
    ];

    public function priceVariants()
    {
        return $this->hasMany(ServicePriceVariant::class);
    }
    function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}