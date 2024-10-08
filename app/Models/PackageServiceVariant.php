<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageServiceVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_id',
        'treatment_name',
        'treatment_category',
        'variants',
        'duration',
        'price',
    ];


    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
