<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Practitioner extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'listing_id',
        'name',
        'slug',
        'qualification',
        'certificate'
    ];

    public function packages()
    {
        return $this->hasMany(Package::class, 'user_id', 'user_id');
    }
}
