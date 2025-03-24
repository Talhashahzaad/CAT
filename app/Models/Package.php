<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'category_id', // Make sure this is included
        'description',
        'price_type',
        'retail_price',
        'discount_percentage',
        'available_for',
    ];

    protected $casts = [
        'status' => 'boolean',
        'retail_price' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function packageServiceVariants()
    {
        return $this->hasMany(PackageServiceVariant::class, 'package_id');
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class)
            ->withPivot('variant_id')
            ->withTimestamps();
    }
}