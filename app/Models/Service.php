<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ServicePriceVariant;

class Service extends Model
{
    use HasFactory;

    public function priceVariants()
    {
        return $this->hasMany(ServicePriceVariant::class);
    }
}